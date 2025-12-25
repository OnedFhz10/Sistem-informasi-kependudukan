<?php

namespace App\Imports;

use App\Models\Penduduk;
use App\Models\KartuKeluarga;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PendudukImport implements ToModel, WithHeadingRow
{
    /**
    * Mapping data dari Excel ke Database
    */
    public function model(array $row)
    {
        // 1. Cari ID Kartu Keluarga
        // Pastikan row['nomor_kk'] ada isinya
        if (!isset($row['nomor_kk'])) {
             return null; // Lewati baris kosong
        }

        $kk = KartuKeluarga::where('nomor_kk', $row['nomor_kk'])->first();

        // [UBAHAN] Jika KK tidak ditemukan, LEMPAR ERROR!
        if (!$kk) {
            throw new \Exception("Gagal Import: Nomor KK '" . $row['nomor_kk'] . "' milik " . $row['nama_lengkap'] . " tidak ditemukan di database. Mohon input data KK dulu.");
        }

        // 2. Simpan Data Penduduk
        return new Penduduk([
            'kartu_keluarga_id' => $kk->id,
            'nik'               => $row['nik'],
            'nama_lengkap'      => $row['nama_lengkap'],
            'tempat_lahir'      => $row['tempat_lahir'],
            'tanggal_lahir'     => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['tanggal_lahir']),
            'jenis_kelamin'     => $row['jenis_kelamin'],
            'pekerjaan'         => $row['pekerjaan'],
            'status'            => 'aktif',
        ]);
    }
}