<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rt;
use App\Models\Rw;

class RtController extends Controller
{
    public function index()
    {
        // Load data RT beserta RW-nya (dan Dusun dari RW)
        // Hitung KK dan Penduduk
        $rts = Rt::with('rw.dusun')
                 ->withCount(['kartuKeluargas', 'penduduks'])
                 ->latest()
                 ->paginate(10);

        return view('rt.index', compact('rts'));
    }

    public function create()
    {
        // Ambil data RW (lengkap dengan nama dusunnya biar jelas saat dipilih)
        $rws = Rw::with('dusun')->get();
        return view('rt.create', compact('rws'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'nomor' => 'required|string|max:5',
            'kepala_rt' => 'nullable|string|max:255',
        ]);

        Rt::create($request->all());

        return redirect()->route('rt.index')->with('success', 'RT Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $rt = Rt::findOrFail($id);
        $rws = Rw::with('dusun')->get();
        return view('rt.edit', compact('rt', 'rws'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'nomor' => 'required|string|max:5',
            'kepala_rt' => 'nullable|string|max:255',
        ]);

        Rt::findOrFail($id)->update($request->all());

        return redirect()->route('rt.index')->with('success', 'RT Berhasil Diupdate');
    }

    public function destroy($id)
    {
        try {
            Rt::findOrFail($id)->delete();
            return redirect()->route('rt.index')->with('success', 'RT Berhasil Dihapus');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal hapus. Pastikan data KK di dalamnya kosong.');
        }
    }
}