<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Mahasiswa extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'nama_lengkap',
        'nim',
        'prodi',
        'semester',
        'email',
        'no_hp',
        'ipk',
        'ips',
        'foto',
        'prestasi',
        'keahlian',
        'minat',
    ];

    protected $casts = [
        'ipk' => 'float',
        'ips' => 'float',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
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