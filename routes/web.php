<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Atasan\AtasanController;
use App\Http\Controllers\Pegawai\PegawaiController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

// Authentication Routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [LoginController::class, 'login']);
});

Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
    
    // User Management
    Route::get('/users', [AdminController::class, 'users'])->name('users.index');
    Route::get('/users/create', [AdminController::class, 'createUser'])->name('users.create');
    Route::post('/users', [AdminController::class, 'storeUser'])->name('users.store');
    Route::get('/users/{user}/edit', [AdminController::class, 'editUser'])->name('users.edit');
    Route::put('/users/{user}', [AdminController::class, 'updateUser'])->name('users.update');
    Route::delete('/users/{user}', [AdminController::class, 'deleteUser'])->name('users.destroy');
    
    // Cuti Management
    Route::get('/cuti', [AdminController::class, 'cuti'])->name('cuti.index');
    
    // Export
    Route::get('/cuti/export/pdf', [AdminController::class, 'exportPdf'])->name('cuti.export.pdf');
    Route::get('/cuti/export/excel', [AdminController::class, 'exportExcel'])->name('cuti.export.excel');
});

/*
|--------------------------------------------------------------------------
| Atasan Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:atasan'])->prefix('atasan')->name('atasan.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AtasanController::class, 'dashboard'])->name('dashboard');
    
    // Pengajuan Management
    Route::get('/pengajuan', [AtasanController::class, 'pengajuan'])->name('pengajuan.index');
    Route::get('/pengajuan/{cuti}', [AtasanController::class, 'showPengajuan'])->name('pengajuan.show');
    Route::post('/pengajuan/{cuti}/approve', [AtasanController::class, 'approve'])->name('pengajuan.approve');
    Route::post('/pengajuan/{cuti}/reject', [AtasanController::class, 'reject'])->name('pengajuan.reject');
});

/*
|--------------------------------------------------------------------------
| Pegawai Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:pegawai'])->prefix('pegawai')->name('pegawai.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [PegawaiController::class, 'dashboard'])->name('dashboard');
    
    // Cuti Management
    Route::get('/cuti/create', [PegawaiController::class, 'createCuti'])->name('cuti.create');
    Route::post('/cuti', [PegawaiController::class, 'storeCuti'])->name('cuti.store');
    Route::get('/cuti/riwayat', [PegawaiController::class, 'riwayat'])->name('cuti.riwayat');
    Route::get('/cuti/{cuti}', [PegawaiController::class, 'showCuti'])->name('cuti.show');
    Route::get('/sisa-cuti', [PegawaiController::class, 'sisaCuti'])->name('cuti.sisa');
});

/*
|--------------------------------------------------------------------------
| Fallback Route
|--------------------------------------------------------------------------
*/

Route::fallback(function () {
    return redirect()->route('login');
});

// ============================================
// ROUTE UNTUK HALAMAN PROFIL
// ============================================
Route::middleware(['auth'])->group(function () {
    
    // URL: /profil
    // Nama: profil
    // Fungsi: Tampilkan view profil.blade.php
    Route::get('/profil', function () {
        return view('profil');
    })->name('profil');
    
});