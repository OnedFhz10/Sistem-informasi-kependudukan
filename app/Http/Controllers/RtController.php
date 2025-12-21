<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rt;
use App\Models\Rw; // Kita butuh RW untuk dropdown

class RtController extends Controller
{
    public function index()
    {
        // Ambil RT, info RW & Dusun, serta hitung jumlah KK
        $rts = Rt::with('rw.dusun')->withCount('kartuKeluargas')->latest()->paginate(10);
        return view('rt.index', compact('rts'));
    }

    public function create()
    {
        // Ambil semua Dusun (untuk dropdown pertama)
        $dusuns = \App\Models\Dusun::all();
        
        // Ambil semua RW (untuk data mentah yang akan difilter oleh Javascript)
        $rws = \App\Models\Rw::all(); 

        return view('rt.create', compact('dusuns', 'rws'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'nomor' => 'required|string|max:10'
        ]);
        Rt::create($request->all());
        return redirect()->route('rt.index')->with('success', 'RT Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        // Ambil data RT yang mau diedit beserta relasi RW-nya
        $rt = Rt::with('rw')->findOrFail($id);
        
        // Ambil data Master untuk dropdown
        $dusuns = \App\Models\Dusun::all();
        $rws = \App\Models\Rw::all(); 

        return view('rt.edit', compact('rt', 'dusuns', 'rws'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'rw_id' => 'required|exists:rws,id',
            'nomor' => 'required|string|max:10'
        ]);
        Rt::findOrFail($id)->update($request->all());
        return redirect()->route('rt.index')->with('success', 'RT Berhasil Diupdate');
    }

    public function destroy($id)
    {
        Rt::findOrFail($id)->delete();
        return redirect()->route('rt.index')->with('success', 'RT Berhasil Dihapus');
    }
}