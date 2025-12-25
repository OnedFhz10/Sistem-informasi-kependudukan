<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dusun;

class DusunController extends Controller
{
    public function index()
    {
        // Ambil data Dusun + Hitung jumlah anak-anaknya otomatis
        $dusuns = Dusun::withCount(['rws', 'rts', 'kartuKeluargas', 'penduduks'])
                        ->latest()
                        ->paginate(10);

        return view('dusun.index', compact('dusuns'));
    }

    public function create()
    {
        return view('dusun.create');
    }

    public function store(Request $request)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:dusuns,nama']);
        Dusun::create($request->all());
        return redirect()->route('dusun.index')->with('success', 'Dusun Berhasil Ditambahkan');
    }

    public function edit($id)
    {
        $dusun = Dusun::findOrFail($id);
        return view('dusun.edit', compact('dusun'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['nama' => 'required|string|max:255|unique:dusuns,nama,'.$id]);
        Dusun::findOrFail($id)->update($request->all());
        return redirect()->route('dusun.index')->with('success', 'Dusun Berhasil Diupdate');
    }

    public function destroy($id)
    {
        Dusun::findOrFail($id)->delete();
        return redirect()->route('dusun.index')->with('success', 'Dusun Berhasil Dihapus');
    }
}