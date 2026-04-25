<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\Customer;
use App\Models\Obat;
use App\Models\MedicineStock;
use App\Models\StockMutation;
use App\Models\CashTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PenjualanController extends Controller
{
    /**
     * Daftar riwayat transaksi penjualan
     */
    public function index()
    {
        $penjualans = Penjualan::with('pelanggan', 'user')
            ->orderBy('tanggal_penjualan', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $totalPenjualan = $penjualans->count();
        $totalNilai     = $penjualans->sum('total_harga');
        $hariIni        = $penjualans->filter(fn($p) => Carbon::parse($p->tanggal_penjualan)->isToday())->count();

        return view('transaksi.penjualan.index', compact('penjualans', 'totalPenjualan', 'totalNilai', 'hariIni'));
    }

    /**
     * Form kasir / POS
     */
    public function create()
    {
        $pelanggans   = Customer::orderBy('nama')->get();
        $obats        = Obat::with(['satuan', 'medicineStocks' => function($q) {
                            $q->where('stock_qty', '>', 0);
                        }])
                        ->where('is_active', 1)
                        ->orWhereNull('is_active')
                        ->orderBy('medicine_name')
                        ->get();
        
        $noTransaksi = $this->generateNoTransaksi();

        return view('transaksi.penjualan.create', compact('pelanggans', 'obats', 'noTransaksi'));
    }

    /**
     * Simpan transaksi penjualan
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_transaksi'      => 'required|unique:penjualan,no_transaksi',
            'pelanggan_id'      => 'nullable|exists:customers,id',
            'tanggal_penjualan' => 'required|date',
            'tipe_penjualan'    => 'required|in:Retail,Resep',
            'metode_pembayaran' => 'required|in:Tunai,Debit,Transfer,QRIS',
            'subtotal'          => 'required|numeric|min:0',
            'diskon'            => 'required|numeric|min:0',
            'ppn'               => 'required|numeric|min:0',
            'total_harga'       => 'required|numeric|min:0',
            'bayar'             => 'required|numeric|min:0',
            'dokter'            => 'nullable|string|max:255',
            'no_resep'          => 'nullable|string|max:255',
            'items'             => 'required|array|min:1',
            'items.*.obat_id'   => 'required|exists:medicines,id',
            'items.*.jumlah'    => 'required|integer|min:1',
            'items.*.harga'     => 'required|numeric|min:0',
        ]);

        try {
            DB::beginTransaction();

            if ($request->metode_pembayaran !== 'Tunai') {
                $bayar = $request->total_harga;
                $kembali = 0;
            } else {
                if ($request->bayar < $request->total_harga) {
                    return back()->withErrors(['bayar' => 'Jumlah bayar kurang dari total harga.'])->withInput();
                }
                $bayar = $request->bayar;
                $kembali = $bayar - $request->total_harga;
            }

            // 1. Simpan Header Penjualan
            $penjualan = Penjualan::create([
                'no_transaksi'      => $request->no_transaksi,
                'pelanggan_id'      => $request->pelanggan_id,
                'user_id'           => Auth::id(),
                'tanggal_penjualan' => $request->tanggal_penjualan,
                'subtotal'          => $request->subtotal,
                'diskon'            => $request->diskon,
                'ppn'               => $request->ppn,
                'tipe_penjualan'    => $request->tipe_penjualan,
                'metode_pembayaran' => $request->metode_pembayaran,
                'dokter'            => $request->dokter,
                'no_resep'          => $request->no_resep,
                'total_harga'       => $request->total_harga,
                'bayar'             => $bayar,
                'kembali'           => $kembali,
            ]);

            foreach ($request->items as $item) {
                $obatId = $item['obat_id'];
                $qtyNeeded = $item['jumlah'];

                // 2. Simpan Detail Penjualan
                DetailPenjualan::create([
                    'penjualan_id' => $penjualan->id,
                    'obat_id'      => $obatId,
                    'jumlah'       => $qtyNeeded,
                    'harga_satuan' => $item['harga'],
                    'subtotal'     => $qtyNeeded * $item['harga'],
                ]);

                // 3. Potong Stok (FIFO based on medicine_stocks)
                $stocks = MedicineStock::where('medicine_stocks.medicine_id', $obatId)
                    ->where('medicine_stocks.stock_qty', '>', 0)
                    ->join('medicine_batches', 'medicine_stocks.batch_id', '=', 'medicine_batches.id')
                    ->orderBy('medicine_batches.expired_date', 'asc') // Expiry prioritized
                    ->orderBy('medicine_stocks.created_at', 'asc')
                    ->select('medicine_stocks.*')
                    ->get();

                $remainingToDeduct = $qtyNeeded;

                foreach ($stocks as $stock) {
                    if ($remainingToDeduct <= 0) break;

                    $deductNow = min($remainingToDeduct, $stock->stock_qty);
                    
                    $qtyBefore = $stock->stock_qty;
                    $stock->stock_qty -= $deductNow;
                    $stock->stock_out += $deductNow;
                    $stock->last_stock = $stock->stock_qty;
                    $stock->save();

                    // 4. Catat Mutasi Stok
                    StockMutation::create([
                        'medicine_stock_id' => $stock->id,
                        'type'              => 'Keluar',
                        'qty_change'        => $deductNow,
                        'qty_before'        => $qtyBefore,
                        'qty_after'         => $stock->stock_qty,
                        'reference'         => 'Penjualan #' . $penjualan->no_transaksi,
                        'user_id'           => Auth::id(),
                        'notes'             => 'Penjualan ' . strtolower($request->tipe_penjualan),
                    ]);

                    $remainingToDeduct -= $deductNow;
                }

                if ($remainingToDeduct > 0) {
                    throw new \Exception("Stok tidak mencukupi untuk Obat ID: " . $obatId);
                }
            }
            // 5. Record to Cash Transaction (Automatic)
            CashTransaction::create([
                'no_transaksi' => $this->generateNoCashTransaksi(),
                'type' => 'Masuk',
                'category' => 'Penjualan',
                'amount' => $request->total_harga, // Assuming total_harga is the final amount
                'description' => 'Pendapatan dari transaksi ' . $request->no_transaksi,
                'transaction_date' => $request->tanggal_penjualan . ' ' . date('H:i:s'),
                'reference_type' => 'Penjualan',
                'reference_id' => $penjualan->id,
                'user_id' => Auth::id(),
            ]);

            DB::commit();
            return redirect()->route('penjualan.index')->with('success', 'Transaksi penjualan berhasil disimpan!');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    /**
     * Detail transaksi penjualan
     */
    public function show($id)
    {
        $penjualan = Penjualan::with(['pelanggan', 'user', 'detailPenjualan.obat.satuan'])->findOrFail($id);
        $apotek = \App\Models\Apotik::first();
        return view('transaksi.penjualan.show', compact('penjualan', 'apotek'));
    }

    /**
     * Generate nomor transaksi otomatis
     */
    private function generateNoTransaksi()
    {
        $prefix = 'PJN-' . date('Ymd') . '-';
        $last   = Penjualan::where('no_transaksi', 'like', $prefix . '%')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        $seq = $last ? (intval(substr($last->no_transaksi, -3)) + 1) : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }

    private function generateNoCashTransaksi()
    {
        $date = date('Ymd');
        $lastTransaction = CashTransaction::where('no_transaksi', 'like', 'KSM-' . $date . '-%')
            ->orderBy('no_transaksi', 'desc')
            ->first();

        if ($lastTransaction) {
            $lastNo = explode('-', $lastTransaction->no_transaksi);
            $sequence = intval(end($lastNo)) + 1;
        } else {
            $sequence = 1;
        }

        return 'KSM-' . $date . '-' . str_pad($sequence, 3, '0', STR_PAD_LEFT);
    }
}
