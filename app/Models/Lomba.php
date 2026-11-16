<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lomba extends Model
{
    use HasFactory;

    /**
     * Status lomba ketika masa pendaftaran telah lewat.
     */
    public const STATUS_DITUTUP = 'Pendaftaran Ditutup';

    protected $fillable = [
        'nama',
        'kategori',
        'subkategori',
        'penyelenggara',
        'tingkat',
        'tanggal_pelaksanaan',
        'deadline',
        'lokasi',
        'deskripsi',
        'persyaratan',
        'benefit',
        'panduan',
        'status',
    ];

    protected $casts = [
        'tanggal_pelaksanaan' => 'date',
        'deadline' => 'date',
    ];

    /**
     * Sisa hari menuju deadline pendaftaran.
     * Bernilai null jika deadline belum diisi.
     */
    public function getDaysUntilDeadlineAttribute(): ?int
    {
        if (!$this->deadline) {
            return null;
        }

        return (int) now()->startOfDay()->diffInDays(
            $this->deadline->startOfDay(),
            false
        );
    }

    /**
     * Apakah deadline akan segera berakhir
     * (dalam 7 hari ke depan dan belum lewat).
     */
    public function getDeadlineSoonAttribute(): bool
    {
        $days = $this->days_until_deadline;

        return $days !== null
            && $days >= 0
            && $days <= 7;
    }

    /**
     * Apakah masa pendaftaran lomba sudah kadaluarsa.
     *
     * Kadaluarsa bila tanggal deadline sudah melewati hari ini
     * (deadline berakhir pada pukul 23:59 hari tersebut).
     */
    public function getIsExpiredAttribute(): bool
    {
        if (!$this->deadline) {
            return false;
        }

        return $this->deadline->copy()->endOfDay()->isPast();
    }

    /**
     * Label status yang ditampilkan di UI.
     * Otomatis menjadi "Pendaftaran Ditutup" bila sudah kadaluarsa.
     */
    public function getStatusLabelAttribute(): string
    {
        if ($this->is_expired) {
            return self::STATUS_DITUTUP;
        }

        return $this->status ?: 'Aktif';
    }

    /**
     * Kelas warna badge status (green / orange / red).
     */
    public function getStatusClassAttribute(): string
    {
        if ($this->is_expired) {
            return 'red';
        }

        return match ($this->status) {
            'Aktif' => 'green',
            'Akan Datang' => 'orange',
            'Selesai', 'Kadaluarsa', self::STATUS_DITUTUP => 'red',
            default => 'green',
        };
    }

    /**
     * Tautan "Tambah ke Google Calendar" (Google Calendar render template).
     * Membuat event pengingat deadline pendaftaran lomba.
     */
    public function getGoogleCalendarUrlAttribute(): string
    {
        return app(\App\Services\GoogleCalendarService::class)->urlFor($this);
    }

    public function kriterias()
    {
        return $this->hasMany(Kriteria::class);
    }

    public function pendaftarans()
    {
        return $this->hasMany(Pendaftaran::class);
    }

    public function rekomendasis()
    {
        return $this->hasMany(Rekomendasi::class);
    }
}
