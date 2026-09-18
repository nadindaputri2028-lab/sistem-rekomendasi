<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Lomba extends Model
{
    use HasFactory;

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