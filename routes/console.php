<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

/*
|--------------------------------------------------------------------------
| Penjadwalan Otomatisasi Status Lomba
|--------------------------------------------------------------------------
|
| Menutup otomatis status lomba yang masa pendaftarannya telah kadaluarsa.
| Jalankan scheduler dengan: php artisan schedule:work
|
*/

Schedule::command('lomba:update-status')->daily();
