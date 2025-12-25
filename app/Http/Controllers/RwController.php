<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\Dusun;

class RwController extends Controller
{
    public function index()
    {
        // Load data RW beserta Nama Dusun-nya (with 'dusun')
        // Dan hitung jumlah RT, KK, Penduduk (withCount)
        $rws = Rw::with('dusun')
                 ->withCount(['rts', 'kartuKeluargas', 'penduduks'])
                 ->latest()
                 ->paginate(10);

        return view('rw.index', compact('rws'));
    }

    public function create()
    {
        // Butuh data dusun untuk dropdown pilihan
        $dusuns = Dusun::all();
        return view('rw.create', compact('dusuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nomor' => 'required|string|max:5',
            'kepala_rw' => 'nullable|string|max:255', // Validasi Kepala RW
        ]);

        Rw::create($request->all());

        return redirect()->route('rw.index')->with('success', 'RW Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $rw = Rw::findOrFail($id);
        $dusuns = Dusun::all();
        return view('rw.edit', compact('rw', 'dusuns'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nomor' => 'required|string|max:5',
            'kepala_rw' => 'nullable|string|max:255',
        ]);

        Rw::findOrFail($id)->update($request->all());

        return redirect()->route('rw.index')->with('success', 'RW Berhasil Diupdate');
    }

    public function destroy($id)
    {
        // Hati-hati menghapus RW jika ada isinya
        try {
            Rw::findOrFail($id)->delete();
            return redirect()->route('rw.index')->with('success', 'RW Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal menghapus RW. Pastikan data RT di dalamnya sudah kosong.');
        }
    }
}