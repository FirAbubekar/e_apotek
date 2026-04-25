<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\ReturnPembelian;
use App\Models\DetailReturnPembelian;
use App\Models\DetailPembelian;
use App\Models\MedicineStock;
use App\Models\StockMutation;
use App\Models\Obat;
use App\Models\Apotik;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ReturnPembelianController extends Controller
{
    public function index()
    {
        $returns = ReturnPembelian::with('pembelian.supplier', 'user')
            ->orderBy('tanggal_return', 'desc')
            ->get();

        $stats = [
            'total_count' => $returns->count(),
            'total_value' => $returns->sum('total_return'),
            'this_month_count' => $returns->filter(fn($r) => Carbon::parse($r->tanggal_return)->isCurrentMonth())->count(),
            'this_month_value' => $returns->filter(fn($r) => Carbon::parse($r->tanggal_return)->isCurrentMonth())->sum('total_return'),
        ];

        return view('transaksi.return_pembelian.index', compact('returns', 'stats'));
    }

    public function create(Request $request)
    {
        $pembelian = null;
        if ($request->has('no_faktur')) {
            $pembelian = Pembelian::with('supplier', 'detailPembelian.obat.satuan')
                ->where('no_faktur', $request->no_faktur)
                ->first();
            
            if (!$pembelian) {
                return redirect()->back()->with('error', 'Nomor faktur tidak ditemukan.');
            }
        }

        $noReturn = $this->generateNoReturn();
        return view('transaksi.return_pembelian.create', compact('pembelian', 'noReturn'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pembelian_id' => 'required|exists:pembelian,id',
            'no_return' => 'required|unique:return_pembelian,no_return',
            'tanggal_return' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:medicines,id',
            'items.*.jumlah' => 'required|integer|min:0',
        ]);

        // Custom validation: at least one item must have qty > 0
        $hasQty = false;
        foreach ($request->items as $item) {
            if ($item['jumlah'] > 0) {
                $hasQty = true;
                break;
            }
        }

        if (!$hasQty) {
            return redirect()->back()->with('error', 'Silakan masukkan jumlah barang yang akan direturn (minimal 1 item).')->withInput();
        }

        try {
            return DB::transaction(function () use ($request) {
                $totalReturn = 0;
                
                // 1. Create Header
                $returnPb = ReturnPembelian::create([
                    'no_return' => $request->no_return,
                    'pembelian_id' => $request->pembelian_id,
                    'user_id' => Auth::id(),
                    'tanggal_return' => $request->tanggal_return,
                    'total_return' => 0, // Will be updated
                    'alasan' => $request->alasan,
                ]);

                foreach ($request->items as $item) {
                    if ($item['jumlah'] <= 0) continue;

                    $detailBeli = DetailPembelian::where('pembelian_id', $request->pembelian_id)
                        ->where('obat_id', $item['obat_id'])
                        ->first();

                    if (!$detailBeli) {
                        throw new \Exception("Obat tidak ditemukan dalam faktur asal.");
                    }

                    // Check if return quantity <= original purchase quantity
                    // (Ideally we should also track previous returns for this item)
                    $previousReturnQty = DetailReturnPembelian::whereHas('header', function($q) use ($request) {
                        $q->where('pembelian_id', $request->pembelian_id);
                    })->where('obat_id', $item['obat_id'])->sum('jumlah');

                    if (($previousReturnQty + $item['jumlah']) > $detailBeli->jumlah) {
                        throw new \Exception("Total jumlah return melebihi jumlah pembelian asal.");
                    }

                    // 2. Find specific stock from this purchase batch
                    // In our system, batch is linked to pembelian_id
                    $batch = \App\Models\MedicineBatch::where('pembelian_id', $request->pembelian_id)
                        ->where('medicine_id', $item['obat_id'])
                        ->first();
                    
                    if (!$batch) {
                        throw new \Exception("Batch untuk obat " . $detailBeli->obat->medicine_name . " tidak ditemukan.");
                    }

                    $medicineStock = MedicineStock::where('batch_id', $batch->id)->first();
                    
                    if (!$medicineStock || $medicineStock->last_stock < $item['jumlah']) {
                        throw new \Exception("Stok tidak mencukupi untuk return obat " . $detailBeli->obat->medicine_name);
                    }

                    $subtotal = $item['jumlah'] * $detailBeli->harga_satuan;
                    $totalReturn += $subtotal;

                    // 3. Save Detail Return
                    DetailReturnPembelian::create([
                        'return_pembelian_id' => $returnPb->id,
                        'obat_id' => $item['obat_id'],
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $detailBeli->harga_satuan,
                        'subtotal' => $subtotal,
                    ]);

                    // 4. Update Stock
                    $qtyBefore = $medicineStock->last_stock;
                    $medicineStock->stock_out += $item['jumlah'];
                    $medicineStock->last_stock -= $item['jumlah'];
                    $medicineStock->save();

                    // 5. Record Mutation
                    StockMutation::create([
                        'medicine_stock_id' => $medicineStock->id,
                        'type' => 'Keluar',
                        'qty_change' => $item['jumlah'],
                        'qty_before' => $qtyBefore,
                        'qty_after' => $medicineStock->last_stock,
                        'reference' => 'Return Pembelian #' . $returnPb->no_return,
                        'user_id' => Auth::id(),
                        'notes' => 'Pengembalian barang ke supplier (Retur)',
                    ]);
                }

                $returnPb->update(['total_return' => $totalReturn]);

                return redirect()->route('return-pembelian.show', $returnPb->id)
                    ->with('success', 'Transaksi return berhasil disimpan.');
            });
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $return = ReturnPembelian::with('pembelian.supplier', 'user', 'details.obat.satuan')->findOrFail($id);
        $apotek = Apotik::first();
        return view('transaksi.return_pembelian.show', compact('return', 'apotek'));
    }

    private function generateNoReturn()
    {
        $prefix = 'RJB-' . date('Ymd') . '-';
        $last = ReturnPembelian::where('no_return', 'like', $prefix . '%')
            ->orderBy('no_return', 'desc')
            ->first();

        $seq = $last ? (intval(substr($last->no_return, -3)) + 1) : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
