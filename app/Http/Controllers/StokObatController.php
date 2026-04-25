<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Obat;

class StokObatController extends Controller
{
    public function index()
    {
        // Get all medicines with their latest stock data and related info
        // To build a complete view, we fetch Obat and their relations
        $obats = Obat::with(['kategori', 'satuan', 'medicineStocks'])->get();

        return view('master.stok_obat.index', compact('obats'));
    }

    public function show($id)
    {
        $obat = Obat::with(['kategori', 'satuan', 'medicineStocks.batch'])->findOrFail($id);

        // Calculate total stock
        $totalStock = $obat->medicineStocks->sum('stock_qty');

        // Fetch purchase history (DetailPembelian joined with Pembelian)
        // using Eloquent
        $purchaseHistory = \App\Models\DetailPembelian::with('pembelian.supplier')
                            ->where('obat_id', $id)
                            ->get()
                            ->sortByDesc(function ($detail) {
                                return optional($detail->pembelian)->tanggal_pembelian;
                            });

        return view('master.stok_obat.show', compact('obat', 'totalStock', 'purchaseHistory'));
    }
}
