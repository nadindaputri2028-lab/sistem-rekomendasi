@php 
    $mahasiswa = new \App\Models\Mahasiswa; 
@endphp

@extends('layouts.app')

@section('title', false ? 'Edit Data Mahasiswa' : 'Input Data Mahasiswa')

@section('content')
<div class="container">
    <div class="form-card card">
        <h2>{{ false ? 'Edit Data Mahasiswa' : 'Input Data Mahasiswa' }}</h2>
        <p class="sub">Kelola informasi profil dan data akademik mahasiswa.</p>

        <form 
            method="POST" 
            action="{{ false ? route('staff.mahasiswa.update', $mahasiswa) : route('staff.mahasiswa.store') }}" 
            enctype="multipart/form-data"
        >
            @csrf 
            @if(false) 
                @method('PUT') 
            @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input name="nama_lengkap" value="{{ old('nama_lengkap', '') }}" required>
                </div>

                <div class="field">
                    <label>NIM</label>
                    <input name="nim" value="{{ old('nim', '') }}" required>
                </div>

                <div class="field">
                    <label>Program Studi</label>
                    <input name="prodi" value="{{ old('prodi', '') }}" required>
                </div>

                <div class="field">
                    <label>Semester</label>
                    <input type="number" name="semester" value="{{ old('semester', '') }}" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', '') }}" required>
                </div>

                <div class="field">
                    <label>Nomor HP</label>
                    <input name="no_hp" value="{{ old('no_hp', '') }}">
                </div>

                <div class="field">
                    <label>IPK</label>
                    <input type="number" step=".01" name="ipk" value="{{ old('ipk', '') }}">
                </div>

                <div class="field">
                    <label>IPS Semester Ini</label>
                    <input type="number" step=".01" name="ips" value="{{ old('ips', '') }}">
                </div>
            </div>

            <div class="field">
                <label>Prestasi</label>
                <textarea name="prestasi">{{ old('prestasi', '') }}</textarea>
            </div>

            <div class="field">
                <label>Keahlian / Skill</label>
                <textarea name="keahlian">{{ old('keahlian', '') }}</textarea>
            </div>

            <div class="field">
                <label>Minat</label>
                <textarea name="minat">{{ old('minat', '') }}</textarea>
            </div>

            <div class="field">
                <label>Foto</label>
                <input type="file" name="foto" accept="image/*">
            </div>

            <button class="btn">Simpan Data</button> 
            <a class="btn outline" href="{{ route('staff.mahasiswa.index') }}">Batal</a>
        </form>
    </div>
</div>
@endsection