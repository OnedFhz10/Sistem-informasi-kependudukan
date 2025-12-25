<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Carbon\Carbon;

class Penduduk extends Model
{
    protected $fillable = [
        'nik', 'nama_lengkap', 'tempat_lahir', 'tanggal_lahir', 
        'jenis_kelamin', 'status', 'pekerjaan', 'kartu_keluarga_id',
        'pendidikan', 'status_hubungan', 'nama_ayah', 'nama_ibu','tanggal_meninggal', 'tanggal_pindah', 'tanggal_datang'
    ];

    protected $casts = [
        'tanggal_lahir' => 'date',
        'tanggal_meninggal' => 'date',
        'tanggal_pindah' => 'date',
        'tanggal_datang' => 'date',
    ];

    protected function usia(): Attribute
    {
        return Attribute::make(
            get: fn () => Carbon::parse($this->tanggal_lahir)->age
        );
    }

    public function kartuKeluarga()
    {
        return $this->belongsTo(KartuKeluarga::class);
    }
}