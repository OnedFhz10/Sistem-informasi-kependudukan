<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rw;
use App\Models\Dusun; // Kita butuh Dusun untuk dropdown

class RwController extends Controller
{
    public function index()
    {
        // Ambil RW beserta nama Dusun-nya, dan hitung jumlah RT di dalamnya
        $rws = Rw::with('dusun')->withCount('rts')->latest()->paginate(10);
        return view('rw.index', compact('rws'));
    }

    public function create()
    {
        $dusuns = Dusun::all(); // Data untuk dropdown
        return view('rw.create', compact('dusuns'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'dusun_id' => 'required|exists:dusuns,id',
            'nomor' => 'required|string|max:10'
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
            'nomor' => 'required|string|max:10'
        ]);
        Rw::findOrFail($id)->update($request->all());
        return redirect()->route('rw.index')->with('success', 'RW Berhasil Diupdate');
    }

    public function destroy($id)
    {
        Rw::findOrFail($id)->delete();
        return redirect()->route('rw.index')->with('success', 'RW Berhasil Dihapus');
    }
}