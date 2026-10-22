@extends('layouts.app')

@section('title', $lomba->exists ? 'Edit Data Lomba' : 'Input Data Lomba')

@section('content')
<div class="container">
    <div class="form-card card">
        <h2>{{ $lomba->exists ? 'Edit Data Lomba' : 'Input Data Lomba' }}</h2>
        <p class="sub">Tambah dan kelola informasi kompetisi akademik maupun nonakademik.</p>

        <form 
            method="POST" 
            action="{{ $lomba->exists ? route('staff.lomba.update', $lomba) : route('staff.lomba.store') }}"
        >
            @csrf 
            @if($lomba->exists) 
                @method('PUT') 
            @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nama Lomba</label>
                    <input name="nama" value="{{ old('nama', $lomba->nama) }}" required>
                </div>

                <div class="field">
                    <label>Kategori</label>
                    <select name="kategori">
                        <option>Akademik</option>
                        <option>Nonakademik</option>
                    </select>
                </div>

                <div class="field">
                    <label>Subkategori</label>
                    <input name="subkategori" value="{{ old('subkategori', $lomba->subkategori) }}">
                </div>

                <div class="field">
                    <label>Penyelenggara</label>
                    <input name="penyelenggara" value="{{ old('penyelenggara', $lomba->penyelenggara) }}" required>
                </div>

                <div class="field">
                    <label>Tingkat</label>
                    <input name="tingkat" value="{{ old('tingkat', $lomba->tingkat) }}">
                </div>

                <div class="field">
                    <label>Lokasi</label>
                    <input name="lokasi" value="{{ old('lokasi', $lomba->lokasi) }}">
                </div>

                <div class="field">
                    <label>Tanggal Pelaksanaan</label>
                    <input 
                        type="date" 
                        name="tanggal_pelaksanaan" 
                        value="{{ old('tanggal_pelaksanaan', $lomba->tanggal_pelaksanaan?->format('Y-m-d')) }}"
                    >
                </div>

                <div class="field">
                    <label>Berakhirnya Lomba</label>
                    <input 
                        type="date" 
                        name="deadline" 
                        value="{{ old('deadline', $lomba->deadline?->format('Y-m-d')) }}" 
                        required
                    >
                </div>

                <div class="field">
                    <label>Status</label>
                    <select name="status">
                        <option>Aktif</option>
                        <option>Akan Datang</option>
                        <option>Selesai</option>
                    </select>
                </div>

                <div class="field">
                    <label>Link Panduan</label>
                    <input name="panduan" value="{{ old('panduan', $lomba->panduan) }}" placeholder="https://...">
                </div>
            </div>

            <div class="field">
                <label>Deskripsi</label>
                <textarea name="deskripsi">{{ old('deskripsi', $lomba->deskripsi) }}</textarea>
            </div>

            <div class="field">
                <label>Persyaratan</label>
                <textarea name="persyaratan">{{ old('persyaratan', $lomba->persyaratan) }}</textarea>
            </div>

            <div class="field">
                <label>Benefit</label>
                <textarea name="benefit">{{ old('benefit', $lomba->benefit) }}</textarea>
            </div>

            <button class="btn">Simpan Lomba</button> 
            <a class="btn outline" href="{{ route('staff.lomba.index') }}">Batal</a>
        </form>
    </div>
</div>
@endsection