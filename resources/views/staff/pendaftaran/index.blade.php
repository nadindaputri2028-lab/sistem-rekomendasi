@extends('layouts.app')

@section('title', 'Pendaftaran Lomba')

@section('content')

<div class="container staff-pendaftaran-page">

    {{-- HEADER --}}
    <div class="pendaftaran-header">
        <div>
            <h1>Pendaftaran Lomba</h1>
            <p>Kelola pendaftaran mahasiswa dan status seleksi.</p>
        </div>
    </div>

    {{-- TABEL PENDAFTARAN --}}
    <div class="pendaftaran-card">

        <div class="pendaftaran-card-header">
            <h2>Data Pendaftaran</h2>
            <p>Daftar mahasiswa yang telah mendaftar kompetisi.</p>
        </div>

        <div class="pendaftaran-table-wrapper">
            <table class="pendaftaran-table">
                <thead>
                    <tr>
                        <th>MAHASISWA</th>
                        <th>LOMBA</th>
                        <th>TANGGAL</th>
                        <th>STATUS</th>
                        <th>CATATAN</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($pendaftarans as $p)
                        <tr>

                            {{-- MAHASISWA --}}
                            <td>
                                <div class="pendaftaran-mahasiswa">
                                    <strong>{{ $p->mahasiswa->nama_lengkap }}</strong>
                                    <small>{{ $p->mahasiswa->nim }}</small>
                                </div>
                            </td>

                            {{-- LOMBA --}}
                            <td>{{ $p->lomba->nama }}</td>

                            {{-- TANGGAL --}}
                            <td>
                                {{ $p->tanggal_daftar->format('d M Y') }}
                            </td>

                            {{-- STATUS --}}
                            <td>
                                @php
                                    $statusClass = match($p->status) {
                                        'Diterima' => 'status-diterima',
                                        'Ditolak' => 'status-ditolak',
                                        'Diproses' => 'status-diproses',
                                        default => 'status-menunggu',
                                    };
                                @endphp

                                <span class="pendaftaran-status {{ $statusClass }}">
                                    {{ $p->status }}
                                </span>
                            </td>

                            {{-- CATATAN --}}
                            <td>
                                <span class="pendaftaran-catatan">
                                    {{ $p->catatan ?? '-' }}
                                </span>
                            </td>

                            {{-- AKSI --}}
                            <td>
                                <a href="{{ route('staff.pendaftaran.edit', $p) }}"
                                   class="pendaftaran-edit-btn">
                                    Edit
                                </a>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="pendaftaran-empty">
                                Belum ada pendaftaran.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        <div class="pendaftaran-pagination">
            {{ $pendaftarans->links('layouts.pagination') }}
        </div>

    </div>

</div>

<style>
.staff-pendaftaran-page {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER */
.staff-pendaftaran-page .pendaftaran-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 25px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-pendaftaran-page .pendaftaran-header h1 {
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 8px;
}

.staff-pendaftaran-page .pendaftaran-header p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

/* CARD */
.staff-pendaftaran-page .pendaftaran-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 25px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-pendaftaran-page .pendaftaran-card-header {
    padding-bottom: 18px;
    margin-bottom: 20px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-pendaftaran-page .pendaftaran-card-header h2 {
    color: #1e3a5f;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 6px;
}

.staff-pendaftaran-page .pendaftaran-card-header p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

/* TABLE */
.staff-pendaftaran-page .pendaftaran-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.staff-pendaftaran-page .pendaftaran-table {
    width: 100%;
    min-width: 850px;
    border-collapse: collapse;
}

.staff-pendaftaran-page .pendaftaran-table th {
    background: #f1f5f9;
    color: #475569;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    padding: 15px 14px;
    white-space: nowrap;
    border-bottom: 1px solid #e2e8f0;
}

.staff-pendaftaran-page .pendaftaran-table td {
    padding: 15px 14px;
    font-size: 13px;
    color: #475569;
    border-bottom: 1px solid #edf1f5;
    vertical-align: middle;
}

.staff-pendaftaran-page .pendaftaran-table tbody tr:hover {
    background: #f8fafc;
}

.staff-pendaftaran-page .pendaftaran-mahasiswa {
    display: flex;
    flex-direction: column;
    gap: 5px;
}

.staff-pendaftaran-page .pendaftaran-mahasiswa strong {
    color: #1e293b;
    font-size: 13px;
}

.staff-pendaftaran-page .pendaftaran-mahasiswa small {
    color: #94a3b8;
    font-size: 12px;
}

.staff-pendaftaran-page .pendaftaran-catatan {
    display: block;
    max-width: 220px;
    line-height: 1.5;
    overflow-wrap: anywhere;
}

/* STATUS */
.staff-pendaftaran-page .pendaftaran-status {
    display: inline-block;
    padding: 6px 11px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.staff-pendaftaran-page .status-diterima {
    background: #dcfce7;
    color: #15803d;
}

.staff-pendaftaran-page .status-ditolak {
    background: #fee2e2;
    color: #b91c1c;
}

.staff-pendaftaran-page .status-diproses {
    background: #dbeafe;
    color: #1d4ed8;
}

.staff-pendaftaran-page .status-menunggu {
    background: #fef3c7;
    color: #b45309;
}

/* BUTTON */
.staff-pendaftaran-page .pendaftaran-edit-btn {
    display: inline-block;
    padding: 8px 15px;
    background: #1e3a5f;
    color: #ffffff;
    text-decoration: none;
    border-radius: 7px;
    font-size: 12px;
    font-weight: 600;
    transition: 0.2s;
}

.staff-pendaftaran-page .pendaftaran-edit-btn:hover {
    background: #274b78;
}

/* EMPTY */
.staff-pendaftaran-page .pendaftaran-empty {
    text-align: center;
    padding: 35px 15px;
    color: #94a3b8;
}

/* PAGINATION */
.staff-pendaftaran-page .pendaftaran-pagination {
    margin-top: 22px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .staff-pendaftaran-page {
        padding-top: 20px;
    }

    .staff-pendaftaran-page .pendaftaran-header,
    .staff-pendaftaran-page .pendaftaran-card {
        padding: 20px;
    }

    .staff-pendaftaran-page .pendaftaran-header h1 {
        font-size: 21px;
    }
}

@media (max-width: 480px) {
    .staff-pendaftaran-page .pendaftaran-header,
    .staff-pendaftaran-page .pendaftaran-card {
        padding: 16px;
    }
}
</style>

@endsection