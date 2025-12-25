<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\Rt;

class KartuKeluargaController extends Controller
{
    // 1. TAMPILKAN DAFTAR KK
    public function index(Request $request)
    {
        // 1. Siapkan Query Dasar (Load Relasi & Hitung Anggota)
        $query = KartuKeluarga::with('rt.rw.dusun')
                              ->withCount('penduduks');

        // 2. Logika Smart Search
        // Jika ada input 'search' dari pengguna...
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            
            // Cari di Nomor KK, ATAU Nama Kepala Keluarga, ATAU Alamat
            $query->where(function($q) use ($search) {
                $q->where('nomor_kk', 'like', '%' . $search . '%')
                  ->orWhere('kepala_keluarga', 'like', '%' . $search . '%')
                  ->orWhere('alamat_lengkap', 'like', '%' . $search . '%');
            });
        }

        // 3. Eksekusi Pagination (Tetap urutkan dari yang terbaru)
        $kks = $query->latest()->paginate(10);

        return view('kartu-keluarga.index', compact('kks'));
    }

    // 2. FORM TAMBAH DATA
    public function create()
    {
        // Kita hanya butuh data RT (RW dan Dusun ikut nempel di relasi)
        $rts = Rt::with('rw.dusun')->get();
        return view('kartu-keluarga.create', compact('rts'));
    }

    // 3. PROSES SIMPAN (VERSI BERSIH & OTOMATIS)
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt_id' => 'required|exists:rts,id',
        ]);

        // CUKUP SATU BARIS!
        // Model KartuKeluarga akan otomatis mencari RW & Dusun di background.
        KartuKeluarga::create($request->all());

        return redirect()->route('kk.index')
                         ->with('success', 'Kartu Keluarga Berhasil Ditambahkan!');
    }

    // 4. FORM EDIT DATA
    public function edit($id)
    {
        $kk = KartuKeluarga::findOrFail($id);
        $rts = Rt::with('rw.dusun')->get(); 
        return view('kartu-keluarga.edit', compact('kk', 'rts'));
    }

    // 5. PROSES UPDATE (VERSI BERSIH & OTOMATIS)
    public function update(Request $request, $id)
    {
        $kk = KartuKeluarga::findOrFail($id);

        $request->validate([
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk,'.$kk->id,
            'kepala_keluarga' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt_id' => 'required|exists:rts,id',
        ]);

        // Update biasa. Model akan otomatis menyesuaikan RW/Dusun jika RT berubah.
        $kk->update($request->all());

        return redirect()->route('kk.index')
                         ->with('success', 'Data KK Berhasil Diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $kk = KartuKeluarga::findOrFail($id);
        $kk->delete();
        return redirect()->route('kk.index')
                         ->with('success', 'Kartu Keluarga Berhasil Dihapus!');
    }

    public function show($id)
    {
        // Ambil data KK, lengkap dengan relasi ke RT, RW, Dusun, DAN Penduduknya
        $kk = KartuKeluarga::with(['rt.rw.dusun', 'penduduks'])->findOrFail($id);

        return view('kartu-keluarga.show', compact('kk'));
    }
}