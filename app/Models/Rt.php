<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $guarded = ['id'];

    // 1. Relasi ke RW (Induk Langsung)
    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    // 2. Relasi ke KK (RT punya banyak KK)
    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    // 3. Relasi ke Penduduk (RT punya banyak Penduduk LEWAT KK)
    public function penduduks()
    {
        return $this->hasManyThrough(Penduduk::class, KartuKeluarga::class);
    }
}