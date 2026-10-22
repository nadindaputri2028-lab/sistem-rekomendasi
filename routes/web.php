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
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\GoogleController;


/*
|--------------------------------------------------------------------------
| Halaman Utama
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
})->name('home');


/*
|--------------------------------------------------------------------------
| Login
|--------------------------------------------------------------------------
*/

// Tampilkan form login tunggal
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses submit form login tunggal
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| LOGIN GOOGLE
|--------------------------------------------------------------------------
*/

// Arahkan pengguna ke halaman Login Google
Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google');

// Callback dari Google setelah proses login
Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session'])->group(function () {

    // Menampilkan semua notifikasi
    Route::get('/notifikasi', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Membuka detail/tujuan notifikasi
    Route::get('/notifikasi/{notification}/buka', [NotificationController::class, 'open'])
        ->name('notifications.open');

    // Menandai satu notifikasi sebagai sudah dibaca
    Route::post('/notifikasi/{notification}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');

    // Menandai semua notifikasi sebagai sudah dibaca
    Route::post('/notifikasi/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.readAll');
});


/*
|--------------------------------------------------------------------------
| MAHASISWA
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:mahasiswa'])
    ->prefix('mahasiswa')
    ->name('mahasiswa.')
    ->group(function () {

        // Dashboard mahasiswa
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Profil Mahasiswa
        |--------------------------------------------------------------------------
        */

        // Detail Profil
        Route::get('/profil', [MahasiswaController::class, 'profil'])
            ->name('profil.show');

        // Form Edit Profil
        Route::get('/profil/edit', [MahasiswaController::class, 'editProfil'])
            ->name('profil.edit');

        // Proses Update Profil
        Route::put('/profil', [MahasiswaController::class, 'updateProfil'])
            ->name('profil.update');


        /*
        |--------------------------------------------------------------------------
        | Portfolio Mahasiswa
        |--------------------------------------------------------------------------
        */

        Route::resource('portfolio', PortfolioController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | Lomba
        |--------------------------------------------------------------------------
        */

        // Daftar semua lomba
        Route::get('/lomba', [LombaController::class, 'index'])
            ->name('lomba.index');

        // Detail lomba
        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        /*
        |--------------------------------------------------------------------------
        | Rekomendasi
        |--------------------------------------------------------------------------
        */

        Route::get('/rekomendasi', [RekomendasiController::class, 'forStudent'])
            ->name('rekomendasi');


        /*
        |--------------------------------------------------------------------------
        | Pendaftaran
        |--------------------------------------------------------------------------
        */

        // Riwayat pendaftaran mahasiswa
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
            ->name('pendaftaran.index');

        // Daftar lomba
        Route::post('/lomba/{lomba}/daftar', [PendaftaranController::class, 'store'])
            ->name('pendaftaran.store');
    });


/*
|--------------------------------------------------------------------------
| STAFF
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session', 'role:staff'])
    ->prefix('staff')
    ->name('staff.')
    ->group(function () {

        // Dashboard staff
        Route::get('/dashboard', [StaffController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | Data Mahasiswa
        |--------------------------------------------------------------------------
        */

        Route::resource('mahasiswa', StaffController::class)
            ->except(['show']);

        // Detail mahasiswa
        Route::get('/mahasiswa/{mahasiswa}', [StaffController::class, 'show'])
            ->name('mahasiswa.show');


        /*
        |--------------------------------------------------------------------------
        | Portfolio Mahasiswa
        |--------------------------------------------------------------------------
        |
        | Staff hanya dapat melihat portfolio.
        | Tidak ada route edit, update, atau delete.
        |
        */

        // Menampilkan seluruh portfolio mahasiswa
        Route::get('/portfolio', [PortfolioController::class, 'staffIndex'])
            ->name('portfolio.index');

        // Melihat file bukti portfolio
        // HARUS diletakkan sebelum route /portfolio/{portfolio}
        Route::get('/portfolio/{portfolio}/bukti', [PortfolioController::class, 'viewBukti'])
            ->name('portfolio.bukti');

        // Menampilkan detail portfolio
        Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'staffShow'])
            ->name('portfolio.show');


        /*
        |--------------------------------------------------------------------------
        | Data Lomba
        |--------------------------------------------------------------------------
        */

        Route::resource('lomba', LombaController::class)
            ->except(['show']);

        // Detail lomba
        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        /*
        |--------------------------------------------------------------------------
        | Kriteria Lomba
        |--------------------------------------------------------------------------
        */

        // Halaman kriteria
        Route::get('/kriteria', [KriteriaController::class, 'index'])
            ->name('kriteria.index');

        // Tambah kriteria
        Route::post('/kriteria', [KriteriaController::class, 'store'])
            ->name('kriteria.store');

        // Update kriteria
        Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])
            ->name('kriteria.update');

        // Hapus kriteria
        Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])
            ->name('kriteria.destroy');


        /*
        |--------------------------------------------------------------------------
        | Rekomendasi
        |--------------------------------------------------------------------------
        */

        // Halaman rekomendasi
        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])
            ->name('rekomendasi.index');

        // Proses perhitungan AHP + SAW
        Route::post('/rekomendasi/hitung', [RekomendasiController::class, 'calculate'])
            ->name('rekomendasi.calculate');

        // Detail rekomendasi berdasarkan lomba
        Route::get('/rekomendasi/{lomba}', [RekomendasiController::class, 'show'])
            ->name('rekomendasi.show');

        // Cetak PDF rekomendasi
        Route::get('/rekomendasi/{lomba}/pdf', [RekomendasiController::class, 'pdf'])
            ->name('rekomendasi.pdf');


        /*
        |--------------------------------------------------------------------------
        | Pendaftaran Mahasiswa
        |--------------------------------------------------------------------------
        */

        // Melihat seluruh pendaftaran
        Route::get('/pendaftaran', [PendaftaranController::class, 'staffIndex'])
            ->name('pendaftaran.index');

        // Menampilkan halaman edit pendaftaran
        Route::get('/pendaftaran/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])
            ->name('pendaftaran.edit');

        // Mengubah status pendaftaran & catatan
        Route::patch('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'updateStatus'])
            ->name('pendaftaran.status');
    });