@extends('layouts.app')

@section('title', $portfolio->exists ? 'Edit Portfolio' : 'Tambah Portfolio')

@section('content')
<div class="container">
    <div class="form-card card">
        <h2>{{ $portfolio->exists ? 'Edit Portfolio' : 'Tambah Portfolio' }}</h2>

        <form 
            method="POST" 
            action="{{ $portfolio->exists ? route('mahasiswa.portfolio.update', $portfolio) : route('mahasiswa.portfolio.store') }}" 
            enctype="multipart/form-data"
        >
            @csrf 
            @if($portfolio->exists) 
                @method('PUT') 
            @endif

            <div class="grid-2">
                <div class="field">
                    <label>Nama Kegiatan</label>
                    <input name="nama_kegiatan" value="{{ old('nama_kegiatan', $portfolio->nama_kegiatan) }}" required>
                </div>

                <div class="field">
                    <label>Posisi / Kegiatan</label>
                    <input name="posisi" value="{{ old('posisi', $portfolio->posisi) }}">
                </div>

                <div class="field">
                    <label>Institusi / Organisasi</label>
                    <input name="organisasi" value="{{ old('organisasi', $portfolio->organisasi) }}">
                </div>

                <div class="field">
                    <label>Periode Mulai</label>
                    <input type="date" name="periode_mulai" value="{{ old('periode_mulai', $portfolio->periode_mulai?->format('Y-m-d')) }}">
                </div>

                <div class="field">
                    <label>Periode Selesai</label>
                    <input type="date" name="periode_selesai" value="{{ old('periode_selesai', $portfolio->periode_selesai?->format('Y-m-d')) }}">
                </div>

                <div class="field">
                    <label>Bukti / Dokumen</label>
                    <input type="file" name="bukti">
                </div>
            </div>

            <div class="field">
                <label>Deskripsi</label>
                <textarea name="deskripsi">{{ old('deskripsi', $portfolio->deskripsi) }}</textarea>
            </div>

            <button class="btn">Simpan</button> 
            <a class="btn outline" href="{{ route('mahasiswa.portfolio.index') }}">Batal</a>
        </form>
    </div>
</div>
@endsection