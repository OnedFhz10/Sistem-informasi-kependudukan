<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rw extends Model
{
    protected $guarded = ['id'];

    public function dusun()
    {
        return $this->belongsTo(Dusun::class);
    }

    public function rts()
    {
        return $this->hasMany(Rt::class);
    }
}