@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container">
    <div class="profile">
        <div class="profile-cover"></div>
        <div class="profile-body">
            <div class="profile-head">
                <div style="display:flex; gap:15px; align-items:center">
                    <img class="avatar" 
                         src="{{ $m->foto ? asset('storage/'.$m->foto) : 'https://ui-avatars.com/api/?name='.urlencode($m->nama_lengkap) }}" 
                         alt="Foto Profil">
                    <div>
                        <h2>{{ $m->nama_lengkap }}</h2>
                        <small>NIM: {{ $m->nim }}</small>
                    </div>
                </div>
                <a href="{{ route('mahasiswa.profil.edit') }}" class="btn small">
                    ✎ Edit Profil
                </a>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h4>📚 Ringkasan Akademik</h4>
                    <p>IPK Terakhir: <b>{{ number_format($m->ipk ?? 0, 2) }}</b></p>
                    <p>IPS Terakhir: <b>{{ number_format($m->ips ?? 0, 2) }}</b></p>
                    <p>Semester: <b>{{ $m->semester }}</b></p>
                </div>

                <div class="info-box">
                    <h4>👤 Informasi Akademik</h4>
                    <p>Program Studi: <b>{{ $m->prodi }}</b></p>
                    <p>Email: {{ $m->email }}</p>
                    <p>No. HP: {{ $m->no_hp ?? '-' }}</p>
                </div>

                <div class="info-box">
                    <h4>🏆 Prestasi</h4>
                    <p>{{ $m->prestasi ?: 'Belum ada data.' }}</p>
                </div>

                <div class="info-box">
                    <h4>⚙ Keahlian & Minat</h4>
                    <p><b>Keahlian:</b> {{ $m->keahlian ?: '-' }}</p>
                    <p><b>Minat:</b> {{ $m->minat ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection