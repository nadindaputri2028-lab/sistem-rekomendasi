@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container">
    <div class="profile">
        <div class="profile-cover"></div>

        <div class="profile-body">
            <div class="profile-head">
                <div>
                    <img 
                        class="avatar" 
                        src="{{ $mahasiswa->foto ? asset('storage/' . $mahasiswa->foto) : 'https://ui-avatars.com/api/?name=' . urlencode($mahasiswa->nama_lengkap) }}"
                    >
                    <h2>{{ $mahasiswa->nama_lengkap }}</h2>
                    <small>{{ $mahasiswa->nim }} · {{ $mahasiswa->prodi }}</small>
                </div>

                <a class="btn" href="{{ route('staff.mahasiswa.edit', $mahasiswa) }}">
                    Edit Profil
                </a>
            </div>

            <div class="info-grid">
                <div class="info-box">
                    <h4>Informasi Akademik</h4>
                    <p>IPK: {{ number_format($mahasiswa->ipk ?? 0, 2) }}</p>
                    <p>IPS: {{ number_format($mahasiswa->ips ?? 0, 2) }}</p>
                    <p>Semester: {{ $mahasiswa->semester }}</p>
                </div>

                <div class="info-box">
                    <h4>Kontak</h4>
                    <p>{{ $mahasiswa->email }}</p>
                    <p>{{ $mahasiswa->no_hp }}</p>
                </div>

                <div class="info-box">
                    <h4>Prestasi</h4>
                    <p>{{ $mahasiswa->prestasi ?: '-' }}</p>
                </div>

                <div class="info-box">
                    <h4>Skill & Minat</h4>
                    <p>{{ $mahasiswa->keahlian ?: '-' }}</p>
                    <p>{{ $mahasiswa->minat ?: '-' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection