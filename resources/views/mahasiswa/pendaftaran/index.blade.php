
@extends('layouts.app')

@section('title', 'Pendaftaran')

@section('content')
<style>
    .pendaftaran-page {
        color: #1e293b;
    }

    .pendaftaran-page .page-title {
        margin-bottom: 25px;
    }

    .pendaftaran-page .page-title h1 {
        font-size: 26px;
        font-weight: 700;
        color: #1e3a5f;
        margin-bottom: 6px;
    }

    .pendaftaran-page .page-title p {
        color: #64748b;
        font-size: 14px;
        margin: 0;
    }

    .pendaftaran-page .table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 4px 15px rgba(15, 23, 42, 0.04);
        overflow: hidden;
    }

    .pendaftaran-page .table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 20px;
        gap: 12px;
    }

    .pendaftaran-page .table-header h3 {
        font-size: 17px;
        font-weight: 700;
        color: #1e3a5f;
        margin: 0;
    }

    .pendaftaran-page .table-count {
        background: #eff6ff;
        color: #2563eb;
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
    }

    .pendaftaran-page .table-responsive {
        width: 100%;
        overflow-x: auto;
    }

    .pendaftaran-page .table {
        width: 100%;
        border-collapse: collapse;
        min-width: 650px;
    }

    .pendaftaran-page .table thead th {
        background: #f8fafc;
        color: #64748b;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 15px 14px;
        text-align: left;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .pendaftaran-page .table tbody td {
        padding: 17px 14px;
        border-bottom: 1px solid #f1f5f9;
        font-size: 13px;
        color: #475569;
        vertical-align: middle;
    }

    .pendaftaran-page .table tbody tr:last-child td {
        border-bottom: none;
    }

    .pendaftaran-page .table tbody tr:hover {
        background: #f8fbff;
    }

    .pendaftaran-page .lomba-name {
        color: #1e3a5f;
        font-size: 14px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .pendaftaran-page .lomba-category {
        color: #64748b;
        font-size: 12px;
    }

    .pendaftaran-page .date-text {
        color: #475569;
        font-weight: 500;
        white-space: nowrap;
    }

    .pendaftaran-page .status-badge {
        display: inline-block;
        padding: 6px 11px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .pendaftaran-page .status-accepted {
        background: #dcfce7;
        color: #15803d;
    }

    .pendaftaran-page .status-rejected {
        background: #fee2e2;
        color: #dc2626;
    }

    .pendaftaran-page .status-pending {
        background: #fef3c7;
        color: #b45309;
    }

    .pendaftaran-page .note-text {
        color: #64748b;
        line-height: 1.6;
        max-width: 250px;
    }

    .pendaftaran-page .empty {
        text-align: center;
        padding: 45px 15px !important;
        color: #94a3b8 !important;
    }

    .pendaftaran-page .empty-icon {
        font-size: 30px;
        color: #cbd5e1;
        margin-bottom: 10px;
    }

    .pendaftaran-page .pagination {
        margin-top: 20px;
        margin-bottom: 0;
    }

    @media (max-width: 768px) {
        .pendaftaran-page .page-title h1 {
            font-size: 22px;
        }

        .pendaftaran-page .table-card {
            padding: 15px;
        }

        .pendaftaran-page .table-header {
            align-items: flex-start;
        }
    }
</style>

<div class="container pendaftaran-page">

    <div class="page-title">
        <h1>Pendaftaran Lomba</h1>
        <p>Riwayat pendaftaran dan status seleksi Anda.</p>
    </div>

    <div class="table-card card">

        <div class="table-header">
            <h3>Riwayat Pendaftaran</h3>

            <span class="table-count">
                {{ $pendaftarans->total() }} Pendaftaran
            </span>
        </div>

        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>LOMBA</th>
                        <th>TANGGAL DAFTAR</th>
                        <th>STATUS</th>
                        <th>CATATAN</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendaftarans as $p)
                        <tr>
                            <td>
                                <div class="lomba-name">
                                    {{ $p->lomba->nama }}
                                </div>

                                <div class="lomba-category">
                                    {{ $p->lomba->kategori }}
                                </div>
                            </td>

                            <td>
                                <span class="date-text">
                                    {{ $p->tanggal_daftar->format('d M Y') }}
                                </span>
                            </td>

                            <td>
                                <span class="status-badge
                                    {{ $p->status === 'Diterima'
                                        ? 'status-accepted'
                                        : ($p->status === 'Ditolak'
                                            ? 'status-rejected'
                                            : 'status-pending') }}">
                                    {{ $p->status }}
                                </span>
                            </td>

                            <td>
                                <div class="note-text">
                                    {{ $p->catatan ?: '-' }}
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="empty">
                                <div class="empty-icon">▤</div>
                                <strong>Belum Ada Pendaftaran</strong>
                                <p>Anda belum mendaftar pada lomba apa pun.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{ $pendaftarans->links('layouts.pagination') }}

    </div>
</div>
@endsection
