<?php

namespace App\Exports;

use App\Models\Penduduk;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class PendudukExport implements FromCollection, WithHeadings, WithMapping
{
    /**
    * Mengambil data dari database
    */
    public function collection()
    {
        // Mengambil semua data penduduk
        return Penduduk::all();
    }

    /**
    * Mengatur data apa saja yang masuk ke kolom Excel (Mapping)
    * Ini disesuaikan dengan create_penduduks_table.php kamu
    */
    public function map($penduduk): array
    {
        return [
            $penduduk->nik,
            $penduduk->nama_lengkap,
            $penduduk->jenis_kelamin, // L atau P
            $penduduk->tempat_lahir . ', ' . $penduduk->tanggal_lahir, // Menggabungkan TTL
            $penduduk->pendidikan ?? '-', // Tanda '-' jika kosong
            $penduduk->pekerjaan ?? '-',
            $penduduk->status_hubungan ?? '-',
            $penduduk->status,
        ];
    }

    /**
    * Membuat Judul Kolom (Header) di Excel
    */
    public function headings(): array
    {
        return [
            'NIK',
            'Nama Lengkap',
            'L/P',
            'Tempat, Tanggal Lahir',
            'Pendidikan',
            'Pekerjaan',
            'Status Hubungan',
            'Status Penduduk',
        ];
    }
}