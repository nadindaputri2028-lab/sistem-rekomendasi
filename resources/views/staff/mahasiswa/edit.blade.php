@extends('layouts.app')

@section('title', $mahasiswa->exists ? 'Edit Data Mahasiswa' : 'Input Data Mahasiswa')

@section('content')
<div class="container">
    <div class="form-card card">
        <h2>{{ $mahasiswa->exists ? 'Edit Data Mahasiswa' : 'Input Data Mahasiswa' }}</h2>
        <p class="sub">Kelola informasi profil dan data akademik mahasiswa.</p>

        <form 
            method="POST" 
            action="{{ $mahasiswa->exists ? route('staff.mahasiswa.update', $mahasiswa) : route('staff.mahasiswa.store') }}" 
            enctype="multipart/form-data"
        >
            @csrf 
            @if($mahasiswa->exists) 
                @method('PUT') 
            @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input name="nama_lengkap" value="{{ old('nama_lengkap', $mahasiswa->nama_lengkap) }}" required>
                </div>

                <div class="field">
                    <label>NIM</label>
                    <input name="nim" value="{{ old('nim', $mahasiswa->nim) }}" required>
                </div>

                <div class="field">
                    <label>Program Studi</label>
                    <input name="prodi" value="{{ old('prodi', $mahasiswa->prodi) }}" required>
                </div>

                <div class="field">
                    <label>Semester</label>
                    <input type="number" name="semester" value="{{ old('semester', $mahasiswa->semester) }}" required>
                </div>

                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ old('email', $mahasiswa->email) }}" required>
                </div>

                <div class="field">
                    <label>Nomor HP</label>
                    <input name="no_hp" value="{{ old('no_hp', $mahasiswa->no_hp) }}">
                </div>

                <div class="field">
                    <label>IPK</label>
                    <input type="number" step=".01" name="ipk" value="{{ old('ipk', $mahasiswa->ipk) }}">
                </div>

                <div class="field">
                    <label>IPS Semester Ini</label>
                    <input type="number" step=".01" name="ips" value="{{ old('ips', $mahasiswa->ips) }}">
                </div>
            </div>

            <div class="field">
                <label>Prestasi</label>
                <textarea name="prestasi">{{ old('prestasi', $mahasiswa->prestasi) }}</textarea>
            </div>

            <div class="field">
                <label>Keahlian / Skill</label>
                <textarea name="keahlian">{{ old('keahlian', $mahasiswa->keahlian) }}</textarea>
            </div>

            <div class="field">
                <label>Minat</label>
                <textarea name="minat">{{ old('minat', $mahasiswa->minat) }}</textarea>
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