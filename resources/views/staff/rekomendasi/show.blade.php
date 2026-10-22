@extends('layouts.app')

@section('title', 'Hasil Rekomendasi')

@section('content')
<div class="container">
    <div class="section-head">
        <div class="page-title" style="margin: 0;">
            <h1>Rekomendasi Mahasiswa</h1>
            <p>{{ $lomba->nama }}</p>
        </div>
        <a class="btn outline" href="{{ route('staff.rekomendasi.pdf', $lomba) }}" target="_blank">
            Export / Print
        </a>
    </div>

    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>RANK</th>
                    <th>NAMA MAHASISWA</th>
                    <th>NIM</th>
                    <th>PRODI</th>
                    <th>IPK</th>
                    <th>NILAI AKHIR</th>
                    <th>STATUS</th>
                </tr>
            </thead>
            <tbody>
                @forelse($results as $r)
                    <tr>
                        <td class="{{ $r->ranking === 1 ? 'rank-1' : '' }}">
                            #{{ $r->ranking }}
                        </td>
                        <td>
                            <b>{{ $r->mahasiswa->nama_lengkap }}</b>
                        </td>
                        <td>{{ $r->mahasiswa->nim }}</td>
                        <td>{{ $r->mahasiswa->prodi }}</td>
                        <td>{{ number_format($r->mahasiswa->ipk ?? 0, 2) }}</td>
                        <td>
                            <b>{{ number_format($r->nilai_akhir * 100, 2) }}</b>
                        </td>
                        <td>
                            <span class="badge {{ $r->status === 'Direkomendasikan' ? 'green' : ($r->status === 'Tidak Direkomendasikan' ? 'red' : 'orange') }}">
                                {{ $r->status }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">
                            Belum ada hasil. Jalankan perhitungan terlebih dahulu.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($criteria->count())
        <div class="card" style="padding: 18px; margin-top: 18px;">
            <h3>Bobot Kriteria AHP</h3>
            <p class="meta">Bobot digunakan oleh SAW untuk menghitung nilai akhir.</p>
            
            <div style="display: flex; gap: 10px; flex-wrap: wrap;">
                @php 
                    $sum = $criteria->sum('bobot') ?: 1; 
                @endphp 

                @foreach($criteria as $c)
                    <span class="badge">
                        {{ $c->kode }} · {{ $c->nama }} · {{ number_format($c->bobot / $sum * 100, 2) }}%
                    </span>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection