@extends('layouts.app')

@section('title', 'Portfolio Mahasiswa')

@section('content')

<div class="container">

    <div class="page-title">
        <h1>Portfolio Mahasiswa</h1>
        <p>Daftar portfolio mahasiswa yang tersimpan dalam sistem.</p>
    </div>


    <div class="portfolio-card">

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
                                {{ $loop->iteration }}
                            </td>

                            <td>
                                <strong>
                                    {{ $portfolio->mahasiswa->nama_lengkap ?? '-' }}
                                </strong>
                            </td>

                            <td>
                                {{ $portfolio->nama_kegiatan ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->posisi ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->organisasi ?? '-' }}
                            </td>

                            <td>

                                @if($portfolio->periode_mulai || $portfolio->periode_selesai)

                                    {{ $portfolio->periode_mulai
                                        ? \Carbon\Carbon::parse($portfolio->periode_mulai)->format('d/m/Y')
                                        : '-' }}

                                    -

                                    {{ $portfolio->periode_selesai
                                        ? \Carbon\Carbon::parse($portfolio->periode_selesai)->format('d/m/Y')
                                        : '-' }}

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
                            <td colspan="7" class="empty">
                                Belum ada portfolio mahasiswa.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>


<style>

    .portfolio-card {
        background: #ffffff;
        border-radius: 12px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
        overflow: hidden;
        margin-top: 20px;
    }

    .table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .portfolio-table {
        width: 100%;
        border-collapse: collapse;
        min-width: 900px;
    }

    .portfolio-table th {
        background: #f8fafc;
        color: #475569;
        font-size: 12px;
        font-weight: 700;
        text-align: left;
        padding: 15px;
        border-bottom: 1px solid #e5e7eb;
    }

    .portfolio-table td {
        padding: 15px;
        color: #334155;
        font-size: 14px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .portfolio-table tbody tr:hover {
        background: #f8fafc;
    }

    .portfolio-table strong {
        color: #0f172a;
    }

    .btn-detail {
        display: inline-block;
        padding: 8px 13px;
        background: #1e3a5f;
        color: #ffffff;
        text-decoration: none;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-detail:hover {
        background: #16304f;
    }

    .empty {
        text-align: center;
        padding: 40px !important;
        color: #64748b !important;
    }

</style>

@endsection