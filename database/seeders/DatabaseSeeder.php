<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Dusun;
use App\Models\Rw;
use App\Models\Rt;
use App\Models\KartuKeluarga;
use App\Models\Penduduk;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. User Admin & Staff
        User::create([
            'name' => 'Admin Desa',
            'email' => 'admin@desa.com',
            'password' => Hash::make('password123'),
            'role' => 'admin',
        ]);

        User::create([
            'name' => 'Staff Desa',
            'email' => 'staff@desa.com',
            'password' => Hash::make('password123'),
            'role' => 'staff',
        ]);

        // 2. Data Wilayah (Tanpa Kampung)
        // Dusun -> RW -> RT
        $dusun = Dusun::create(['nama' => 'Dusun Mawar', 'kepala_dusun' => 'Bapak Mawar']);
        $rw = Rw::create(['dusun_id' => $dusun->id, 'nomor' => '01','kepala_rw' => 'Bapak Ketua RW 01']);
        $rt = Rt::create(['rw_id' => $rw->id, 'nomor' => '01','Bapak Ketua RT 01']);
        
        // 3. KK Dummy
        $kk = KartuKeluarga::create([
            'nomor_kk' => '3201010101010001',
            'kepala_keluarga' => 'Budi Santoso',
            'rt_id' => $rt->id,
            'rw_id' => $rw->id,
            'dusun_id' => $dusun->id,
            'alamat_lengkap' => 'Jl. Merdeka No. 45',
            'kode_pos' => '16900',
        ]);

        // 4. Penduduk Dummy
        Penduduk::create([
            'kartu_keluarga_id' => $kk->id,
            'nik' => '3201010101010002',
            'nama_lengkap' => 'Budi Santoso',
            'tempat_lahir' => 'Bogor',
            'tanggal_lahir' => '1985-05-20',
            'jenis_kelamin' => 'L',
            'status' => 'aktif',
            'pekerjaan' => 'Petani',
            'pendidikan' => 'SLTA',
            'status_hubungan' => 'Kepala Keluarga',
        ]);
    }
}