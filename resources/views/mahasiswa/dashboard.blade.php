
@extends('layouts.app')

@section('title', 'Dashboard Mahasiswa')

@section('content')

@php
    $segeraBerakhir = $lombas->filter(function ($l) {
        return $l->deadline_soon;
    });
@endphp

<style>
/* =========================================
   DASHBOARD MAHASISWA
========================================= */

.sr-dashboard {
    background: #f3f7fc;
    min-height: calc(100vh - 64px);
    padding: 18px 22px;
    color: #17365d;
    font-family: Arial, Helvetica, sans-serif;
}

.sr-dashboard * {
    box-sizing: border-box;
}

.sr-container {
    max-width: 1600px;
    margin: auto;
}

/* NAVBAR */

body:has(.sr-dashboard) .navbar {
    background: #fff;
    border-bottom: 1px solid #e5edf6;
    box-shadow: 0 2px 10px rgba(20, 50, 90, .05);
}

body:has(.sr-dashboard) .navbar nav {
    gap: 5px;
}

body:has(.sr-dashboard) .navbar nav a {
    padding: 11px 13px;
    border-radius: 10px;
    font-weight: 600;
    transition: .2s;
}

body:has(.sr-dashboard) .navbar nav a:hover {
    background: #eaf2ff;
    color: #075eb8;
}

/* HERO */

.sr-hero {
    position: relative;
    overflow: hidden;
    min-height: 210px;
    border-radius: 18px;
    padding: 30px 36px;
    display: flex;
    align-items: center;
    justify-content: space-between;
    background: linear-gradient(110deg, #123e78, #075eb8 65%, #378fe0);
    color: white;
    margin-bottom: 18px;
}

.sr-hero::before {
    content: "";
    position: absolute;
    width: 350px;
    height: 350px;
    border: 35px solid rgba(255,255,255,.08);
    border-radius: 50%;
    right: 12%;
    top: -170px;
}

.sr-hero::after {
    content: "🎓";
    position: absolute;
    right: 8%;
    bottom: -18px;
    font-size: 125px;
    opacity: .22;
    transform: rotate(-12deg);
}

.sr-hero-content {
    position: relative;
    z-index: 2;
}

.sr-hero small {
    font-size: 18px;
}

.sr-hero h1 {
    font-size: clamp(25px, 4vw, 38px);
    margin: 5px 0 10px;
    font-weight: 800;
}

.sr-hero p {
    margin: 0;
    font-size: 14px;
    color: #e2efff;
}

.sr-hero-info {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    margin-top: 19px;
}

.sr-hero-info span {
    background: rgba(255,255,255,.15);
    border: 1px solid rgba(255,255,255,.12);
    border-radius: 30px;
    padding: 9px 16px;
    font-size: 12px;
    font-weight: 600;
}

/* STATISTIK */

.sr-stats {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 14px;
    margin-bottom: 20px;
}

.sr-stat {
    min-height: 115px;
    border-radius: 17px;
    padding: 19px;
    display: flex;
    align-items: center;
    gap: 15px;
    box-shadow: 0 3px 10px rgba(30, 60, 100, .05);
}

.sr-stat:nth-child(1) {
    background: linear-gradient(120deg, #e0efff, #c8e1ff);
}

.sr-stat:nth-child(2) {
    background: linear-gradient(120deg, #eee5ff, #e3d6ff);
}

.sr-stat:nth-child(3) {
    background: linear-gradient(120deg, #dcfce7, #c9f4d8);
}

.sr-stat:nth-child(4) {
    background: linear-gradient(120deg, #fff0d9, #ffe4bd);
}

.sr-stat-icon {
    width: 62px;
    height: 62px;
    border-radius: 50%;
    background: rgba(255,255,255,.55);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 28px;
    flex-shrink: 0;
}

.sr-stat-info small {
    display: block;
    color: #365578;
    font-size: 12px;
    font-weight: 600;
}

.sr-stat-info strong {
    display: block;
    color: #173e70;
    font-size: 29px;
    margin-top: 5px;
}

/* KONTEN UTAMA */

.sr-content-grid {
    display: grid;
    grid-template-columns: minmax(0, 2.2fr) minmax(260px, .9fr);
    gap: 16px;
    align-items: start;
}

.sr-panel {
    background: #fff;
    border: 1px solid #e8eef6;
    border-radius: 18px;
    padding: 20px;
    box-shadow: 0 3px 12px rgba(25, 55, 90, .05);
    min-width: 0;
}

.sr-section-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 10px;
    margin-bottom: 18px;
}

.sr-section-heading h2 {
    margin: 0;
    font-size: 19px;
    color: #17365d;
}

.sr-section-heading a {
    color: #075eb8;
    font-size: 12px;
    font-weight: 700;
    text-decoration: none;
    white-space: nowrap;
}

.sr-section-heading a:hover {
    text-decoration: underline;
}

/* KARTU LOMBA */

.sr-lomba-grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 13px;
}

.sr-lomba-card {
    border: 1px solid #e3eaf3;
    border-radius: 14px;
    overflow: hidden;
    background: #fff;
    box-shadow: 0 3px 9px rgba(20, 50, 90, .07);
    display: flex;
    flex-direction: column;
    min-width: 0;
    transition: transform .2s, box-shadow .2s;
}

.sr-lomba-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 17px rgba(20, 50, 90, .12);
}

.sr-lomba-cover {
    min-height: 112px;
    padding: 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #07458e, #1679ce);
    color: white;
    font-size: 39px;
    position: relative;
}

.sr-lomba-card:nth-child(2) .sr-lomba-cover {
    background: linear-gradient(135deg, #49328f, #8965df);
}

.sr-lomba-card:nth-child(3) .sr-lomba-cover {
    background: linear-gradient(135deg, #087b70, #26ae9c);
}

.sr-lomba-body {
    padding: 13px;
    display: flex;
    flex-direction: column;
    flex: 1;
}

.sr-lomba-badge {
    display: inline-block;
    width: fit-content;
    padding: 5px 9px;
    background: #e6f1ff;
    color: #075eb8;
    font-size: 10px;
    font-weight: 700;
    border-radius: 20px;
    margin-bottom: 9px;
}

.sr-lomba-body h3 {
    font-size: 14px;
    color: #17365d;
    line-height: 1.4;
    margin: 0 0 10px;
    min-height: 39px;
}

.sr-lomba-meta {
    font-size: 11px;
    line-height: 1.9;
    color: #52657d;
    margin-bottom: 12px;
}

.sr-lomba-actions {
    display: flex;
    gap: 7px;
    margin-top: auto;
}

.sr-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    text-decoration: none;
    padding: 9px 11px;
    border-radius: 9px;
    font-size: 11px;
    font-weight: 700;
    transition: .2s;
    flex: 1;
}

.sr-btn-detail {
    color: #075eb8;
    border: 1px solid #cbdff8;
    background: white;
}

.sr-btn-detail:hover {
    background: #eff6ff;
}

.sr-btn-primary {
    color: white;
    background: #075eb8;
}

.sr-btn-primary:hover {
    background: #064b91;
}

/* PENGINGAT DEADLINE */

.sr-deadline {
    border-radius: 12px;
    background: #fff4f3;
    border: 1px solid #fee0dc;
    padding: 13px;
    margin-bottom: 16px;
}

.sr-deadline h3 {
    color: #b42318;
    font-size: 13px;
    margin: 0 0 10px;
}

.sr-deadline-item {
    font-size: 11px;
    color: #783b37;
    line-height: 1.6;
    padding: 8px 0;
    border-top: 1px solid #f8d9d5;
}

.sr-deadline-item:first-of-type {
    border-top: 0;
}

.sr-deadline-item strong {
    display: block;
}

/* PANEL INFORMASI */

.sr-info-box {
    border: 1px solid #e8eef6;
    border-radius: 12px;
    padding: 14px;
    margin-bottom: 12px;
}

.sr-info-box:last-child {
    margin-bottom: 0;
}

.sr-info-box small {
    display: block;
    color: #718096;
    font-size: 11px;
}

.sr-info-box strong {
    display: block;
    color: #173e70;
    font-size: 23px;
    margin-top: 5px;
}

.sr-info-box p {
    font-size: 11px;
    color: #718096;
    margin: 5px 0 0;
    line-height: 1.5;
}

.sr-empty {
    padding: 35px 15px;
    text-align: center;
    color: #718096;
    font-size: 13px;
    background: #f8fafc;
    border-radius: 12px;
    grid-column: 1 / -1;
}

/* BANNER BAWAH */

.sr-bottom-banner {
    margin-top: 17px;
    padding: 20px 25px;
    border-radius: 16px;
    background: linear-gradient(110deg, #123e78, #075eb8, #398bd5);
    color: white;
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 15px;
}

.sr-bottom-banner h3 {
    margin: 0 0 6px;
    font-size: 17px;
}

.sr-bottom-banner p {
    margin: 0;
    font-size: 12px;
    color: #e1efff;
}

.sr-bottom-banner a {
    background: white;
    color: #075eb8;
    border-radius: 30px;
    padding: 11px 16px;
    text-decoration: none;
    font-size: 11px;
    font-weight: 700;
    white-space: nowrap;
}

/* RESPONSIVE */

@media (max-width: 1100px) {
    .sr-stats {
        grid-template-columns: repeat(2, 1fr);
    }

    .sr-lomba-grid {
        grid-template-columns: repeat(2, minmax(0, 1fr));
    }
}

@media (max-width: 850px) {
    .sr-content-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 600px) {
    .sr-dashboard {
        padding: 12px;
    }

    .sr-hero {
        padding: 24px 20px;
        min-height: 190px;
    }

    .sr-hero::after {
        right: -10px;
        font-size: 85px;
    }

    .sr-hero p {
        max-width: 85%;
        line-height: 1.5;
    }

    .sr-stats {
        gap: 9px;
    }

    .sr-stat {
        padding: 12px;
        min-height: 90px;
        gap: 9px;
    }

    .sr-stat-icon {
        width: 43px;
        height: 43px;
        font-size: 20px;
    }

    .sr-stat-info strong {
        font-size: 22px;
    }

    .sr-stat-info small {
        font-size: 10px;
    }

    .sr-lomba-grid {
        grid-template-columns: 1fr;
    }

    .sr-panel {
        padding: 14px;
    }

    .sr-bottom-banner {
        flex-direction: column;
        align-items: flex-start;
    }
}
</style>

<div class="sr-dashboard">
<div class="sr-container">

    {{-- BANNER SAMBUTAN --}}
    <section class="sr-hero">
        <div class="sr-hero-content">
            <small>Selamat Datang,</small>

            <h1>{{ $m->nama_lengkap }} 👋</h1>

            <p>
                Semangat terus dalam mengembangkan potensi
                dan meraih prestasi terbaik!
            </p>

            <div class="sr-hero-info">
                <span>🎓 Semester: {{ $m->semester ?? '-' }}</span>
                <span>📚 Prodi: {{ $m->prodi ?? '-' }}</span>
            </div>
        </div>
    </section>

    {{-- STATISTIK --}}
    <section class="sr-stats">

        <div class="sr-stat">
            <div class="sr-stat-icon">⭐</div>
            <div class="sr-stat-info">
                <small>IPK Terakhir</small>
                <strong>{{ number_format($m->ipk ?? 0, 2) }}</strong>
            </div>
        </div>

        <div class="sr-stat">
            <div class="sr-stat-icon">📖</div>
            <div class="sr-stat-info">
                <small>IPS Semester Ini</small>
                <strong>{{ number_format($m->ips ?? 0, 2) }}</strong>
            </div>
        </div>

        <div class="sr-stat">
            <div class="sr-stat-icon">📁</div>
            <div class="sr-stat-info">
                <small>Jumlah Portofolio</small>
                <strong>{{ $m->portfolios->count() }}</strong>
            </div>
        </div>

        <div class="sr-stat">
            <div class="sr-stat-icon">📝</div>
            <div class="sr-stat-info">
                <small>Jumlah Pendaftaran</small>
                <strong>{{ $pendaftaran }}</strong>
            </div>
        </div>

    </section>

    {{-- KONTEN DASHBOARD --}}
    <section class="sr-content-grid">

        {{-- REKOMENDASI LOMBA --}}
        <div class="sr-panel">

            <div class="sr-section-heading">
                <h2>🏆 Rekomendasi Lomba</h2>

                <a href="{{ route('mahasiswa.rekomendasi') }}">
                    Lihat Semua →
                </a>
            </div>

            {{-- KARTU LOMBA --}}
            <div class="sr-lomba-grid">

                @forelse($lombas as $l)

                    <article class="sr-lomba-card">

                        <div class="sr-lomba-cover">
                            🏆
                        </div>

                        <div class="sr-lomba-body">

                            <span class="sr-lomba-badge">
                                {{ strtoupper($l->kategori ?? 'UMUM') }}
                            </span>

                            <h3>{{ $l->nama }}</h3>

                            <div class="sr-lomba-meta">
                                📅 Berakhir:
                                {{ $l->deadline?->format('d M Y') ?? '-' }}

                                <br>

                                📍 {{ $l->lokasi ?? 'Online' }}

                                <br>

                                🏢 {{ $l->penyelenggara ?? '-' }}

                                @if($l->deadline_soon)
                                    <br>
                                    <strong style="color:#dc2626;">
                                        ⏰
                                        {{ $l->days_until_deadline === 0
                                            ? 'Berakhir hari ini'
                                            : 'Tersisa '.$l->days_until_deadline.' hari' }}
                                    </strong>
                                @endif
                            </div>

                            <div class="sr-lomba-actions">

                                <a
                                    href="{{ route('mahasiswa.lomba.show', $l) }}"
                                    class="sr-btn sr-btn-detail"
                                >
                                    ◉ Detail
                                </a>

                                <a
                                    href="{{ route('mahasiswa.lomba.show', $l) }}"
                                    class="sr-btn sr-btn-primary"
                                >
                                    Lihat Lomba →
                                </a>

                            </div>

                        </div>

                    </article>

                @empty

                    <div class="sr-empty">
                        <div style="font-size:35px; margin-bottom:10px;">
                            🏆
                        </div>

                        <strong>Belum Ada Lomba Aktif</strong>

                        <p>Informasi lomba akan muncul di sini.</p>
                    </div>

                @endforelse

            </div>

        </div>

        {{-- INFORMASI SAMPING --}}
        <aside class="sr-panel">

            <div class="sr-section-heading">
                <h2>📊 Informasi Saya</h2>
            </div>

            <div class="sr-info-box">
                <small>Total Portofolio</small>

                <strong>{{ $m->portfolios->count() }}</strong>

                <p>Portofolio yang telah kamu buat.</p>
            </div>

            <div class="sr-info-box">
                <small>Total Pendaftaran</small>

                <strong>{{ $pendaftaran }}</strong>

                <p>Jumlah pendaftaran lomba kamu.</p>
            </div>

            <div class="sr-info-box">
                <small>Lomba Aktif</small>

                <strong>{{ $lombas->count() }}</strong>

                <p>Jumlah lomba aktif yang ditampilkan pada dashboard.</p>
            </div>

            {{-- PENGINGAT DEADLINE --}}
            @if($segeraBerakhir->count() > 0)

                <div class="sr-deadline">

                    <h3>⏰ Pengingat Deadline</h3>

                    @foreach($segeraBerakhir as $l)

                        <div class="sr-deadline-item">

                            <strong>{{ $l->nama }}</strong>

                            {{ $l->days_until_deadline === 0
                                ? 'Berakhir hari ini'
                                : 'Tersisa '.$l->days_until_deadline.' hari lagi' }}

                            <br>

                            {{ $l->deadline?->format('d M Y') ?? '-' }}

                        </div>

                    @endforeach

                </div>

            @else

                <div class="sr-info-box">
                    <small>Pengingat Deadline</small>
                    <p>Tidak ada lomba yang mendekati deadline.</p>
                </div>

            @endif

        </aside>

    </section>

    {{-- BANNER BAWAH --}}
    <section class="sr-bottom-banner">

        <div>
            <h3>🏆 Terus Berkembang Bersama Kami</h3>

            <p>
                Raih lebih banyak kesempatan,
                wujudkan prestasi terbaikmu di sini!
            </p>
        </div>

        <a href="{{ route('mahasiswa.rekomendasi') }}">
            Lihat Rekomendasi Lainnya →
        </a>

    </section>

</div>
</div>

@endsection
