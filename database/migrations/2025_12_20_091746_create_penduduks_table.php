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
            $table->foreignId('kartu_keluarga_id')->constrained('kartu_keluargas')->onDelete('cascade');
            $table->string('nik')->unique();
            $table->string('nama_lengkap');
            $table->string('tempat_lahir');
            $table->date('tanggal_lahir');
            $table->enum('jenis_kelamin', ['L', 'P']);
            
            $table->string('pekerjaan')->nullable(); // String biasa
            $table->string('pendidikan')->nullable();
            
            $table->string('status')->default('aktif'); 
            $table->string('status_hubungan')->nullable(); 

            $table->string('nama_ayah')->nullable();
            $table->string('nama_ibu')->nullable();

            $table->date('tanggal_wafat')->nullable();
            $table->date('tanggal_pindah')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('penduduks');
    }
};