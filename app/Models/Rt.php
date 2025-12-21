<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rt extends Model
{
    protected $guarded = ['id'];

    public function rw()
    {
        return $this->belongsTo(Rw::class);
    }

    public function kartuKeluargas()
    {
        return $this->hasMany(KartuKeluarga::class);
    }
}