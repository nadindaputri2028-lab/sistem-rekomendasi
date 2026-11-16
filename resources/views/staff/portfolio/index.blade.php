
@extends('layouts.app')

@section('title', 'Portfolio Mahasiswa')

@section('content')

<div class="container staff-portfolio-page">

    {{-- BOX JUDUL --}}
    <div class="portfolio-heading">
        <div>
            <span class="portfolio-heading-label">MANAJEMEN DATA</span>
            <h1>Portfolio Mahasiswa</h1>
            <p>Daftar portfolio mahasiswa yang tersimpan dalam sistem.</p>
        </div>
    </div>

    {{-- BOX TABEL --}}
    <div class="portfolio-card">

        <div class="portfolio-header">
            <div>
                <h3>Data Portfolio Mahasiswa</h3>
                <p>Informasi kegiatan, pengalaman, dan pencapaian mahasiswa.</p>
            </div>

            <span class="portfolio-total">
                {{ $portfolios->count() }} Portfolio
            </span>
        </div>

        <div class="table-wrapper">

            <table class="portfolio-table">

                <thead>
                    <tr>
                        <th>NO</th>
                        <th>MAHASISWA</th>
                        <th>KEGIATAN</th>
                        <th>POSISI</th>
                        <th>ORGANISASI</th>
                        <th>PERIODE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($portfolios as $portfolio)

                        <tr>

                            <td>
                                <span class="portfolio-number">
                                    {{ $loop->iteration }}
                                </span>
                            </td>

                            <td>
                                <div class="portfolio-student">
                                    <div class="portfolio-avatar">
                                        {{ strtoupper(substr($portfolio->mahasiswa->nama_lengkap ?? 'M', 0, 1)) }}
                                    </div>

                                    <strong>
                                        {{ $portfolio->mahasiswa->nama_lengkap ?? '-' }}
                                    </strong>
                                </div>
                            </td>

                            <td>
                                <span class="portfolio-activity">
                                    {{ $portfolio->nama_kegiatan ?? '-' }}
                                </span>
                            </td>

                            <td>
                                {{ $portfolio->posisi ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->organisasi ?? '-' }}
                            </td>

                            <td>
                                @if($portfolio->periode_mulai || $portfolio->periode_selesai)

                                    <span class="portfolio-period">
                                        {{ $portfolio->periode_mulai
                                            ? \Carbon\Carbon::parse($portfolio->periode_mulai)->format('d/m/Y')
                                            : '-' }}

                                        -

                                        {{ $portfolio->periode_selesai
                                            ? \Carbon\Carbon::parse($portfolio->periode_selesai)->format('d/m/Y')
                                            : '-' }}
                                    </span>

                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('staff.portfolio.show', $portfolio->id) }}"
                                   class="btn-detail">
                                    Lihat Detail
                                </a>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7">
                                <div class="portfolio-empty">
                                    <div class="empty-icon">!</div>
                                    <strong>Belum Ada Portfolio</strong>
                                    <p>Portfolio mahasiswa yang tersimpan akan ditampilkan di sini.</p>
                                </div>
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

<style>

    /* HALAMAN UTAMA */
    .staff-portfolio-page {
        padding-top: 32px;
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* BOX JUDUL */
    .portfolio-heading {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 26px 30px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }

    .portfolio-heading-label {
        display: inline-block;
        color: #2563eb;
        background: #eff6ff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 6px 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .portfolio-heading h1 {
        font-size: 25px;
        font-weight: 750;
        color: #1e3a5f;
        margin: 0 0 7px;
    }

    .portfolio-heading p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    /* BOX TABEL */
    .portfolio-card {
        background: #ffffff;
        border-radius: 13px;
        border: 1px solid #e2e8f0;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
        overflow: hidden;
    }

    .portfolio-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid #edf1f5;
    }

    .portfolio-header h3 {
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .portfolio-header p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    .portfolio-total {
        background: #eff6ff;
        color: #2563eb;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    /* TABEL */
    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .portfolio-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 950px;
        text-align: left;
    }

    .portfolio-table thead {
        background: #f8fafc;
    }

    .portfolio-table th {
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 15px 17px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .portfolio-table td {
        padding: 15px 17px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .portfolio-table tbody tr {
        transition: background 0.2s;
    }

    .portfolio-table tbody tr:hover {
        background: #f8fbff;
    }

    .portfolio-table tbody tr:last-child td {
        border-bottom: none;
    }

    .portfolio-number {
        color: #64748b;
        font-weight: 600;
    }

    /* IDENTITAS MAHASISWA */
    .portfolio-student {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 170px;
    }

    .portfolio-avatar {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        background: #eaf2ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .portfolio-student strong {
        color: #334155;
        font-size: 12px;
        font-weight: 650;
    }

    .portfolio-activity {
        color: #334155;
        font-weight: 600;
    }

    .portfolio-period {
        white-space: nowrap;
        color: #64748b;
    }

    /* TOMBOL DETAIL */
    .btn-detail {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 8px 13px;
        background: #eff6ff;
        color: #2563eb !important;
        border: 1px solid #dbeafe;
        text-decoration: none !important;
        border-radius: 7px;
        font-size: 11px;
        font-weight: 650;
        white-space: nowrap;
        transition: 0.2s;
    }

    .btn-detail:hover {
        background: #dbeafe;
    }

    /* DATA KOSONG */
    .portfolio-empty {
        padding: 45px 15px;
        text-align: center;
    }

    .portfolio-empty .empty-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 17px;
        font-weight: 700;
    }

    .portfolio-empty strong {
        color: #334155;
        font-size: 13px;
    }

    .portfolio-empty p {
        color: #94a3b8;
        font-size: 12px;
        margin: 6px 0 0;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .staff-portfolio-page {
            padding-top: 24px;
        }
    }

    @media (max-width: 600px) {
        .staff-portfolio-page {
            padding-top: 18px;
        }

        .portfolio-heading {
            padding: 21px;
        }

        .portfolio-heading h1 {
            font-size: 21px;
        }

        .portfolio-header {
            padding: 17px;
            align-items: flex-start;
        }
    }

</style>

@endsection
