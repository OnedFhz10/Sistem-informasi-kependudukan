<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KartuKeluarga extends Model
{
    protected $guarded = ['id']; // Membolehkan semua kolom diisi (kecuali ID)

    // --- RELASI ---
    public function rt() { return $this->belongsTo(Rt::class); }
    public function rw() { return $this->belongsTo(Rw::class); }
    public function dusun() { return $this->belongsTo(Dusun::class); }
    public function penduduks() { return $this->hasMany(Penduduk::class); }

    // --- LOGIKA OTOMATIS (AUTO FILL) ---
    protected static function boot()
    {
        parent::boot();

        // Event ini jalan otomatis SEBELUM data disimpan (Create/Update)
        static::saving(function ($kk) {
            // Jika user memilih RT, kita cari RW dan Dusun-nya otomatis
            if ($kk->rt_id) {
                $rt = Rt::with('rw.dusun')->find($kk->rt_id);
                
                if ($rt) {
                    $kk->rw_id = $rt->rw_id;          // Isi RW otomatis
                    $kk->dusun_id = $rt->rw->dusun_id;// Isi Dusun otomatis
                }
            }
        });
    }
}