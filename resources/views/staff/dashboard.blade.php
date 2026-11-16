
@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('content')
<div class="container staff-dashboard">

    {{-- HEADER DASHBOARD --}}
    <div class="staff-hero">
        <h1>Dashboard Staff</h1>
        <p>Selamat datang kembali, berikut adalah ringkasan data operasional sistem hari ini.</p>
    </div>

    {{-- WRAPPER DUA KOLOM BERDAMPINGAN --}}
    <div class="dashboard-grid">

        {{-- KOLOM KIRI: RINGKASAN DATA --}}
        <div class="dashboard-sidebar">

            <div class="section-head">
                <h2>Ringkasan Data</h2>
            </div>

            <div class="stats-vertical">

                <div class="stat-card">
                    <span class="icon">👥</span>
                    <div class="stat-info">
                        <small>Total Mahasiswa</small>
                        <strong>{{ number_format($totalMahasiswa) }}</strong>
                    </div>
                </div>

                <div class="stat-card">
                    <span class="icon">💼</span>
                    <div class="stat-info">
                        <small>Total Portfolio</small>
                        <strong>{{ number_format($totalPortfolio) }}</strong>
                    </div>
                </div>

                <div class="stat-card">
                    <span class="icon">🏆</span>
                    <div class="stat-info">
                        <small>Total Lomba</small>
                        <strong>{{ number_format($totalLomba) }}</strong>
                    </div>
                </div>

                <div class="stat-card">
                    <span class="icon">📝</span>
                    <div class="stat-info">
                        <small>Total Pendaftaran</small>
                        <strong>{{ number_format($totalPendaftaran) }}</strong>
                    </div>
                </div>

            </div>
        </div>

        {{-- KOLOM KANAN: AKTIVITAS TERBARU --}}
        <div class="dashboard-main">

            <div class="section-head">
                <h2>Aktivitas Terbaru</h2>
            </div>

            <div class="table-card card">

                <table class="table">

                    <thead>
                        <tr>
                            <th>AKTIVITAS</th>
                            <th>MAHASISWA</th>
                            <th>LOMBA</th>
                            <th>WAKTU</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($terbaru as $p)

                            <tr>
                                <td>Pendaftaran Lomba</td>

                                <td>
                                    {{ $p->mahasiswa->nama_lengkap ?? '-' }}
                                </td>

                                <td>
                                    {{ $p->lomba->nama ?? '-' }}
                                </td>

                                <td>
                                    {{ $p->created_at->diffForHumans() }}
                                </td>

                                <td>
                                    @php
                                        $badgeClass = match($p->status) {
                                            'Diterima' => 'green',
                                            'Ditolak' => 'red',
                                            default => 'blue'
                                        };
                                    @endphp

                                    <span class="badge {{ $badgeClass }}">
                                        {{ $p->status }}
                                    </span>
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="empty">
                                    Belum ada aktivitas.
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

            {{-- PORTFOLIO MAHASISWA --}}
            <div class="section-head portfolio-head">
                <h2>Portfolio Mahasiswa</h2>

                <a href="{{ route('staff.portfolio.index') }}" class="view-all">
                    Lihat Semua
                </a>
            </div>

            <div class="portfolio-card">

                @forelse($portfolios as $portfolio)

                    <div class="portfolio-item">

                        <div class="portfolio-info">

                            <h3>
                                {{ $portfolio->nama_kegiatan }}
                            </h3>

                            <p class="student-name">
                                {{ $portfolio->mahasiswa->nama_lengkap ?? 'Mahasiswa' }}
                            </p>

                            <div class="portfolio-detail">

                                @if($portfolio->posisi)
                                    <span>
                                        <strong>Posisi:</strong>
                                        {{ $portfolio->posisi }}
                                    </span>
                                @endif

                                @if($portfolio->organisasi)
                                    <span>
                                        <strong>Organisasi:</strong>
                                        {{ $portfolio->organisasi }}
                                    </span>
                                @endif

                                @if($portfolio->periode_mulai || $portfolio->periode_selesai)
                                    <span>
                                        <strong>Periode:</strong>

                                        {{ $portfolio->periode_mulai
                                            ? \Carbon\Carbon::parse($portfolio->periode_mulai)->format('d/m/Y')
                                            : '-' }}

                                        s/d

                                        {{ $portfolio->periode_selesai
                                            ? \Carbon\Carbon::parse($portfolio->periode_selesai)->format('d/m/Y')
                                            : '-' }}
                                    </span>
                                @endif

                            </div>

                        </div>

                        <div class="portfolio-action">

                            <a href="{{ route('staff.portfolio.show', $portfolio->id) }}"
                               class="btn-detail">
                                Lihat Detail
                            </a>

                        </div>

                    </div>

                @empty

                    <div class="portfolio-empty">
                        <div class="empty-icon">💼</div>

                        <h3>Belum Ada Portfolio</h3>

                        <p>
                            Belum ada mahasiswa yang menambahkan portfolio.
                        </p>
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</div>


<style>

/* =========================================
   DASHBOARD STAFF
========================================= */

.staff-dashboard {
    color: #334155;
}

/* =========================================
   HEADER DASHBOARD STAFF
========================================= */

.staff-dashboard .staff-hero {
    background: linear-gradient(110deg, #123e78, #075eb8 65%, #378fe0);
    border-radius: 18px;
    padding: 30px 36px;
    margin-top: 25px;
    margin-bottom: 25px;
    box-shadow: 0 5px 15px rgba(30, 58, 95, 0.12);
}

.staff-dashboard .staff-hero h1 {
    color: #ffffff;
    font-size: 28px;
    font-weight: 700;
    margin: 0 0 8px 0;
}

.staff-dashboard .staff-hero p {
    color: #eaf3ff;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

/* =========================================
   DASHBOARD GRID
========================================= */

.staff-dashboard .dashboard-grid {
    display: grid;
    grid-template-columns: 300px 1fr;
    gap: 24px;
    align-items: start;
    margin-top: 20px;
    margin-bottom: 40px;
}

.staff-dashboard .section-head h2 {
    color: #1e3a5f;
}

/* =========================================
   STATISTIK
========================================= */

.staff-dashboard .stats-vertical {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.staff-dashboard .stat-card {
    background: #ffffff;
    padding: 18px 20px;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(30, 58, 95, 0.07);
    display: flex;
    align-items: center;
    gap: 16px;
    border: 1px solid #dbe5f0;
}

.staff-dashboard .stat-card .icon {
    font-size: 28px;
}

.staff-dashboard .stat-info {
    display: flex;
    flex-direction: column;
}

.staff-dashboard .stat-info small {
    color: #475569;
    font-size: 13px;
    margin-bottom: 2px;
}

.staff-dashboard .stat-info strong {
    font-size: 20px;
    color: #1e3a5f;
}

/* =========================================
   TABEL AKTIVITAS
========================================= */

.staff-dashboard .table-card {
    background: #ffffff;
    border: 1px solid #dbe5f0;
    border-radius: 12px;
    box-shadow: 0 2px 8px rgba(30, 58, 95, 0.06);
    overflow-x: auto;
}

.staff-dashboard .table {
    width: 100%;
    border-collapse: collapse;
    background: #ffffff;
}

.staff-dashboard .table thead {
    background: #eff6ff;
}

.staff-dashboard .table th {
    color: #1e3a5f;
    font-size: 12px;
    font-weight: 700;
    padding: 15px 14px;
    border-bottom: 1px solid #dbe5f0;
    white-space: nowrap;
}

.staff-dashboard .table td {
    color: #334155;
    font-size: 13px;
    padding: 15px 14px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-dashboard .table tbody tr:last-child td {
    border-bottom: none;
}

.staff-dashboard .table tbody tr:hover {
    background: #f8fbff;
}

.staff-dashboard .table .empty {
    text-align: center;
    color: #475569;
    padding: 25px;
}

/* STATUS */

.staff-dashboard .badge.green {
    background: #dcfce7;
    color: #166534;
}

.staff-dashboard .badge.red {
    background: #fee2e2;
    color: #991b1b;
}

.staff-dashboard .badge.blue {
    background: #dbeafe;
    color: #1e40af;
}

/* =========================================
   PORTFOLIO
========================================= */

.staff-dashboard .portfolio-head {
    margin-top: 28px;
    display: flex;
    align-items: center;
    justify-content: space-between;
}

.staff-dashboard .portfolio-head h2 {
    margin: 0;
}

.staff-dashboard .view-all {
    text-decoration: none;
    color: #1d4ed8;
    font-size: 14px;
    font-weight: 600;
}

.staff-dashboard .view-all:hover {
    color: #1e3a5f;
    text-decoration: underline;
}

.staff-dashboard .portfolio-card {
    background: #ffffff;
    border-radius: 12px;
    border: 1px solid #dbe5f0;
    box-shadow: 0 2px 8px rgba(30, 58, 95, 0.06);
    overflow: hidden;
}

.staff-dashboard .portfolio-item {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 20px;
    padding: 12px 20px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-dashboard .portfolio-item:last-child {
    border-bottom: none;
}

.staff-dashboard .portfolio-info {
    min-width: 0;
    flex: 1;
}

.staff-dashboard .portfolio-info h3 {
    margin: 0 0 5px 0;
    font-size: 15px;
    color: #1e3a5f;
}

.staff-dashboard .student-name {
    margin: 0 0 6px 0;
    color: #334155;
    font-size: 13px;
    font-weight: 600;
}

.staff-dashboard .portfolio-detail {
    display: flex;
    flex-wrap: wrap;
    gap: 8px 18px;
}

.staff-dashboard .portfolio-detail span {
    color: #475569;
    font-size: 12px;
}

.staff-dashboard .portfolio-detail strong {
    color: #1e3a5f;
}

/* TOMBOL DETAIL */

.staff-dashboard .portfolio-action {
    flex-shrink: 0;
}

.staff-dashboard .btn-detail {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 8px;
    background: #1e3a5f;
    color: #ffffff;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    transition: 0.2s;
}

.staff-dashboard .btn-detail:hover {
    background: #2563a6;
    transform: translateY(-1px);
}

/* =========================================
   PORTFOLIO KOSONG
========================================= */

.staff-dashboard .portfolio-empty {
    text-align: center;
    padding: 40px 20px;
}

.staff-dashboard .portfolio-empty .empty-icon {
    font-size: 40px;
    margin-bottom: 10px;
}

.staff-dashboard .portfolio-empty h3 {
    margin: 0 0 6px 0;
    color: #1e3a5f;
    font-size: 17px;
}

.staff-dashboard .portfolio-empty p {
    margin: 0;
    color: #475569;
    font-size: 14px;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 992px) {

    .staff-dashboard .dashboard-grid {
        grid-template-columns: 1fr;
    }

    .staff-dashboard .stats-vertical {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
    }

}

@media (max-width: 576px) {

    .staff-dashboard .staff-hero {
        padding: 24px 20px;
    }

    .staff-dashboard .staff-hero h1 {
        font-size: 23px;
    }

    .staff-dashboard .stats-vertical {
        grid-template-columns: 1fr;
    }

    .staff-dashboard .portfolio-item {
        flex-direction: column;
        align-items: flex-start;
    }

    .staff-dashboard .portfolio-action {
        width: 100%;
    }

    .staff-dashboard .btn-detail {
        width: 100%;
        text-align: center;
    }

}

</style>

@endsection
