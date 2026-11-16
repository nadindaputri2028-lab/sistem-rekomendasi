<?php

namespace App\Services;

use App\Models\Lomba;
use Illuminate\Support\Carbon;

class GoogleCalendarService
{
    /**
     * Membuat tautan "Tambah ke Google Calendar" untuk sebuah lomba.
     *
     * Menggunakan Google Calendar render template sehingga pengguna
     * dapat menyimpan sendiri tenggat waktu pendaftaran ke kalender
     * Google miliknya tanpa perlu otentikasi tambahan.
     */
    public function urlFor(Lomba $lomba): string
    {
        $deadline = $lomba->deadline
            ? Carbon::parse($lomba->deadline)
            : Carbon::now();

        // All-day event: tanggal mulai / tanggal berakhir (eksklusif +1 hari).
        $dates = $deadline->format('Ymd')
            . '/'
            . $deadline->copy()->addDay()->format('Ymd');

        $params = http_build_query([
            'action' => 'TEMPLATE',
            'text' => 'Deadline Pendaftaran: ' . $lomba->nama,
            'dates' => $dates,
            'details' => $this->buildDetails($lomba),
            'location' => $lomba->lokasi ?: 'Online',
        ]);

        return 'https://calendar.google.com/calendar/render?' . $params;
    }

    /**
     * Cek apakah kredensial Google (untuk SSO) sudah dikonfigurasi.
     */
    public function isConfigured(): bool
    {
        return !empty(config('services.google.client_id'))
            && !empty(config('services.google.client_secret'));
    }

    /**
     * Deskripsi event kalender.
     */
    private function buildDetails(Lomba $lomba): string
    {
        $lines = [
            'Pengingat batas akhir pendaftaran lomba "' . $lomba->nama . '".',
        ];

        if ($lomba->penyelenggara) {
            $lines[] = 'Penyelenggara: ' . $lomba->penyelenggara;
        }

        if ($lomba->tingkat) {
            $lines[] = 'Tingkat: ' . $lomba->tingkat;
        }

        if ($lomba->deadline) {
            $lines[] = 'Deadline: ' . $lomba->deadline->format('d M Y');
        }

        return implode("\n", $lines);
    }
}
