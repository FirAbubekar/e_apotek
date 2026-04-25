<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StokOpname;
use App\Models\DetailStokOpname;
use App\Models\MedicineStock;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StokOpnameController extends Controller
{
    /**
     * Display a listing of the past Stok Opnames.
     */
    public function index()
    {
        $opnames = StokOpname::with('user')->orderBy('created_at', 'desc')->get();
        return view('master.stok_opname.index', compact('opnames'));
    }

    /**
     * Show the form for creating a new Stok Opname.
     */
    public function create()
    {
        // Get all active stock from batches so user can opname them
        $stocks = MedicineStock::with(['obat', 'batch' => function($query) {
            $query->orderBy('expired_date', 'asc');
        }])->get();

        return view('master.stok_opname.create', compact('stocks'));
    }

    /**
     * Store a newly created Stok Opname in storage and update actual stocks.
     */
    public function store(Request $request)
    {
        $request->validate([
            'tanggal_opname'   => 'required|date',
            'keterangan'       => 'nullable|string',
            'opname_items'     => 'required|array',
            'opname_items.*'   => 'exists:medicine_stocks,id',
            'stok_fisik.*'     => 'required|integer|min:0',
            'alasan.*'         => 'nullable|string',
        ]);

        DB::beginTransaction();

        try {
            // 1. Create the Opname Header
            $stokOpname = StokOpname::create([
                'tanggal_opname' => $request->tanggal_opname,
                'keterangan'     => $request->keterangan,
                'user_id'        => Auth::id(),
            ]);

            // 2. Loop through submitted items
            foreach ($request->opname_items as $index => $medicineStockId) {
                $stockRecord = MedicineStock::findOrFail($medicineStockId);
                
                $stokSistem = $stockRecord->stock_qty;
                $stokFisik = $request->stok_fisik[$index];
                $selisih = $stokFisik - $stokSistem;

                // Only save details if there is an actual check (or we could save all, let's save those that were inputted)
                if ($stokFisik !== null) {
                    
                    // Create Detail Record
                    DetailStokOpname::create([
                        'stok_opname_id'     => $stokOpname->id,
                        'medicine_stock_id'  => $medicineStockId,
                        'stok_sistem'        => $stokSistem,
                        'stok_fisik'         => $stokFisik,
                        'selisih'            => $selisih,
                        'alasan'             => $request->alasan[$index] ?? null,
                    ]);

                    // Update the actual database stock unconditionally to match physical reality
                    if ($selisih != 0) {
                        // Record the mutation for audit trail
                        \App\Models\StockMutation::create([
                            'medicine_stock_id' => $medicineStockId,
                            'type'              => 'Opname',
                            'qty_change'        => $selisih,
                            'qty_before'        => $stokSistem,
                            'qty_after'         => $stokFisik,
                            'reference'         => 'Opname #' . $stokOpname->id,
                            'user_id'           => Auth::id(),
                            'notes'             => $request->alasan[$index] ?? 'Penyesuaian hasil stok opname',
                        ]);

                        $stockRecord->update([
                            'stock_qty' => $stokFisik
                        ]);
                    }
                }
            }

            DB::commit();

            return redirect()->route('stok-opname.index')->with('success', 'Stok Opname berhasil disimpan dan stok sistem telah diperbarui.');

        } catch (\Exception $e) {
            DB::rollback();
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified Stok Opname detail.
     */
    public function show($id)
    {
        $opname = StokOpname::with(['user', 'detail.medicineStock.obat', 'detail.medicineStock.batch'])->findOrFail($id);
        
        return view('master.stok_opname.show', compact('opname'));
    }
}
