<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\KategoriObat;
use App\Models\Satuan;
use Illuminate\Http\Request;

class ObatController extends Controller
{
    public function index()
    {
        $obats = Obat::with(['kategori', 'satuan'])->get();
        return view('obat.index', compact('obats'));
    }

    public function create()
    {
        $kategoris = KategoriObat::all();
        $satuans = Satuan::all();
        return view('obat.create', compact('kategoris', 'satuans'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_obat' => 'required|string|unique:obat,kode_obat|max:50',
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'satuan_id' => 'required|exists:satuan,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        Obat::create($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Obat $obat)
    {
        $kategoris = KategoriObat::all();
        $satuans = Satuan::all();
        return view('obat.edit', compact('obat', 'kategoris', 'satuans'));
    }

    public function update(Request $request, Obat $obat)
    {
        $request->validate([
            'kode_obat' => 'required|string|max:50|unique:obat,kode_obat,' . $obat->id,
            'nama_obat' => 'required|string|max:255',
            'kategori_id' => 'required|exists:kategori_obat,id',
            'satuan_id' => 'required|exists:satuan,id',
            'harga_beli' => 'required|numeric|min:0',
            'harga_jual' => 'required|numeric|min:0',
        ]);

        $obat->update($request->all());

        return redirect()->route('obat.index')->with('success', 'Obat berhasil diperbarui');
    }

    public function destroy(Obat $obat)
    {
        $obat->delete();
        return redirect()->route('obat.index')->with('success', 'Obat berhasil dihapus');
    }
}
