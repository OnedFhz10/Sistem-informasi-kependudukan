<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProfilDesa;
use Illuminate\Support\Facades\Storage;

class ProfilDesaController extends Controller
{
    public function index()
    {
        // Cek apakah data profil sudah ada?
        $profil = ProfilDesa::first();

        // Jika BELUM ADA (Null), buat data default otomatis
        if (!$profil) {
            $profil = ProfilDesa::create([
                'nama_desa' => 'Nama Desa Default',
                'alamat' => 'Alamat belum diatur',
                'kode_pos' => '00000',
                'email_desa' => 'email@desa.id',
                'telepon' => '-',
            ]);
        }

        return view('profil.index', compact('profil'));
    }

    public function update(Request $request)
    {
        $profil = ProfilDesa::first();

        $request->validate([
            'nama_desa' => 'required|string|max:255',
            'alamat' => 'required|string',
            'email_desa' => 'nullable|email',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ]);

        $data = $request->except(['logo']);

        // Cek apakah ada file logo yang diupload
        if ($request->hasFile('logo')) {

            // Hapus logo lama jika ada (bukan null)
            if ($profil->logo && Storage::exists('public/' . $profil->logo)) {
                Storage::delete('public/' . $profil->logo);
            }

            // Simpan logo baru ke folder 'public/logos'
            $path = $request->file('logo')->store('logos', 'public');
            $data['logo'] = $path;
        }

        $profil->update($data);

        return redirect()->back()->with('success', 'Profil Desa berhasil diperbarui!');
    }
}