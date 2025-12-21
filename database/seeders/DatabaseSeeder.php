<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\Kampung;
use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash; // <--- PENTING!

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Buat User ADMIN
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password123'), // Password di-hash
            'role' => 'admin',
        ]);

        // 2. Buat User STAFF
        User::create([
            'name' => 'Staff Desa',
            'email' => 'staff@desa.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // 3. Data Wilayah Dummy
        $dusun = Dusun::create(['nama' => 'Dusun Mawar']);
        $rw = Rw::create(['dusun_id' => $dusun->id, 'nomor' => '01']);
        $rt = Rt::create(['rw_id' => $rw->id, 'nomor' => '01']);
        Kampung::create(['nama_kampung' => 'Kampung Durian', 'kepala_kampung' => 'Pak Asep']);

        // 4. KK Dummy
        $kk = KartuKeluarga::create([
            'nomor_kk' => '3201010101010001',
            'kepala_keluarga' => 'Budi Santoso',
            'rt_id' => $rt->id,
            'rw_id' => $rw->id,
            'dusun_id' => $dusun->id,
            'alamat_lengkap' => 'Jl. Merdeka No. 45',
            'kode_pos' => '16900',
        ]);

        // 5. Penduduk Dummy
        Penduduk::create([
            'kartu_keluarga_id' => $kk->id,
            'nik' => '3201010101010002',
            'nama_lengkap' => 'Budi Santoso',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1985-05-20',
            'jenis_kelamin' => 'L',
            'status' => 'aktif',
            'pekerjaan' => 'Petani/Pekebun',
            'pendidikan' => 'SLTA/Sederajat',
            'status_hubungan' => 'Kepala Keluarga',
            'nama_ayah' => 'Suparman',
            'nama_ibu' => 'Siti Aminah',
        ]);
    }
}