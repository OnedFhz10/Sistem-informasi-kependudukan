<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProfilDesa extends Model
{
    protected $table = 'profil_desas';
    
    protected $fillable = [
        'nama_desa', 
        'alamat', 
        'kode_pos', 
        'email_desa', 
        'telepon', 
        'logo'
    ];
}