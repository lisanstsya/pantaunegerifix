<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RtRwController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TanggapanController;

// =========================
// PUBLIC ROUTES
// =========================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/laporan', [LaporanController::class, 'index'])->name('laporan');
Route::get('/laporan/{id}', [LaporanController::class, 'show'])->name('laporan.show');
Route::get('/tanggapan', [TanggapanController::class, 'index'])->name('tanggapan.index');

// =========================
// PILIH ROLE
// =========================
Route::get('/pilih-role', [AuthController::class, 'pilihRole'])->name('auth.pilih-role');
Route::get('/pilih-role/process', [AuthController::class, 'pilihRoleProcess'])->name('auth.pilih-role.process');

// =========================
// LOGIN
// =========================
Route::get('/login/rt-rw', [AuthController::class, 'loginRtRwForm'])->name('login.rt_rw.form');
Route::post('/login/rt-rw', [AuthController::class, 'loginRtRw'])->name('login.rt_rw');

Route::get('/login/pemerintah', [AuthController::class, 'loginPemerintahForm'])->name('login.pemerintah.form');
Route::post('/login/pemerintah', [AuthController::class, 'loginPemerintah'])->name('login.pemerintah');

// =========================
// LOGOUT
// =========================
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// =========================
// REGISTER
// =========================
Route::get('/register/rt-rw', [AuthController::class, 'registerRtRwForm'])->name('rt-rw.register.form');
Route::post('/register/rt-rw', [AuthController::class, 'registerRtRw'])->name('rt-rw.register.submit');
Route::post('/rt-rw/store-profile', [RtRwController::class, 'storeProfile'])->name('rt-rw.store-profile');

Route::get('/register/pemerintah', [AuthController::class, 'registerPemerintahForm'])->name('pemerintah.register.form');
Route::post('/register/pemerintah', [AuthController::class, 'registerPemerintah'])->name('pemerintah.register.submit');

// =========================
// AUTHENTICATED ROUTES
// =========================
Route::middleware(['auth'])->group(function () {

    Route::get('/dashboard', [HomeController::class, 'index'])->name('dashboard');

    // -------------------------
    // RT/RW
    // -------------------------
    Route::get('/lapor', [LaporanController::class, 'create'])->name('lapor');
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');

    Route::delete('/laporan/{id}/delete', [LaporanController::class, 'destroy'])
        ->middleware('checkRtRwProfile')
        ->name('laporan.destroy');

    // -------------------------
    // PEMERINTAH
    // -------------------------
    Route::middleware(['checkPemerintahProfile'])->group(function () {

        Route::get('/tanggapan/pemerintah', [TanggapanController::class, 'pemerintahIndex'])
            ->name('tanggapan.pemerintah');

        Route::get('/laporan/tanggap/{laporan}', [TanggapanController::class, 'create'])
            ->name('tanggap.create');

        Route::post('/laporan/tanggap/{laporan}', [TanggapanController::class, 'store'])
            ->name('tanggap.store');
            
    });

});
