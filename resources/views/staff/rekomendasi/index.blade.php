@extends('layouts.app')

@section('title', 'Rekomendasi Mahasiswa')

@section('content')
<div class="container">
    <div class="page-title">
        <h1>Rekomendasi Mahasiswa</h1>
        <p>Hasil perhitungan AHP dan SAW untuk menentukan ranking mahasiswa sesuai kriteria lomba.</p>
    </div>

    <div class="card form-card">
        <form method="POST" action="{{ route('staff.rekomendasi.calculate') }}">
            @csrf
            
            <div class="field">
                <label>Pilih Lomba</label>
                <select name="lomba_id" required>
                    <option value="">-- Pilih Kompetisi --</option>
                    @foreach($lombas as $l)
                        <option value="{{ $l->id }}">
                            {{ $l->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn">🔎 Tampilkan & Hitung Rekomendasi</button>
        </form>
    </div>
</div>
@endsection