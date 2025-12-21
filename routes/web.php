<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\KampungController;
use App\Http\Controllers\ProfileController;
// Jangan lupa import Controller KK dan Wilayah
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; 

Route::get('/', function () {
    return redirect()->route('login');
});

// --- RUTE LOGIN (Untuk Tamu) ---
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth')->group(function () {
    
    // --- RUTE LOGOUT ---
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

    // --- DASHBOARD ---
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/detail', [DashboardController::class, 'getDetailData'])->name('dashboard.detail');

    // --- READ ONLY (BISA DILIHAT STAFF & ADMIN) ---
    // Staff butuh akses 'index' (melihat tabel) untuk data-data ini
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/kampung', [KampungController::class, 'index'])->name('kampung.index');
    Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');     // <-- Perbaikan Error kk.index
    Route::get('/dusun', [DusunController::class, 'index'])->name('dusun.index');       // <-- Agar menu Dusun jalan
    Route::get('/rw', [RwController::class, 'index'])->name('rw.index');                // <-- Agar menu RW jalan
    Route::get('/rt', [RtController::class, 'index'])->name('rt.index');                // <-- Agar menu RT jalan

    // --- KHUSUS ADMIN (FULL AKSES: Create, Edit, Delete) ---
    Route::middleware(['is_admin'])->group(function () {
        
        // Modul Manajemen User (BARU)
        Route::resource('users', App\Http\Controllers\UserController::class);

        // Manajemen Profil Desa (BARU)
        Route::get('/profil-desa', [App\Http\Controllers\ProfilDesaController::class, 'index'])->name('profil.index');
        Route::put('/profil-desa', [App\Http\Controllers\ProfilDesaController::class, 'update'])->name('profil.update');

        // Penduduk
        Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('/penduduk/{id}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('/penduduk/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');

        // Kampung (Kecuali Index yang sudah di atas)
        Route::resource('kampung', KampungController::class)->except(['index', 'show']);

        // KK & Wilayah (Kecuali Index yang sudah di atas)
        Route::resource('kk', KartuKeluargaController::class)->except(['index', 'show']);
        Route::resource('dusun', DusunController::class)->except(['index', 'show']);
        Route::resource('rw', RwController::class)->except(['index', 'show']);
        Route::resource('rt', RtController::class)->except(['index', 'show']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});