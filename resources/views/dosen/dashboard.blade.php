
@extends('layouts.app')

@section('title', 'Dashboard Dosen')

@section('content')
<div class="container staff-dashboard dosen-dashboard">

    {{-- HEADER --}}
    <div class="staff-hero">
        <div class="hero-content">
            <span class="hero-label">DOSEN PEMBIMBING AKADEMIK</span>
            <h1>Dashboard Dosen</h1>
            <p>
                Selamat datang di halaman Dosen Pembimbing Akademik.
                Pantau perkembangan dan aktivitas mahasiswa melalui sistem ini.
            </p>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="dashboard-content">

        <div class="dashboard-section">

            <div class="section-heading">
                <div>
                    <h2>Ringkasan Data</h2>
                    <p>Informasi keseluruhan data dalam sistem.</p>
                </div>
            </div>

            <div class="stats-grid">

                {{-- TOTAL MAHASISWA --}}
                <div class="stat-card">
                    <div class="stat-icon blue">
                        <i class="fas fa-user-graduate"></i>
                    </div>

                    <div class="stat-info">
                        <p>Total Mahasiswa</p>
                        <h2>{{ $totalMahasiswa }}</h2>
                        <span>Mahasiswa terdaftar</span>
                    </div>
                </div>

                {{-- TOTAL PORTFOLIO --}}
                <div class="stat-card">
                    <div class="stat-icon purple">
                        <i class="fas fa-folder-open"></i>
                    </div>

                    <div class="stat-info">
                        <p>Total Portfolio</p>
                        <h2>{{ $totalPortfolio }}</h2>
                        <span>Portfolio mahasiswa</span>
                    </div>
                </div>

                {{-- TOTAL LOMBA --}}
                <div class="stat-card">
                    <div class="stat-icon orange">
                        <i class="fas fa-trophy"></i>
                    </div>

                    <div class="stat-info">
                        <p>Total Lomba</p>
                        <h2>{{ $totalLomba }}</h2>
                        <span>Lomba tersedia dalam sistem</span>
                    </div>
                </div>

                {{-- TOTAL PENDAFTARAN --}}
                <div class="stat-card">
                    <div class="stat-icon green">
                        <i class="fas fa-clipboard-list"></i>
                    </div>

                    <div class="stat-info">
                        <p>Total Pendaftaran</p>
                        <h2>{{ $totalPendaftaran }}</h2>
                        <span>Pendaftaran mahasiswa</span>
                    </div>
                </div>

            </div>
        </div>

    </div>

</div>

<style>
/* DASHBOARD DOSEN */

.dosen-dashboard {
    padding-bottom: 35px;
}

/* HEADER */

.staff-hero {
    position: relative;
    overflow: hidden;
    padding: 35px;
    margin-bottom: 30px;
    border-radius: 18px;
    background: linear-gradient(120deg, #1e3a5f, #315f91);
    color: #fff;
    box-shadow: 0 8px 22px rgba(30, 58, 95, 0.15);
}

.hero-content {
    position: relative;
    z-index: 1;
}

.hero-label {
    display: inline-block;
    margin-bottom: 12px;
    font-size: 11px;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #c9ddf3;
}

.staff-hero h1 {
    margin: 0 0 10px;
    font-size: 28px;
    font-weight: 700;
    color: #fff;
}

.staff-hero p {
    margin: 0;
    font-size: 14px;
    color: #e2edf8;
    line-height: 1.7;
}

/* KONTEN */

.dashboard-content {
    display: flex;
    flex-direction: column;
    gap: 25px;
}

.dashboard-section {
    background: #fff;
    padding: 25px;
    border-radius: 16px;
    border: 1px solid #e8edf3;
    box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
}

.section-heading {
    margin-bottom: 22px;
}

.section-heading h2 {
    margin: 0 0 6px;
    font-size: 19px;
    font-weight: 700;
    color: #1e3a5f;
}

.section-heading p {
    margin: 0;
    font-size: 13px;
    color: #7b8797;
}

/* KARTU STATISTIK */

.stats-grid {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 18px;
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 18px;
    padding: 22px;
    background: #f8fafc;
    border: 1px solid #e7edf5;
    border-radius: 14px;
    transition: 0.2s ease;
}

.stat-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 7px 18px rgba(30, 58, 95, 0.08);
}

.stat-icon {
    width: 55px;
    height: 55px;
    min-width: 55px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 13px;
    font-size: 22px;
}

.stat-icon.blue {
    background: #e5effb;
    color: #2563eb;
}

.stat-icon.purple {
    background: #f0eaff;
    color: #7c3aed;
}

.stat-icon.orange {
    background: #fff1df;
    color: #ea580c;
}

.stat-icon.green {
    background: #dcfce7;
    color: #16a34a;
}

.stat-info p {
    margin: 0 0 5px;
    color: #64748b;
    font-size: 13px;
    font-weight: 600;
}

.stat-info h2 {
    margin: 0 0 5px;
    color: #1e3a5f;
    font-size: 27px;
    font-weight: 700;
}

.stat-info span {
    color: #94a3b8;
    font-size: 12px;
}

/* RESPONSIVE */

@media (max-width: 768px) {
    .staff-hero {
        padding: 25px 20px;
        border-radius: 14px;
    }

    .staff-hero h1 {
        font-size: 23px;
    }

    .dashboard-section {
        padding: 18px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .staff-hero p {
        font-size: 12px;
    }

    .stat-card {
        padding: 17px;
    }
}
</style>
@endsection
