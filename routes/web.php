<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\MahasiswaController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\LombaController;
use App\Http\Controllers\PendaftaranController;
use App\Http\Controllers\KriteriaController;
use App\Http\Controllers\RekomendasiController;
use App\Http\Controllers\StaffController;


/*
|--------------------------------------------------------------------------
| HALAMAN AWAL
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| LOGIN
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'pilihan'])
    ->name('login');


// Login Mahasiswa
Route::get('/login/mahasiswa', [AuthController::class, 'mahasiswaForm'])
    ->name('login.mahasiswa');

Route::post('/login/mahasiswa', [AuthController::class, 'mahasiswaLogin'])
    ->name('login.mahasiswa.process');


// Login Staff
Route::get('/login/staff', [AuthController::class, 'staffForm'])
    ->name('login.staff');

Route::post('/login/staff', [AuthController::class, 'staffLogin'])
    ->name('login.staff.process');


// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('dashboard');

        // Profil / Data Mahasiswa
        Route::get('/profil', [MahasiswaController::class, 'profil'])
            ->name('profil');

        Route::put('/profil', [MahasiswaController::class, 'updateProfil'])
            ->name('profil.update');


        // Portfolio
        Route::resource('portfolio', PortfolioController::class)
            ->except(['show']);


        // Data Lomba
        Route::get('/lomba', [LombaController::class, 'index'])
            ->name('lomba.index');

        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        // Rekomendasi Lomba
        Route::get('/rekomendasi', [RekomendasiController::class, 'forStudent'])
            ->name('rekomendasi');


        // Pendaftaran
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
            ->name('pendaftaran.index');

        Route::post('/lomba/{lomba}/daftar', [PendaftaranController::class, 'store'])
            ->name('pendaftaran.store');
    });


/*
|--------------------------------------------------------------------------
| STAFF / ADMIN
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // Dashboard Staff
        Route::get('/dashboard', [StaffController::class, 'dashboard'])
            ->name('dashboard');


        // Data Mahasiswa
        Route::resource('mahasiswa', StaffController::class)
            ->except(['show']);

        Route::get('/mahasiswa/{mahasiswa}', [StaffController::class, 'show'])
            ->name('mahasiswa.show');


        // Data Lomba
        Route::resource('lomba', LombaController::class)
            ->except(['show']);

        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        // Kriteria Lomba
        Route::get('/kriteria', [KriteriaController::class, 'index'])
            ->name('kriteria.index');

        Route::post('/kriteria', [KriteriaController::class, 'store'])
            ->name('kriteria.store');

        Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])
            ->name('kriteria.update');

        Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])
            ->name('kriteria.destroy');


        // Rekomendasi
        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])
            ->name('rekomendasi.index');

        Route::post('/rekomendasi/hitung', [RekomendasiController::class, 'calculate'])
            ->name('rekomendasi.calculate');

        Route::get('/rekomendasi/{lomba}', [RekomendasiController::class, 'show'])
            ->name('rekomendasi.show');

        Route::get('/rekomendasi/{lomba}/pdf', [RekomendasiController::class, 'pdf'])
            ->name('rekomendasi.pdf');


        // Pendaftaran Mahasiswa
        Route::get('/pendaftaran', [PendaftaranController::class, 'staffIndex'])
            ->name('pendaftaran.index');

        Route::patch('/pendaftaran/{pendaftaran}/status', [PendaftaranController::class, 'updateStatus'])
            ->name('pendaftaran.status');
    });