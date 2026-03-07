<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::all();
        return view('satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('satuan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        Satuan::create($request->all());

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Satuan $satuan)
    {
        return view('satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        $request->validate([
            'nama_satuan' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
        ]);

        $satuan->update($request->all());

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui');
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus');
    }
}
