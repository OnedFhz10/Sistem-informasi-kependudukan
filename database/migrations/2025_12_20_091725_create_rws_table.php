<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('rws', function (Blueprint $table) {
            $table->id();
            // Menghubungkan RW ke Dusun
            $table->foreignId('dusun_id')->constrained('dusuns')->onDelete('cascade');
            
            $table->string('nomor'); // Contoh: "01", "02"
            
            // --- TAMBAHAN BARU ---
            $table->string('kepala_rw')->nullable(); // Boleh kosong dulu
            // ---------------------

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('rws');
    }
};