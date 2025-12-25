<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    protected $guarded = ['id'];

    // 1. Relasi ke RW (Langsung)
    public function rws()
    {
        return $this->hasMany(Rw::class);
    }

    // 2. Relasi ke RT (Lewat RW) -> "HasManyThrough"
    // Cara bacanya: Dusun punya banyak RT, melalui perantara RW
    public function rts()
    {
        return $this->hasManyThrough(Rt::class, Rw::class);
    }

    // 3. Relasi ke Kartu Keluarga (Langsung, karena di KK sudah ada dusun_id)
    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }

    // 4. Relasi ke Penduduk (Lewat KK)
    // Cara bacanya: Dusun punya banyak Penduduk, melalui perantara KartuKeluarga
    public function penduduks()
    {
        return $this->hasManyThrough(Penduduk::class, KartuKeluarga::class);
    }
}