<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KartuKeluarga;
use App\Models\Rt; // <-- PENTING: Panggil Model RT

class KartuKeluargaController extends Controller
{
    // 1. TAMPILKAN DAFTAR KK
    public function index()
    {
        $kks = KartuKeluarga::with('rt.rw.dusun')
                            ->withCount('penduduks')
                            ->latest()
                            ->paginate(10);

        return view('kartu-keluarga.index', compact('kks'));
    }

    // 2. FORM TAMBAH DATA
    public function create()
    {
        // Kita butuh data RT agar user bisa memilih lokasi KK
        // Kita load juga RW dan Dusun biar di dropdown jelas (misal: RT 01 / RW 02 - Dusun A)
        $rts = Rt::with('rw.dusun')->get();

        return view('kartu-keluarga.create', compact('rts'));
    }

    // 3. PROSES SIMPAN DATA BARU
    public function store(Request $request)
    {
        $request->validate([
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk',
            'kepala_keluarga' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt_id' => 'required|exists:rts,id',
        ]);

        KartuKeluarga::create($request->all());

        return redirect()->route('kk.index')
                         ->with('success', 'Kartu Keluarga Berhasil Ditambahkan!');
    }

    // 4. FORM EDIT DATA
    public function edit($id)
    {
        $kk = KartuKeluarga::findOrFail($id);
        $rts = Rt::with('rw.dusun')->get(); // Ambil data RT untuk dropdown

        return view('kartu-keluarga.edit', compact('kk', 'rts'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $kk = KartuKeluarga::findOrFail($id);

        $request->validate([
            // Validasi unik kecuali untuk dirinya sendiri
            'nomor_kk' => 'required|numeric|digits:16|unique:kartu_keluargas,nomor_kk,'.$kk->id,
            'kepala_keluarga' => 'required|string|max:255',
            'alamat_lengkap' => 'required|string',
            'rt_id' => 'required|exists:rts,id',
        ]);

        $kk->update($request->all());

        return redirect()->route('kk.index')
                         ->with('success', 'Data KK Berhasil Diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy($id)
    {
        $kk = KartuKeluarga::findOrFail($id);
        
        // Opsional: Cek apakah KK masih punya anggota keluarga?
        // Jika masih ada, sebaiknya jangan dihapus atau kosongkan dulu.
        // Tapi untuk sekarang kita hapus saja (Relasi di database sudah 'Cascade' atau 'Set Null' tergantung migrasi)
        $kk->delete();

        return redirect()->route('kk.index')
                         ->with('success', 'Kartu Keluarga Berhasil Dihapus!');
    }
}