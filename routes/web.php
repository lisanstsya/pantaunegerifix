<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RtRwController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\TanggapanController;
use App\Http\Middleware\CheckRtRwProfile;


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
Route::middleware(['auth'])->group(function () {

    // Halaman Buat Laporan
    Route::get('/lapor', [LaporanController::class, 'create'])->name('lapor');

    // Submit Laporan
    Route::post('/lapor', [LaporanController::class, 'store'])->name('lapor.store');

});
    Route::delete('/laporan/{laporan}', [LaporanController::class, 'destroy'])
    ->middleware(['auth', 'checkRtRwProfile'])
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
        
        Route::middleware(['auth', 'checkPemerintahProfile'])->group(function () {
            Route::delete('/tanggapan/{tanggapan}', [TanggapanController::class, 'destroy'])
                ->name('tanggapan.destroy');
        });

    });

    Route::middleware(['checkPemerintahProfile'])->group(function () {

    Route::get('/tanggapan/pemerintah', [TanggapanController::class, 'pemerintahIndex'])
        ->name('tanggapan.pemerintah');

    Route::get('/laporan/tanggap/{laporan}', [TanggapanController::class, 'create'])
        ->name('tanggap.create');

    Route::post('/laporan/tanggap/{laporan}', [TanggapanController::class, 'store'])
        ->name('tanggap.store');

    // -------------------------
    // EDIT & UPDATE tanggapan
    // -------------------------
    Route::get('/tanggapan/{tanggapan}/edit', [TanggapanController::class, 'edit'])
        ->name('tanggapan.edit');

Route::put('/tanggapan/{tanggapan}', [TanggapanController::class, 'update'])
    ->name('tanggapan.update')
    ->middleware(['auth', 'checkPemerintahProfile']);

    Route::delete('/tanggapan/{tanggapan}', [TanggapanController::class, 'destroy'])
        ->name('tanggapan.destroy');
});

Route::middleware([CheckRtRwProfile::class])->group(function () {
    Route::get('/laporan/{laporan}/edit', [App\Http\Controllers\LaporanController::class, 'edit'])
        ->name('laporan.edit');

    Route::put('/laporan/{laporan}', [App\Http\Controllers\LaporanController::class, 'update'])
        ->name('laporan.update');
});


});


