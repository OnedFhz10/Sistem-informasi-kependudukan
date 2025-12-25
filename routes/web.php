<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\PendudukController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\KartuKeluargaController;
use App\Http\Controllers\DusunController;
use App\Http\Controllers\RwController;
use App\Http\Controllers\RtController;
use App\Http\Controllers\Auth\AuthenticatedSessionController; 
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProfilDesaController;

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

    // --- SUB-MENU KEPENDUDUKAN (Letakkan PALING ATAS sebelum route {id}) ---
    Route::get('/penduduk/meninggal', [PendudukController::class, 'indexMeninggal'])->name('penduduk.meninggal');
    Route::get('/penduduk/pindah', [PendudukController::class, 'indexPindah'])->name('penduduk.pindah');
    Route::get('/penduduk/pendatang', [PendudukController::class, 'indexPendatang'])->name('penduduk.pendatang');

    // --- READ ONLY (BISA DILIHAT STAFF & ADMIN) ---
    
    // 1. PENDUDUK
    Route::get('/penduduk', [PendudukController::class, 'index'])->name('penduduk.index');
    Route::get('/penduduk/export-excel', [PendudukController::class, 'exportExcel'])->name('penduduk.export-excel');
    Route::get('/penduduk/export-pdf', [PendudukController::class, 'exportPdf'])->name('penduduk.export-pdf');
    
    // PERBAIKAN: Tambahkan ->where('id', '[0-9]+') agar tidak menelan rute 'create'
    Route::get('/penduduk/{id}', [PendudukController::class, 'show'])
        ->name('penduduk.show')
        ->where('id', '[0-9]+'); 

    // 2. KARTU KELUARGA
    Route::get('/kk', [KartuKeluargaController::class, 'index'])->name('kk.index');
    
    // PERBAIKAN: Tambahkan ->where('kk', '[0-9]+')
    Route::get('/kk/{kk}', [KartuKeluargaController::class, 'show'])
        ->name('kk.show')
        ->where('kk', '[0-9]+');

    // 3. WILAYAH (Index saja)
    Route::get('/dusun', [DusunController::class, 'index'])->name('dusun.index');
    Route::get('/rw', [RwController::class, 'index'])->name('rw.index');
    Route::get('/rt', [RtController::class, 'index'])->name('rt.index');


    // --- KHUSUS ADMIN (FULL AKSES: Create, Edit, Delete) ---
    Route::middleware(['is_admin'])->group(function () {
        
        // Modul Manajemen User
        Route::resource('users', UserController::class);

        // Manajemen Profil Desa
        Route::get('/profil-desa', [ProfilDesaController::class, 'index'])->name('profil.index');
        Route::put('/profil-desa', [ProfilDesaController::class, 'update'])->name('profil.update');

        // Penduduk (Create, Store, Edit, Update, Destroy)
        Route::get('/penduduk/create', [PendudukController::class, 'create'])->name('penduduk.create');
        Route::post('/penduduk', [PendudukController::class, 'store'])->name('penduduk.store');
        Route::get('/penduduk/{id}/edit', [PendudukController::class, 'edit'])->name('penduduk.edit');
        Route::put('/penduduk/{id}', [PendudukController::class, 'update'])->name('penduduk.update');
        Route::delete('/penduduk/{id}', [PendudukController::class, 'destroy'])->name('penduduk.destroy');
        // Route show sudah dipindah ke atas agar staff bisa akses

        // KK & Wilayah (Resource SISANYA selain Index & Show)
        Route::resource('kk', KartuKeluargaController::class)->except(['index', 'show']);
        Route::resource('dusun', DusunController::class)->except(['index', 'show']);
        Route::resource('rw', RwController::class)->except(['index', 'show']);
        Route::resource('rt', RtController::class)->except(['index', 'show']);

    });
});