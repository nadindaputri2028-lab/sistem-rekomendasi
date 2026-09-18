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

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }
}