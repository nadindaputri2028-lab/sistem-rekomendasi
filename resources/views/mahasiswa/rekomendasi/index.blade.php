
@extends('layouts.app')

@section('title', 'Rekomendasi Lomba')

@section('content')

<style>
/* =====================================
   REKOMENDASI MAHASISWA
===================================== */

.rec-page {
    min-height: calc(100vh - 64px);
    padding: 25px;
    background: #f3f7fc;
    color: #17365d;
    font-family: Arial, Helvetica, sans-serif;
}

.rec-page * {
    box-sizing: border-box;
}

.rec-container {
    max-width: 1450px;
    margin: auto;
}

/* HEADER */

.rec-header {
    padding: 28px 32px;
    border-radius: 18px;
    background: linear-gradient(115deg, #123e78, #075eb8, #398bd5);
    color: white;
    margin-bottom: 22px;
    position: relative;
    overflow: hidden;
}

.rec-header::after {
    content: "★";
    position: absolute;
    right: 45px;
    top: -35px;
    font-size: 160px;
    color: rgba(255,255,255,.10);
}

.rec-header-content {
    position: relative;
    z-index: 1;
}

.rec-header small {
    color: #dbeafe;
    font-size: 13px;
}

.rec-header h1 {
    font-size: 29px;
    margin: 8px 0;
    font-weight: 800;
}

.rec-header p {
    color: #e4efff;
    font-size: 13px;
    margin: 0;
    line-height: 1.7;
}

/* INFORMASI MAHASISWA */

.rec-profile {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 18px;
}

.rec-profile span {
    padding: 8px 14px;
    border-radius: 30px;
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.15);
    font-size: 12px;
}

/* RINGKASAN */

.rec-summary {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 15px;
    margin-bottom: 22px;
}

.rec-summary-card {
    background: white;
    border: 1px solid #e4edf7;
    border-radius: 15px;
    padding: 19px;
    box-shadow: 0 3px 12px rgba(20,50,90,.04);
}

.rec-summary-card small {
    display: block;
    color: #64748b;
    font-size: 12px;
    font-weight: 600;
}

.rec-summary-card strong {
    display: block;
    color: #075eb8;
    font-size: 27px;
    margin-top: 8px;
}

/* JUDUL */

.rec-section-title {
    margin-bottom: 17px;
}

.rec-section-title h2 {
    font-size: 21px;
    color: #17365d;
    margin: 0 0 6px;
}

.rec-section-title p {
    color: #718096;
    font-size: 12px;
    margin: 0;
}

/* KARTU REKOMENDASI */

.rec-list {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 17px;
}

.rec-card {
    background: white;
    border: 1px solid #e4edf7;
    border-radius: 17px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(20,50,90,.05);
    transition: .2s;
    min-width: 0;
}

.rec-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(20,50,90,.10);
}

.rec-card-top {
    padding: 19px;
    background: #f8fbff;
    border-bottom: 1px solid #edf2f8;
}

.rec-card-heading {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 12px;
}

.rec-category {
    display: inline-block;
    background: #e7f1ff;
    color: #075eb8;
    border-radius: 20px;
    padding: 6px 11px;
    font-size: 10px;
    font-weight: 800;
    text-transform: uppercase;
}

.rec-card h3 {
    font-size: 17px;
    color: #17365d;
    line-height: 1.5;
    margin: 11px 0;
}

.rec-rank {
    min-width: 39px;
    height: 39px;
    border-radius: 11px;
    background: #e7f1ff;
    color: #075eb8;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 13px;
    font-weight: 800;
}

.rec-card-body {
    padding: 19px;
}

/* MATCH SCORE */

.rec-match {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 10px;
}

.rec-match small {
    color: #64748b;
    font-size: 12px;
    font-weight: 700;
}

.rec-match strong {
    font-size: 22px;
    color: #075eb8;
}

.rec-progress {
    height: 9px;
    background: #e9eff7;
    border-radius: 20px;
    overflow: hidden;
    margin-bottom: 15px;
}

.rec-progress-fill {
    height: 100%;
    border-radius: 20px;
    background: linear-gradient(90deg, #075eb8, #45a0ee);
    transition: width .3s;
}

/* STATUS */

.rec-status {
    display: inline-flex;
    align-items: center;
    gap: 7px;
    padding: 7px 11px;
    border-radius: 8px;
    font-size: 11px;
    font-weight: 700;
    margin-bottom: 16px;
}

.rec-status.eligible {
    background: #e8f8ef;
    color: #15803d;
}

.rec-status.not-eligible {
    background: #fff1f0;
    color: #c24136;
}

/* INFORMASI LOMBA */

.rec-info {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 10px;
    margin-bottom: 16px;
}

.rec-info-item {
    background: #f8fafc;
    border: 1px solid #edf2f7;
    border-radius: 10px;
    padding: 11px;
    min-width: 0;
}

.rec-info-item small {
    display: block;
    color: #718096;
    font-size: 10px;
    margin-bottom: 5px;
}

.rec-info-item strong {
    display: block;
    color: #334e68;
    font-size: 12px;
    overflow-wrap: anywhere;
}

/* DETAIL KRITERIA */

.rec-detail {
    border-top: 1px solid #edf2f7;
    padding-top: 14px;
}

.rec-detail summary {
    cursor: pointer;
    font-size: 12px;
    color: #075eb8;
    font-weight: 700;
    list-style-position: inside;
    padding: 5px 0;
}

.rec-detail-content {
    margin-top: 10px;
}

.rec-criteria {
    display: flex;
    justify-content: space-between;
    gap: 12px;
    padding: 10px;
    background: #f8fafc;
    border-radius: 9px;
    margin-bottom: 7px;
    font-size: 11px;
}

.rec-criteria-name {
    color: #334e68;
    font-weight: 700;
}

.rec-criteria-value {
    text-align: right;
    color: #64748b;
}

.rec-check {
    display: block;
    margin-top: 4px;
    font-size: 10px;
    font-weight: 700;
}

.rec-check.yes {
    color: #15803d;
}

.rec-check.no {
    color: #dc2626;
}

/* TOMBOL */

.rec-actions {
    display: flex;
    gap: 9px;
    margin-top: 16px;
}

.rec-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    text-decoration: none;
    border-radius: 9px;
    padding: 11px 14px;
    font-size: 11px;
    font-weight: 700;
    flex: 1;
    transition: .2s;
}

.rec-btn-primary {
    background: #075eb8;
    color: white;
}

.rec-btn-primary:hover {
    background: #064b91;
    color: white;
}

.rec-btn-outline {
    background: white;
    border: 1px solid #cbdff8;
    color: #075eb8;
}

.rec-btn-outline:hover {
    background: #eff6ff;
}

/* KOSONG */

.rec-empty {
    background: white;
    border: 1px solid #e4edf7;
    border-radius: 17px;
    padding: 55px 20px;
    text-align: center;
    grid-column: 1 / -1;
}

.rec-empty-icon {
    font-size: 45px;
    margin-bottom: 13px;
}

.rec-empty h3 {
    color: #17365d;
    font-size: 17px;
    margin-bottom: 7px;
}

.rec-empty p {
    color: #718096;
    font-size: 12px;
}

/* RESPONSIVE */

@media(max-width: 850px) {
    .rec-list {
        grid-template-columns: 1fr;
    }
}

@media(max-width: 600px) {
    .rec-page {
        padding: 13px;
    }

    .rec-header {
        padding: 23px 19px;
    }

    .rec-header h1 {
        font-size: 23px;
    }

    .rec-header::after {
        right: -25px;
        font-size: 110px;
    }

    .rec-summary {
        grid-template-columns: 1fr 1fr;
        gap: 9px;
    }

    .rec-summary-card {
        padding: 14px;
    }

    .rec-summary-card:last-child {
        grid-column: 1 / -1;
    }

    .rec-summary-card strong {
        font-size: 23px;
    }

    .rec-info {
        grid-template-columns: 1fr 1fr;
    }

    .rec-card-top,
    .rec-card-body {
        padding: 15px;
    }
}
</style>

@php
    $totalLomba = $lombas->count();

    $totalEligible = $lombas->where('eligible', true)->count();

    $rataKecocokan = $totalLomba > 0
        ? round($lombas->avg('match_score'), 2)
        : 0;
@endphp

<div class="rec-page">
    <div class="rec-container">

        {{-- HEADER --}}
        <section class="rec-header">
            <div class="rec-header-content">

                <small>PERSONALIZED RECOMMENDATION</small>

                <h1>Rekomendasi Lomba</h1>

                <p>
                    Temukan lomba yang paling sesuai dengan kemampuan,
                    pengalaman, dan profil akademik kamu.
                </p>

                <div class="rec-profile">
                    <span>Mahasiswa: {{ $m->nama_lengkap }}</span>
                    <span>Program Studi: {{ $m->prodi ?? '-' }}</span>
                    <span>Semester: {{ $m->semester ?? '-' }}</span>
                </div>

            </div>
        </section>

        {{-- RINGKASAN --}}
        <section class="rec-summary">

            <div class="rec-summary-card">
                <small>Total Lomba yang Cocok</small>
                <strong>{{ $totalLomba }}</strong>
            </div>

            <div class="rec-summary-card">
                <small>Memenuhi Semua Syarat</small>
                <strong>{{ $totalEligible }}</strong>
            </div>

            <div class="rec-summary-card">
                <small>Rata-rata Kecocokan</small>
                <strong>{{ number_format($rataKecocokan, 2) }}%</strong>
            </div>

        </section>

        {{-- DAFTAR REKOMENDASI --}}
        <div class="rec-section-title">
            <h2>Hasil Rekomendasi Untuk Kamu</h2>
            <p>
                Daftar lomba diurutkan berdasarkan persentase kecocokan tertinggi.
            </p>
        </div>

        <section class="rec-list">

            @forelse($lombas as $index => $l)

                @php
                    $matchScore = max(0, min(100, (float) $l->match_score));
                @endphp

                <article class="rec-card">

                    <div class="rec-card-top">

                        <div class="rec-card-heading">

                            <div>
                                <span class="rec-category">
                                    {{ strtoupper($l->kategori ?? 'UMUM') }}
                                </span>

                                <h3>{{ $l->nama }}</h3>
                            </div>

                            <div class="rec-rank">
                                #{{ $index + 1 }}
                            </div>

                        </div>

                    </div>

                    <div class="rec-card-body">

                        {{-- MATCH SCORE --}}
                        <div class="rec-match">
                            <small>Persentase Kecocokan</small>

                            <strong>
                                {{ number_format($l->match_score, 2) }}%
                            </strong>
                        </div>

                        <div
                            class="rec-progress"
                            role="progressbar"
                            aria-valuenow="{{ $matchScore }}"
                            aria-valuemin="0"
                            aria-valuemax="100"
                            aria-label="Persentase kecocokan"
                        >
                            <div
                                class="rec-progress-fill"
                                style="width: {{ $matchScore }}%;"
                            ></div>
                        </div>

                        {{-- STATUS KELAYAKAN --}}
                        @if($l->eligible)

                            <div class="rec-status eligible">
                                ✓ Memenuhi Semua Persyaratan
                            </div>

                        @else

                            <div class="rec-status not-eligible">
                                ! Belum Memenuhi Semua Persyaratan
                            </div>

                        @endif

                        {{-- INFORMASI LOMBA --}}
                        <div class="rec-info">

                            <div class="rec-info-item">
                                <small>Deadline</small>
                                <strong>
                                    {{ $l->deadline?->format('d M Y') ?? '-' }}
                                </strong>
                            </div>

                            <div class="rec-info-item">
                                <small>Tingkat Lomba</small>
                                <strong>{{ $l->tingkat ?? '-' }}</strong>
                            </div>

                            <div class="rec-info-item">
                                <small>Lokasi</small>
                                <strong>{{ $l->lokasi ?? 'Online' }}</strong>
                            </div>

                            <div class="rec-info-item">
                                <small>Penyelenggara</small>
                                <strong>{{ $l->penyelenggara ?? '-' }}</strong>
                            </div>

                        </div>

                        {{-- RINCIAN KRITERIA --}}
                        <details class="rec-detail">

                            <summary>
                                Lihat Rincian Kecocokan Kriteria
                            </summary>

                            <div class="rec-detail-content">

                                @forelse($l->match_detail as $detail)

                                    <div class="rec-criteria">

                                        <div>
                                            <div class="rec-criteria-name">
                                                {{ $detail['nama'] ?? 'Kriteria' }}
                                            </div>

                                            <span class="rec-check {{ $detail['terpenuhi'] ? 'yes' : 'no' }}">
                                                {{ $detail['terpenuhi'] ? '✓ Terpenuhi' : '✕ Belum terpenuhi' }}
                                            </span>
                                        </div>

                                        <div class="rec-criteria-value">
                                            <strong>
                                                {{ $detail['nilai'] ?? 0 }}
                                            </strong>

                                            <div>
                                                Minimum:
                                                {{ $detail['nilai_minimum'] ?? 0 }}
                                            </div>
                                        </div>

                                    </div>

                                @empty

                                    <p style="font-size:12px;color:#718096;">
                                        Belum tersedia rincian kriteria untuk lomba ini.
                                    </p>

                                @endforelse

                            </div>

                        </details>

                        {{-- TOMBOL --}}
                        <div class="rec-actions">

                            <a
                                href="{{ route('mahasiswa.lomba.show', $l) }}"
                                class="rec-btn rec-btn-primary"
                            >
                                Lihat Detail Lomba →
                            </a>

                        </div>

                    </div>

                </article>

            @empty

                <div class="rec-empty">

                    <div class="rec-empty-icon">🏆</div>

                    <h3>Belum Ada Rekomendasi Lomba</h3>

                    <p>
                        Belum tersedia lomba aktif yang dapat direkomendasikan.
                        Silakan periksa kembali nanti.
                    </p>

                    <a
                        href="{{ route('mahasiswa.lomba.index') }}"
                        class="rec-btn rec-btn-primary"
                        style="max-width:200px;margin:18px auto 0;"
                    >
                        Lihat Semua Lomba
                    </a>

                </div>

            @endforelse

        </section>

    </div>
</div>

@endsection
