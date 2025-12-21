<?php

namespace App\Http\Controllers;

use App\Models\Kampung;
use Illuminate\Http\Request;

class KampungController extends Controller
{
    // Menampilkan daftar kampung
    public function index()
    {
        $kampungs = Kampung::latest()->get();
        return view('kampung.index', compact('kampungs'));
    }

    // Menampilkan form tambah
    public function create()
    {
        return view('kampung.create');
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'nama_kampung' => 'required|string|max:255',
            'kepala_kampung' => 'nullable|string|max:255',
        ]);

        Kampung::create($request->all());

        return redirect()->route('kampung.index')
                         ->with('success', 'Data Kampung berhasil ditambahkan');
    }

    // Menampilkan form edit
    public function edit(Kampung $kampung)
    {
        return view('kampung.edit', compact('kampung'));
    }

    // Update data
    public function update(Request $request, Kampung $kampung)
    {
        $request->validate([
            'nama_kampung' => 'required|string|max:255',
            'kepala_kampung' => 'nullable|string|max:255',
        ]);

        $kampung->update($request->all());

        return redirect()->route('kampung.index')
                         ->with('success', 'Data Kampung berhasil diperbarui');
    }

    // Hapus data
    public function destroy(Kampung $kampung)
    {
        $kampung->delete();

        return redirect()->route('kampung.index')
                         ->with('success', 'Data Kampung berhasil dihapus');
    }
}