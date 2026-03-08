<?php

namespace App\Http\Controllers;

use App\Models\Satuan;
use Illuminate\Http\Request;

class SatuanController extends Controller
{
    public function index()
    {
        $satuans = Satuan::all();
        return view('master.satuan.index', compact('satuans'));
    }

    public function create()
    {
        return view('master.satuan.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'unit_code' => 'required|string|unique:units,unit_code|max:255',
            'unit_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Satuan::create($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Satuan $satuan)
    {
        return view('master.satuan.edit', compact('satuan'));
    }

    public function update(Request $request, Satuan $satuan)
    {
        $validated = $request->validate([
            'unit_code' => 'required|string|max:255|unique:units,unit_code,' . $satuan->id,
            'unit_name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $satuan->update($validated);

        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil diperbarui');
    }

    public function destroy(Satuan $satuan)
    {
        $satuan->delete();
        return redirect()->route('satuan.index')->with('success', 'Satuan berhasil dihapus');
    }
}
