@extends('layouts.app')

@section('title', 'Detail Kriteria')

@section('content')

<div class="container">

    <div class="section-head">
        <div class="page-title" style="margin: 0;">
            <h1>Detail Kriteria</h1>
            <p>
                Lomba:
                <b>{{ $kriteria->lomba?->nama ?? '-' }}</b>
            </p>
        </div>

        <a
            class="btn outline"
            href="{{ route('staff.kriteria.index', ['lomba_id' => $kriteria->lomba_id]) }}"
        >
            ← Kembali ke Daftar Kriteria
        </a>
    </div>

    @if(session('success'))
        <div class="card" style="padding:14px 18px; margin-bottom:16px; border-left:4px solid #16a34a; color:#166534;">
            {{ session('success') }}
        </div>
    @endif

    {{-- RINGKASAN --}}
    <div class="card" style="padding:20px; margin-bottom:16px;">
        <div class="info-grid">
            <div class="info-box">
                <h4>Kode</h4>
                <p><b>{{ $kriteria->kode }}</b></p>
            </div>

            <div class="info-box">
                <h4>Nama Kriteria</h4>
                <p><b>{{ $kriteria->nama }}</b></p>
            </div>

            <div class="info-box">
                <h4>Bobot AHP</h4>
                <p>{{ $kriteria->bobot }}</p>
            </div>

            <div class="info-box">
                <h4>Jenis</h4>
                <p>
                    <span class="badge {{ $kriteria->jenis === 'benefit' ? 'green' : 'orange' }}">
                        {{ ucfirst($kriteria->jenis) }}
                    </span>
                </p>
            </div>

            <div class="info-box">
                <h4>Nilai Minimum</h4>
                <p>{{ $kriteria->nilai_minimum }}</p>
            </div>
        </div>

        <div class="info-box" style="margin-top:14px;">
            <h4>Deskripsi</h4>
            <p>{{ $kriteria->deskripsi ?: 'Belum ada deskripsi.' }}</p>
        </div>
    </div>

    {{-- FORM EDIT --}}
    <div class="card form-card">
        <h3>Edit Kriteria</h3>

        <form
            method="POST"
            action="{{ route('staff.kriteria.update', $kriteria) }}"
        >
            @csrf
            @method('PUT')

            <div class="grid-2">

                <div class="field">
                    <label for="kode">Kode</label>
                    <input
                        type="text"
                        id="kode"
                        name="kode"
                        value="{{ old('kode', $kriteria->kode) }}"
                        maxlength="10"
                        required
                    >
                    @error('kode')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="nama">Nama Kriteria</label>
                    <input
                        type="text"
                        id="nama"
                        name="nama"
                        value="{{ old('nama', $kriteria->nama) }}"
                        required
                    >
                    @error('nama')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="bobot">Bobot AHP</label>
                    <input
                        type="number"
                        id="bobot"
                        name="bobot"
                        step="0.01"
                        min="0"
                        value="{{ old('bobot', $kriteria->bobot) }}"
                        required
                    >
                    @error('bobot')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="jenis">Jenis</label>
                    <select id="jenis" name="jenis" required>
                        <option value="benefit" @selected(old('jenis', $kriteria->jenis) === 'benefit')>
                            Benefit
                        </option>
                        <option value="cost" @selected(old('jenis', $kriteria->jenis) === 'cost')>
                            Cost
                        </option>
                    </select>
                    @error('jenis')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

                <div class="field">
                    <label for="nilai_minimum">Nilai Minimum</label>
                    <input
                        type="number"
                        id="nilai_minimum"
                        name="nilai_minimum"
                        step="0.01"
                        min="0"
                        value="{{ old('nilai_minimum', $kriteria->nilai_minimum) }}"
                    >
                    @error('nilai_minimum')
                        <small style="color:#dc2626;">{{ $message }}</small>
                    @enderror
                </div>

            </div>

            <div class="field">
                <label for="deskripsi">Deskripsi</label>
                <textarea
                    id="deskripsi"
                    name="deskripsi"
                    rows="4"
                >{{ old('deskripsi', $kriteria->deskripsi) }}</textarea>
                @error('deskripsi')
                    <small style="color:#dc2626;">{{ $message }}</small>
                @enderror
            </div>

            <button type="submit" class="btn">
                Simpan Perubahan
            </button>
        </form>
    </div>

</div>

@endsection
