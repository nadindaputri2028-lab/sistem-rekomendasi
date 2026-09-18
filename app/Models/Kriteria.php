<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Kriteria extends Model
{
    use HasFactory;

    protected $fillable = [
        'lomba_id',
        'kode',
        'nama',
        'bobot',
        'jenis',
        'nilai_minimum',
        'deskripsi',
    ];

    protected $casts = [
        'bobot' => 'float',
        'nilai_minimum' => 'float',
    ];

    public function lomba()
    {
        return $this->belongsTo(Lomba::class);
    }
}