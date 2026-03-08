<?php

namespace App\Http\Controllers;

use App\Models\KategoriObat;
use Illuminate\Http\Request;

class KategoriObatController extends Controller
{
    public function index()
    {
        $kategoris = KategoriObat::all();
        return view('master.kategori_obat.index', compact('kategoris'));
    }

    public function create()
    {
        return view('master.kategori_obat.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_code' => 'required|string|unique:categories,category_code|max:255',
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        KategoriObat::create($validated);

        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(KategoriObat $kategori_obat)
    {
        return view('master.kategori_obat.edit', compact('kategori_obat'));
    }

    public function update(Request $request, KategoriObat $kategori_obat)
    {
        $validated = $request->validate([
            'category_code' => 'required|string|max:255|unique:categories,category_code,' . $kategori_obat->id,
            'category_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $kategori_obat->update($validated);

        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil diperbarui');
    }

    public function destroy(KategoriObat $kategori_obat)
    {
        $kategori_obat->delete();
        return redirect()->route('kategori-obat.index')->with('success', 'Kategori Obat berhasil dihapus');
    }
}
