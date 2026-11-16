<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PenilaianDosen extends Model
{
    protected $table = 'penilaian_dosens';

    protected $fillable = [
        'mahasiswa_id',
        'dosen_id',
        'nilai_angka',
        'prestasi_akademik',
        'kedisiplinan',
        'keaktifan',
        'tanggung_jawab',
        'perkembangan_akademik',
        'konsultasi_akademik',
        'sikap_etika',
        'nilai_kriteria',
        'nilai_akhir',
        'catatan',
    ];

    public function mahasiswa()
    {
        return $this->belongsTo(Mahasiswa::class);
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }
}
