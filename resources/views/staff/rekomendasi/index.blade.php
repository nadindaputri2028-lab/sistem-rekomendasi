```blade
@extends('layouts.app')

@section('title', 'Rekomendasi Mahasiswa')

@section('content')

<div class="container staff-rekomendasi-page">

    {{-- HEADER HALAMAN --}}
    <div class="rekomendasi-header">
        <div>
            <h1>Rekomendasi Mahasiswa</h1>
            <p>
                Hasil perhitungan AHP dan SAW untuk menentukan ranking
                mahasiswa sesuai kriteria lomba.
            </p>
        </div>
    </div>

    {{-- FORM PILIH LOMBA --}}
    <div class="rekomendasi-card">

        <div class="rekomendasi-card-header">
            <h2>Pilih Kompetisi</h2>
            <p>
                Pilih lomba untuk menampilkan dan menghitung rekomendasi
                mahasiswa berdasarkan kriteria yang telah ditentukan.
            </p>
        </div>

        <form method="POST" action="{{ route('staff.rekomendasi.calculate') }}">
            @csrf

            <div class="rekomendasi-field">
                <label for="lomba_id">Nama Lomba</label>

                <select name="lomba_id" id="lomba_id" required>
                    <option value="">-- Pilih Kompetisi --</option>

                    @foreach($lombas as $l)
                        <option value="{{ $l->id }}">
                            {{ $l->nama }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="rekomendasi-actions">
                <button type="submit" class="rekomendasi-btn">
                    🔎 Tampilkan & Hitung Rekomendasi
                </button>
            </div>
        </form>

    </div>

</div>

<style>
/* HALAMAN */
.staff-rekomendasi-page {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER */
.staff-rekomendasi-page .rekomendasi-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 25px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-rekomendasi-page .rekomendasi-header h1 {
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 8px;
}

.staff-rekomendasi-page .rekomendasi-header p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

/* CARD FORM */
.staff-rekomendasi-page .rekomendasi-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 26px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-rekomendasi-page .rekomendasi-card-header {
    margin-bottom: 25px;
    padding-bottom: 18px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-rekomendasi-page .rekomendasi-card-header h2 {
    color: #1e3a5f;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 7px;
}

.staff-rekomendasi-page .rekomendasi-card-header p {
    color: #64748b;
    font-size: 13px;
    line-height: 1.6;
    margin: 0;
}

/* FORM */
.staff-rekomendasi-page .rekomendasi-field {
    display: flex;
    flex-direction: column;
    gap: 9px;
    max-width: 650px;
}

.staff-rekomendasi-page .rekomendasi-field label {
    color: #334155;
    font-size: 14px;
    font-weight: 600;
}

.staff-rekomendasi-page .rekomendasi-field select {
    width: 100%;
    min-height: 45px;
    padding: 10px 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 14px;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.staff-rekomendasi-page .rekomendasi-field select:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

/* BUTTON */
.staff-rekomendasi-page .rekomendasi-actions {
    margin-top: 22px;
}

.staff-rekomendasi-page .rekomendasi-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    min-height: 43px;
    padding: 11px 20px;
    border: none;
    border-radius: 8px;
    background: #1e3a5f;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: background 0.2s, transform 0.2s;
}

.staff-rekomendasi-page .rekomendasi-btn:hover {
    background: #274b78;
    transform: translateY(-1px);
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .staff-rekomendasi-page {
        padding-top: 20px;
    }

    .staff-rekomendasi-page .rekomendasi-header,
    .staff-rekomendasi-page .rekomendasi-card {
        padding: 20px;
    }

    .staff-rekomendasi-page .rekomendasi-header h1 {
        font-size: 21px;
    }

    .staff-rekomendasi-page .rekomendasi-btn {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .staff-rekomendasi-page .rekomendasi-header,
    .staff-rekomendasi-page .rekomendasi-card {
        padding: 16px;
    }
}
</style>

@endsection
```