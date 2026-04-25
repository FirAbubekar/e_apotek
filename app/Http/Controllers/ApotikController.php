<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Apotik;
use Illuminate\Support\Facades\Storage;

class ApotikController extends Controller
{
    /**
     * Display the settings form containing pharmacy profile.
     */
    public function index()
    {
        // Because there's only one pharmacy profile conceptually, we get first
        // If not exists, return a new instance so the view doesn't break
        $apotik = Apotik::first() ?? new Apotik();

        return view('pengaturan.profil.index', compact('apotik'));
    }

    /**
     * Update or create the pharmacy profile in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'nama_apotek' => 'required|string|max:255',
            'alamat'      => 'required|string',
            'no_telp'     => 'required|string|max:20',
            'email'       => 'required|email|max:255',
            'sip'         => 'nullable|string|max:255',
            'sia'         => 'nullable|string|max:255',
            'logo'        => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // max 2MB
        ]);

        $apotik = Apotik::first();

        // Handle Image Upload
        $logoPath = $apotik ? $apotik->logo : null;
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($logoPath && Storage::disk('public')->exists($logoPath)) {
                Storage::disk('public')->delete($logoPath);
            }
            
            // Store new logo
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $data = [
            'nama_apotek' => $request->nama_apotek,
            'alamat'      => $request->alamat,
            'no_telp'     => $request->no_telp,
            'email'       => $request->email,
            'sip'         => $request->sip,
            'sia'         => $request->sia,
            'logo'        => $logoPath,
        ];

        // Ensure we only have 1 record maximum
        if ($apotik) {
            $apotik->update($data);
        } else {
            Apotik::create($data);
        }

        return redirect()->route('profil-apotek.index')->with('success', 'Profil Apotek berhasil diperbarui.');
    }
}
