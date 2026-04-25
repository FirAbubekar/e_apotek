<?php

namespace App\Http\Controllers;

use App\Models\ReturnPenjualan;
use App\Models\DetailReturnPenjualan;
use App\Models\Penjualan;
use App\Models\DetailPenjualan;
use App\Models\MedicineStock;
use App\Models\StockMutation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReturnPenjualanController extends Controller
{
    public function index()
    {
        $returns = ReturnPenjualan::with(['penjualan.pelanggan', 'user'])
            ->orderBy('created_at', 'desc')
            ->get();

        $stats = [
            'total_count' => $returns->count(),
            'total_value' => $returns->sum('total_return'),
            'this_month_count' => $returns->filter(fn($r) => $r->created_at->isCurrentMonth())->count()
        ];

        return view('transaksi.return_penjualan.index', compact('returns', 'stats'));
    }

    public function create(Request $request)
    {
        $penjualan = null;
        if ($request->has('no_transaksi')) {
            $penjualan = Penjualan::with(['pelanggan', 'detailPenjualan.obat'])
                ->where('no_transaksi', $request->no_transaksi)
                ->first();
            
            if (!$penjualan) {
                return back()->with('error', 'Nomor transaksi tidak ditemukan.')->withInput();
            }

            // Calculate already returned quantities
            foreach ($penjualan->detailPenjualan as $detail) {
                $alreadyReturned = DetailReturnPenjualan::whereHas('header', function($q) use ($penjualan) {
                        $q->where('penjualan_id', $penjualan->id);
                    })
                    ->where('obat_id', $detail->obat_id)
                    ->sum('jumlah');
                
                $detail->max_return = $detail->jumlah - $alreadyReturned;
            }
        }

        $noReturn = $this->generateNoReturn();

        return view('transaksi.return_penjualan.create', compact('penjualan', 'noReturn'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'penjualan_id' => 'required|exists:penjualan,id',
            'no_return_pj' => 'required|unique:return_penjualan,no_return_pj',
            'tanggal_return' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.obat_id' => 'required|exists:medicines,id',
            'items.*.jumlah' => 'required|integer|min:0',
        ]);

        $hasQty = false;
        foreach ($request->items as $item) {
            if ($item['jumlah'] > 0) $hasQty = true;
        }
        if (!$hasQty) {
            return back()->with('error', 'Masukkan minimal 1 jumlah barang yang direturn.')->withInput();
        }

        try {
            return DB::transaction(function () use ($request) {
                $totalReturn = 0;
                
                // 1. Create Header
                $returnHeader = ReturnPenjualan::create([
                    'no_return_pj' => $request->no_return_pj,
                    'penjualan_id' => $request->penjualan_id,
                    'user_id' => Auth::id(),
                    'tanggal_return' => $request->tanggal_return,
                    'total_return' => 0, // Update later
                    'alasan' => $request->alasan,
                ]);

                foreach ($request->items as $item) {
                    if ($item['jumlah'] <= 0) continue;

                    $originalDetail = DetailPenjualan::where('penjualan_id', $request->penjualan_id)
                        ->where('obat_id', $item['obat_id'])
                        ->first();

                    if (!$originalDetail) continue;

                    // Validate vs previous returns
                    $alreadyReturned = DetailReturnPenjualan::whereHas('header', function($q) use ($request) {
                            $q->where('penjualan_id', $request->penjualan_id);
                        })
                        ->where('obat_id', $item['obat_id'])
                        ->sum('jumlah');

                    if (($alreadyReturned + $item['jumlah']) > $originalDetail->jumlah) {
                        throw new \Exception("Jumlah return melebihi sisa barang yang bisa direturn untuk " . $originalDetail->obat->medicine_name);
                    }

                    $subtotal = $item['jumlah'] * $originalDetail->harga_satuan;
                    
                    // 2. Create Detail
                    DetailReturnPenjualan::create([
                        'return_penjualan_id' => $returnHeader->id,
                        'obat_id' => $item['obat_id'],
                        'jumlah' => $item['jumlah'],
                        'harga_satuan' => $originalDetail->harga_satuan,
                        'subtotal' => $subtotal,
                    ]);

                    $totalReturn += $subtotal;

                    // 3. Increment Stock (FIFO Logic Reversal - Put into oldest active stock)
                    $stock = MedicineStock::where('medicine_id', $item['obat_id'])
                        ->orderBy('created_at', 'asc') // Target oldest batch
                        ->first();

                    if (!$stock) {
                        // If somehow no stock record exists (should not happen), create one or fail
                        throw new \Exception("Record stok tidak ditemukan untuk obat: " . $originalDetail->obat->medicine_name);
                    }

                    $qtyBefore = $stock->stock_qty;
                    $stock->stock_qty += $item['jumlah'];
                    $stock->stock_in += $item['jumlah'];
                    $stock->last_stock = $stock->stock_qty;
                    $stock->save();

                    // 4. Record Mutation
                    StockMutation::create([
                        'medicine_stock_id' => $stock->id,
                        'type' => 'Masuk',
                        'qty_change' => $item['jumlah'],
                        'qty_before' => $qtyBefore,
                        'qty_after' => $stock->stock_qty,
                        'reference' => 'Return Penjualan #' . $returnHeader->no_return_pj,
                        'user_id' => Auth::id(),
                        'notes' => 'Sales Return ' . $request->no_return_pj,
                    ]);
                }

                $returnHeader->update(['total_return' => $totalReturn]);

                return redirect()->route('return-penjualan.show', $returnHeader->id)
                    ->with('success', 'Transaksi return penjualan berhasil disimpan!');
            });
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage())->withInput();
        }
    }

    public function show($id)
    {
        $return = ReturnPenjualan::with(['penjualan.pelanggan', 'user', 'details.obat.satuan'])->findOrFail($id);
        $apotek = \App\Models\Apotik::first();
        return view('transaksi.return_penjualan.show', compact('return', 'apotek'));
    }

    private function generateNoReturn()
    {
        $prefix = 'RJP-' . date('Ymd') . '-';
        $last = ReturnPenjualan::where('no_return_pj', 'like', $prefix . '%')
            ->orderBy('id', 'desc')
            ->first();

        $seq = $last ? (intval(substr($last->no_return_pj, -3)) + 1) : 1;
        return $prefix . str_pad($seq, 3, '0', STR_PAD_LEFT);
    }
}
