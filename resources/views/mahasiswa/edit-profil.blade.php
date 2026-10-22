@extends('layouts.app')

@section('title', 'Edit Profil Mahasiswa')

@section('content')
<div class="container">
    <div class="card form-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 15px;">
            <div>
                <h2>Edit Profil</h2>
                <p class="sub">Mahasiswa hanya mengubah data profil dan pengalaman yang relevan.</p>
            </div>
            <!-- Tombol Kembali ke Halaman Detail -->
            <a href="{{ route('mahasiswa.profil.show') }}" class="btn secondary">
                &larr; Kembali
            </a>
        </div>

        <form method="POST" action="{{ route('mahasiswa.profil.update') }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="grid-2">
                <div class="field">
                    <label>Nama Lengkap</label>
                    <input name="nama_lengkap" value="{{ $m->nama_lengkap }}" required>
                </div>
                <div class="field">
                    <label>NIM</label>
                    <input name="nim" value="{{ $m->nim }}" required>
                </div>
                <div class="field">
                    <label>Program Studi</label>
                    <input name="prodi" value="{{ $m->prodi }}" required>
                </div>
                <div class="field">
                    <label>Semester</label>
                    <input type="number" name="semester" value="{{ $m->semester }}" required>
                </div>
                <div class="field">
                    <label>Email</label>
                    <input type="email" name="email" value="{{ $m->email }}" required>
                </div>
                <div class="field">
                    <label>Nomor HP</label>
                    <input name="no_hp" value="{{ $m->no_hp }}">
                </div>
            </div>

            <div class="field">
                <label>Prestasi</label>
                <textarea name="prestasi">{{ $m->prestasi }}</textarea>
            </div>
            <div class="field">
                <label>Keahlian / Skill</label>
                <textarea name="keahlian">{{ $m->keahlian }}</textarea>
            </div>
            <div class="field">
                <label>Minat</label>
                <select name="minat">
                    <option value="">Pilih Minat</option>
                    @php
                        $options = [
                            'Desain UI/UX',
                            'Desain Grafis',
                            'Pemrograman Web',
                            'Pemrograman Mobile',
                            'Data Analysis',
                            'Machine Learning',
                            'Cybersecurity',
                            'Cloud Computing'
                        ];
                        $selectedMinat = old('minat', $m->minat);
                    @endphp

                    @foreach($options as $opt)
                        <option value="{{ $opt }}" {{ $selectedMinat == $opt ? 'selected' : '' }}>
                            {{ $opt }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="field">
                <label>Foto Profil</label>
                <input type="file" name="foto" accept="image/*">
            </div>

            <div style="display: flex; gap: 10px; margin-top: 15px;">
                <button type="submit" class="btn">Simpan Data</button>
                <a href="{{ route('mahasiswa.profil.show') }}" class="btn secondary">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection