<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProfilDesa;

class ProfilDesaSeeder extends Seeder
{
    public function run(): void
    {
        ProfilDesa::create([
            'nama_desa' => 'Desa Makmur Jaya',
            'alamat' => 'Jl. Raya Kebahagiaan No. 1, Kabupaten Sejahtera',
            'kode_pos' => '12345',
            'email_desa' => 'info@desamakmur.id',
            'telepon' => '0812-3456-7890',
            'logo' => null, // Logo kosong dulu
        ]);
    }
}