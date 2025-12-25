<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('penduduks', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke KK
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('cascade');

            // Identitas Utama
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->enum('jenis_kelamin', ['L', 'P']);
            
            // --- TAMBAHAN BARU ---
            $table->string('agama')->nullable();            
            $table->string('golongan_darah')->nullable();   
            $table->string('status_perkawinan')->nullable();
            // ---------------------

            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            
            // Data Sosial
            $table->string('pendidikan');
            $table->string('pekerjaan');
            $table->string('status_hubungan'); // Kepala Keluarga, Istri, Anak, dll
            
            $table->string('telepon')->nullable(); // No HP
            
            // Data Orang Tua
            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();

            // --- PENTING UNTUK FITUR PENDATANG ---
            // Isinya: 'Warga Asli' atau 'Pendatang'
            $table->string('status_dasar')->default('Warga Asli'); 

            $table->date('tanggal_meninggal')->nullable(); // Kapan meninggalnya?
            $table->date('tanggal_pindah')->nullable();    // Kapan pindahnya?
            $table->date('tanggal_datang')->nullable();    // Kapan datangnya (untuk pendatang)?
            
            // Status Kependudukan (Aktif, Meninggal, Pindah)
            $table->string('status')->default('aktif'); 

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};