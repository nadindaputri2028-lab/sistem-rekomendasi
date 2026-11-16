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
use App\Http\Controllers\DosenController;
use App\Http\Controllers\PenilaianDosenController;


/*
|--------------------------------------------------------------------------
| HALAMAN UTAMA
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

// Satu halaman login untuk mahasiswa, staff, dan dosen.
Route::get('/login', function () {
    return view('auth.login');
})->name('login');

// Proses login semua role.
Route::post('/login', [AuthController::class, 'login']);

// Logout.
Route::post('/logout', [AuthController::class, 'logout'])
    ->name('logout');


/*
|--------------------------------------------------------------------------
| LOGIN GOOGLE
|--------------------------------------------------------------------------
*/

Route::get('/auth/google', [GoogleController::class, 'redirectToGoogle'])
    ->name('auth.google');

Route::get('/auth/google/callback', [GoogleController::class, 'handleGoogleCallback'])
    ->name('auth.google.callback');


/*
|--------------------------------------------------------------------------
| NOTIFIKASI
|--------------------------------------------------------------------------
*/

Route::middleware(['auth.session'])->group(function () {

    // Menampilkan notifikasi.
    Route::get('/notifikasi', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Menandai semua notifikasi sebagai dibaca.
    Route::post('/notifikasi/read-all', [NotificationController::class, 'readAll'])
        ->name('notifications.readAll');

    // Menghapus semua notifikasi.
    Route::delete('/notifikasi/hapus-semua', [NotificationController::class, 'destroyAll'])
        ->name('notifications.destroyAll');

    // Membuka notifikasi.
    Route::get('/notifikasi/{notification}/buka', [NotificationController::class, 'open'])
        ->name('notifications.open');

    // Menandai satu notifikasi sebagai dibaca.
    Route::post('/notifikasi/{notification}/read', [NotificationController::class, 'read'])
        ->name('notifications.read');

    // Menghapus satu notifikasi.
    Route::delete('/notifikasi/{notification}', [NotificationController::class, 'destroy'])
        ->name('notifications.destroy');

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

        // Dashboard mahasiswa.
        Route::get('/dashboard', [MahasiswaController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | PROFIL MAHASISWA
        |--------------------------------------------------------------------------
        */

        Route::get('/profil', [MahasiswaController::class, 'profil'])
            ->name('profil.show');

        Route::get('/profil/edit', [MahasiswaController::class, 'editProfil'])
            ->name('profil.edit');

        Route::put('/profil', [MahasiswaController::class, 'updateProfil'])
            ->name('profil.update');


        /*
        |--------------------------------------------------------------------------
        | PORTFOLIO MAHASISWA
        |--------------------------------------------------------------------------
        */

        // Export portfolio ke PDF.
        Route::get('/portfolio/pdf', [PortfolioController::class, 'exportPdf'])
            ->name('portfolio.pdf');

        // Preview bukti portfolio.
        Route::get('/portfolio/{portfolio}/lihat', [PortfolioController::class, 'previewBuktiMahasiswa'])
            ->name('portfolio.preview');

        // Download bukti portfolio.
        Route::get('/portfolio/{portfolio}/download', [PortfolioController::class, 'downloadBuktiMahasiswa'])
            ->name('portfolio.bukti');

        // Detail portfolio.
        Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'show'])
            ->name('portfolio.show');

        // CRUD portfolio.
        Route::resource('portfolio', PortfolioController::class)
            ->except(['show']);


        /*
        |--------------------------------------------------------------------------
        | LOMBA
        |--------------------------------------------------------------------------
        */

        Route::get('/lomba', [LombaController::class, 'index'])
            ->name('lomba.index');

        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        /*
        |--------------------------------------------------------------------------
        | REKOMENDASI
        |--------------------------------------------------------------------------
        */

        Route::get('/rekomendasi', [RekomendasiController::class, 'forStudent'])
            ->name('rekomendasi');


        /*
        |--------------------------------------------------------------------------
        | PENDAFTARAN
        |--------------------------------------------------------------------------
        */

        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])
            ->name('pendaftaran.index');

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

        // Dashboard staff.
        Route::get('/dashboard', [StaffController::class, 'dashboard'])
            ->name('dashboard');


        /*
        |--------------------------------------------------------------------------
        | DATA MAHASISWA
        |--------------------------------------------------------------------------
        */

        Route::resource('mahasiswa', StaffController::class)
            ->except(['show']);

        Route::get('/mahasiswa/{mahasiswa}', [StaffController::class, 'show'])
            ->name('mahasiswa.show');

        Route::patch('/mahasiswa/{mahasiswa}/toggle', [StaffController::class, 'toggleActive'])
            ->name('mahasiswa.toggle');

        // Export portfolio mahasiswa ke PDF.
        Route::get('/mahasiswa/{mahasiswa}/portfolio/pdf', [PortfolioController::class, 'exportPdfStaff'])
            ->name('mahasiswa.portfolio.pdf');


        /*
        |--------------------------------------------------------------------------
        | PORTFOLIO MAHASISWA
        |--------------------------------------------------------------------------
        */

        // Menampilkan seluruh portfolio.
        Route::get('/portfolio', [PortfolioController::class, 'staffIndex'])
            ->name('portfolio.index');

        // Download bukti portfolio.
        Route::get('/portfolio/{portfolio}/bukti', [PortfolioController::class, 'viewBukti'])
            ->name('portfolio.bukti');

        // Preview bukti portfolio.
        Route::get('/portfolio/{portfolio}/preview', [PortfolioController::class, 'previewBukti'])
            ->name('portfolio.preview');

        // Detail portfolio.
        Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'staffShow'])
            ->name('portfolio.show');


        /*
        |--------------------------------------------------------------------------
        | DATA LOMBA
        |--------------------------------------------------------------------------
        */

        Route::resource('lomba', LombaController::class)
            ->except(['show']);

        Route::get('/lomba/{lomba}', [LombaController::class, 'show'])
            ->name('lomba.show');


        /*
        |--------------------------------------------------------------------------
        | KRITERIA LOMBA
        |--------------------------------------------------------------------------
        */

        Route::get('/kriteria', [KriteriaController::class, 'index'])
            ->name('kriteria.index');

        Route::get('/kriteria/{kriteria}', [KriteriaController::class, 'show'])
            ->name('kriteria.show');

        Route::post('/kriteria', [KriteriaController::class, 'store'])
            ->name('kriteria.store');

        Route::put('/kriteria/{kriteria}', [KriteriaController::class, 'update'])
            ->name('kriteria.update');

        Route::delete('/kriteria/{kriteria}', [KriteriaController::class, 'destroy'])
            ->name('kriteria.destroy');


        /*
        |--------------------------------------------------------------------------
        | REKOMENDASI
        |--------------------------------------------------------------------------
        */

        Route::get('/rekomendasi', [RekomendasiController::class, 'index'])
            ->name('rekomendasi.index');

        Route::post('/rekomendasi/hitung', [RekomendasiController::class, 'calculate'])
            ->name('rekomendasi.calculate');

        Route::get('/rekomendasi/{lomba}/pdf', [RekomendasiController::class, 'pdf'])
            ->name('rekomendasi.pdf');

        Route::get('/rekomendasi/{lomba}', [RekomendasiController::class, 'show'])
            ->name('rekomendasi.show');


        /*
        |--------------------------------------------------------------------------
        | PENDAFTARAN MAHASISWA
        |--------------------------------------------------------------------------
        */

        Route::get('/pendaftaran', [PendaftaranController::class, 'staffIndex'])
            ->name('pendaftaran.index');

        Route::get('/pendaftaran/{pendaftaran}/edit', [PendaftaranController::class, 'edit'])
            ->name('pendaftaran.edit');

        Route::patch('/pendaftaran/{pendaftaran}', [PendaftaranController::class, 'updateStatus'])
            ->name('pendaftaran.status');

    });


/*
|--------------------------------------------------------------------------
| DOSEN PEMBIMBING AKADEMIK
|--------------------------------------------------------------------------
*/

        Route::middleware(['auth.session', 'role:dosen'])
            ->prefix('dosen')
            ->name('dosen.')
            ->group(function () {

        // Dashboard dosen.
        Route::get('/dashboard', [DosenController::class, 'dashboard'])
            ->name('dashboard');

            
        Route::get('/mahasiswa', [DosenController::class, 'mahasiswa'])
            ->name('mahasiswa.index');

        Route::get('/mahasiswa/{id}', [DosenController::class, 'mahasiswaDetail'])
            ->name('mahasiswa.show');

                    // Portfolio mahasiswa
        Route::get('/portfolio', [PortfolioController::class, 'dosenIndex'])
            ->name('portfolio.index');

        // Detail portfolio
        Route::get('/portfolio/{portfolio}', [PortfolioController::class, 'dosenShow'])
            ->name('portfolio.show');

        // Preview bukti portfolio
        Route::get('/portfolio/{portfolio}/preview', [PortfolioController::class, 'dosenPreviewBukti'])
            ->name('portfolio.preview');

        // Download bukti portfolio
        Route::get('/portfolio/{portfolio}/download', [PortfolioController::class, 'dosenDownloadBukti'])
            ->name('portfolio.download');

            // PENILAIAN MAHASISWA
        Route::get('/penilaian', [PenilaianDosenController::class, 'index'])
            ->name('penilaian.index');

        Route::get('/penilaian/{mahasiswa}/buat', [PenilaianDosenController::class, 'create'])
            ->name('penilaian.create');

        Route::post('/penilaian/{mahasiswa}', [PenilaianDosenController::class, 'store'])
            ->name('penilaian.store');

        Route::get('/penilaian/hasil/{penilaian}', [PenilaianDosenController::class, 'show'])
            ->name('penilaian.show');

            // PREVIEW BUKTI PORTFOLIO DOSEN
        Route::get('/portfolio/{portfolio}/preview',[PortfolioController::class, 'dosenPreviewBukti']
            )->name('portfolio.bukti.preview');

        // DOWNLOAD BUKTI PORTFOLIO DOSEN
        Route::get('/portfolio/{portfolio}/download',[PortfolioController::class, 'dosenDownloadBukti']
            )->name('portfolio.bukti.download');

    });


/*
|--------------------------------------------------------------------------
| PREVIEW FILE
|--------------------------------------------------------------------------
*/

Route::get('/preview-file/{path}', function ($path) {

    $filePath = storage_path('app/public/' . $path);

    if (!file_exists($filePath)) {
        $filePath = storage_path('app/' . $path);
    }

    if (!file_exists($filePath)) {
        abort(404, 'File tidak ditemukan');
    }

    return response()->file($filePath);

})->where('path', '.*')->name('file.preview');
