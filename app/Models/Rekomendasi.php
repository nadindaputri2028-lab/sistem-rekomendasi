<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Rekomendasi extends Model
{
    use HasFactory;

    protected $fillable = [
        'lomba_id',
        'mahasiswa_id',
        'nilai_akhir',
        'ranking',
        'status',
        'detail_nilai',
    ];

    protected $casts = [
        'nilai_akhir' => 'float',
        'detail_nilai' => 'array',
    ];

    /**
     * Persentase kecocokan (match score) yang tersimpan
     * di dalam kolom detail_nilai.
     */
    public function getMatchScoreAttribute(): ?float
    {
        $score = $this->detail_nilai['match_score'] ?? null;

        return $score === null ? null : (float) $score;
    }

    /**
     * Apakah mahasiswa memenuhi seluruh syarat nilai minimum.
     */
    public function getEligibleAttribute(): bool
    {
        return (bool) ($this->detail_nilai['eligible'] ?? false);
    }

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}