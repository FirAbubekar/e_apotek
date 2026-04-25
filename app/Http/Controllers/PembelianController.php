<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\DetailPembelian;
use App\Models\Supplier;
use App\Models\Obat;
use App\Models\MedicineBatch;
use App\Models\MedicineStock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PembelianController extends Controller
{
    /**
     * Daftar semua transaksi pembelian
     */
    public function index()
    {
        $pembelians = Pembelian::with('supplier', 'user')
            ->orderBy('tanggal_pembelian', 'desc')
            ->get();

        $totalPembelian  = $pembelians->count();
        $totalNilai      = $pembelians->sum('total_harga');
        $bulanIni        = $pembelians->filter(fn($p) => Carbon::parse($p->tanggal_pembelian)->isCurrentMonth())->count();

        return view('transaksi.pembelian.index', compact('pembelians', 'totalPembelian', 'totalNilai', 'bulanIni'));
    }

    /**
     * Form buat transaksi pembelian baru (POS style)
     */
    public function create()
    {
        $suppliers = Supplier::orderBy('supplier_name')->get();
        $obats     = Obat::with('satuan')->where('is_active', 1)->orWhereNull('is_active')->orderBy('medicine_name')->get();
        $noFaktur  = $this->generateNoFaktur();

        return view('transaksi.pembelian.create', compact('suppliers', 'obats', 'noFaktur'));
    }

    /**
     * Simpan transaksi pembelian
     */
    public function store(Request $request)
    {
        $request->validate([
            'no_faktur'                   => 'required|string|unique:pembelian,no_faktur',
            'supplier_id'                 => 'required|exists:suppliers,id',
            'tanggal_pembelian'           => 'required|date',
            'items'                       => 'required|array|min:1',
            'items.*.obat_id'             => 'required|exists:medicines,id',
            'items.*.jumlah'              => 'required|integer|min:1',
            'items.*.harga_satuan'        => 'required|numeric|min:0',
            'items.*.batch_number'        => 'required|string|max:100',
            'items.*.expired_date'        => 'nullable|date',
        ], [
            'no_faktur.required'          => 'Nomor faktur wajib diisi.',
            'no_faktur.unique'            => 'Nomor faktur sudah digunakan.',
            'supplier_id.required'        => 'Supplier wajib dipilih.',
            'items.required'              => 'Item pembelian tidak boleh kosong.',
            'items.min'                   => 'Minimal 1 item pembelian.',
            'items.*.batch_number.required' => 'Batch number wajib diisi untuk setiap item.',
        ]);

        DB::transaction(function () use ($request) {
            $totalHarga = 0;
            foreach ($request->items as $item) {
                $totalHarga += $item['jumlah'] * $item['harga_satuan'];
            }

            // 1. Simpan header pembelian
            $pembelian = Pembelian::create([
                'no_faktur'         => $request->no_faktur,
                'supplier_id'       => $request->supplier_id,
                'user_id'           => Auth::id(),
                'tanggal_pembelian' => $request->tanggal_pembelian,
                'total_harga'       => $totalHarga,
            ]);

            foreach ($request->items as $idx => $item) {
                // 2. Simpan detail pembelian
                DetailPembelian::create([
                    'pembelian_id'  => $pembelian->id,
                    'obat_id'       => $item['obat_id'],
                    'jumlah'        => $item['jumlah'],
                    'harga_satuan'  => $item['harga_satuan'],
                    'subtotal'      => $item['jumlah'] * $item['harga_satuan'],
                ]);

                // 3. Buat record batch obat
                $batch = MedicineBatch::create([
                    'medicine_id'    => $item['obat_id'],
                    'pembelian_id'   => $pembelian->id,
                    'batch_number'   => $item['batch_number'],
                    'expired_date'   => $item['expired_date'] ?: null,
                    'purchase_price' => $item['harga_satuan'],
                    'selling_price'  => Obat::find($item['obat_id'])->selling_price ?? $item['harga_satuan'],
                    'created_by'     => Auth::id(),
                ]);

                // 4. Tambah stok pada medicine_stocks
                $ms = MedicineStock::create([
                    'medicine_id' => $item['obat_id'],
                    'batch_id'    => $batch->id,
                    'stock_qty'   => $item['jumlah'],
                    'stock_in'    => $item['jumlah'],
                    'stock_out'   => 0,
                    'last_stock'  => $item['jumlah'],
                    'created_by'  => Auth::id(),
                ]);

                // Record Mutation for audit trail
                \App\Models\StockMutation::create([
                    'medicine_stock_id' => $ms->id,
                    'type'              => 'Masuk',
                    'qty_change'        => $item['jumlah'],
                    'qty_before'        => 0,
                    'qty_after'         => $item['jumlah'],
                    'reference'         => 'Pembelian #' . $pembelian->no_faktur,
                    'user_id'           => Auth::id(),
                    'notes'             => 'Penerimaan stok dari supplier',
                ]);
            }
        });

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil disimpan dan stok diperbarui!');
    }

    /**
     * Detail transaksi pembelian
     */
    public function show($id)
    {
        $pembelian = Pembelian::with('supplier', 'user', 'detailPembelian.obat.satuan')->findOrFail($id);
        $apotek = \App\Models\Apotik::first();
        return view('transaksi.pembelian.show', compact('pembelian', 'apotek'));
    }

    /**
     * Hapus transaksi pembelian
     */
    public function destroy($id)
    {
        $pembelian = Pembelian::findOrFail($id);
        $pembelian->detailPembelian()->delete();
        $pembelian->delete();

        return redirect()->route('pembelian.index')->with('success', 'Transaksi pembelian berhasil dihapus!');
    }

    /**
     * Generate nomor faktur otomatis
     */
    private function generateNoFaktur()
    {
        $prefix = 'PBL-' . date('Ymd') . '-';
        $last   = Pembelian::where('no_faktur', 'like', $prefix . '%')
            ->orderBy('no_faktur', 'desc')
            ->first();

        $seq = $last ? (intval(substr($last->no_faktur, -3)) + 1) : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
