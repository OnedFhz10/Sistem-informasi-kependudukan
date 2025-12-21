<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $fillable = [
        'nomor_kk', 
        'kepala_keluarga', 
        'rt_id', 
        'rw_id',    // <-- Tambahan
        'dusun_id', // <-- Tambahan
        'alamat_lengkap', 
        'kode_pos', 
        'kecamatan', 
        'kabupaten', 
        'provinsi'
    ];

    // --- RELASI ---
    public function penduduks()
    {
        return $this->hasMany(Penduduk::class);
    }

    public function rt()
    {
        return $this->belongsTo(Rt::class);
    }

    // Tambahkan relasi ke RW dan Dusun juga
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }
}