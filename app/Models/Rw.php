<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $guarded = ['id'];

    // 1. Relasi ke Dusun (RW adalah milik Dusun)
    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    // 2. Relasi ke RT (RW punya banyak RT)
    public function rts()
    {
        return $this->hasMany(Rt::class);
    }

    // 3. Relasi ke KK (RW punya banyak KK - langsung lewat rw_id di tabel KK)
    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    // 4. Relasi ke Penduduk (RW punya banyak Penduduk LEWAT KK)
    public function penduduks()
    {
        return $this->hasManyThrough(Penduduk::class, KartuKeluarga::class);
    }
}