<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use Illuminate\Http\Request;

class KategoriObatController extends Controller
{
    public function index()
    {
        $kategoris = KategoriObat::all();
        return view('kategori_obat.index', compact('kategoris'));
    }

    public function create()
    {
        return view('kategori_obat.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        KategoriObat::create($request->all());

        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(KategoriObat $kategori_obat)
    {
        return view('kategori_obat.edit', compact('kategori_obat'));
    }

    public function update(Request $request, KategoriObat $kategori_obat)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $kategori_obat->update($request->all());

        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil diperbarui');
    }

    public function destroy(KategoriObat $kategori_obat)
    {
        $kategori_obat->delete();
        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil dihapus');
    }
}
