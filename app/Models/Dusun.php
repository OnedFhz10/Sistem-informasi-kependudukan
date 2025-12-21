<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Dusun extends Model
{
    protected $guarded = ['id']; // Izinkan isi semua kolom kecuali ID

    public function rws()
    {
        return $this->hasMany(Rw::class);
    }
}