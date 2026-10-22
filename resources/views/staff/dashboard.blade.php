@extends('layouts.app')

@section('title', 'Dashboard Staff')

@section('content')
<div class="container">

    <div class="page-title">
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
                                            'Ditolak'  => 'red',
                                            default    => 'blue'
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


            {{-- ========================================= --}}
            {{-- PORTFOLIO MAHASISWA --}}
            {{-- ========================================= --}}

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
       DASHBOARD GRID
    ========================================= */

    .dashboard-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 24px;
        align-items: start;
        margin-top: 20px;
    }


    /* =========================================
       STATISTIK
    ========================================= */

    .stats-vertical {
        display: flex;
        flex-direction: column;
        gap: 16px;
    }

    .stat-card {
        background: #ffffff;
        padding: 18px 20px;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        display: flex;
        align-items: center;
        gap: 16px;
        border: 1px solid #f1f5f9;
    }

    .stat-card .icon {
        font-size: 28px;
    }

    .stat-info {
        display: flex;
        flex-direction: column;
    }

    .stat-info small {
        color: #64748b;
        font-size: 13px;
        margin-bottom: 2px;
    }

    .stat-info strong {
        font-size: 20px;
        color: #0f172a;
    }


    /* =========================================
       PORTFOLIO
    ========================================= */

    .portfolio-head {
        margin-top: 28px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .portfolio-head h2 {
        margin: 0;
    }

    .view-all {
        text-decoration: none;
        color: #2563eb;
        font-size: 14px;
        font-weight: 600;
    }

    .view-all:hover {
        text-decoration: underline;
    }


    .portfolio-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #f1f5f9;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }


    .portfolio-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        padding: 12px 20px;
        border-bottom: 1px solid #f1f5f9;
    }

    .portfolio-item:last-child {
        border-bottom: none;
    }


    .portfolio-info {
        min-width: 0;
        flex: 1;
    }


    .portfolio-info h3 {
        margin: 0 0 5px 0;
        font-size: 15px;
        color: #0f172a;
    }


    .student-name {
        margin: 0 0 6px 0;
        color: #475569;
        font-size: 13px;
        font-weight: 600;
    }


    .portfolio-detail {
        display: flex;
        flex-wrap: wrap;
        gap: 8px 18px;
    }


    .portfolio-detail span {
        color: #64748b;
        font-size: 12px;
    }


    .portfolio-detail strong {
        color: #334155;
    }


    .portfolio-action {
        flex-shrink: 0;
    }


    .btn-detail {
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


    .btn-detail:hover {
        background: #16304f;
        transform: translateY(-1px);
    }


    /* =========================================
       PORTFOLIO KOSONG
    ========================================= */

    .portfolio-empty {
        text-align: center;
        padding: 40px 20px;
    }


    .portfolio-empty .empty-icon {
        font-size: 40px;
        margin-bottom: 10px;
    }


    .portfolio-empty h3 {
        margin: 0 0 6px 0;
        color: #334155;
        font-size: 17px;
    }


    .portfolio-empty p {
        margin: 0;
        color: #64748b;
        font-size: 14px;
    }


    /* =========================================
       TABLE
    ========================================= */

    .table-card {
        overflow-x: auto;
    }


    /* =========================================
       RESPONSIVE
    ========================================= */

    @media (max-width: 992px) {

        .dashboard-grid {
            grid-template-columns: 1fr;
        }

        .stats-vertical {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
        }

    }


    @media (max-width: 576px) {

        .stats-vertical {
            grid-template-columns: 1fr;
        }

        .portfolio-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .portfolio-action {
            width: 100%;
        }

        .btn-detail {
            width: 100%;
            text-align: center;
        }

    }

</style>

@endsection