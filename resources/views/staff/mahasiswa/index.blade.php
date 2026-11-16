
@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container staff-mahasiswa-page">

    {{-- BOX JUDUL HALAMAN --}}
    <div class="mahasiswa-heading">
        <div>
            <span class="mahasiswa-heading-label">MANAJEMEN DATA</span>
            <h1>Data Mahasiswa</h1>
            <p>Kelola data mahasiswa yang menjadi sumber sistem rekomendasi.</p>
        </div>

        <a class="mahasiswa-add-btn" href="{{ route('staff.mahasiswa.create') }}">
            <span>+</span> Tambah Mahasiswa
        </a>
    </div>

    {{-- FILTER DAN PENCARIAN --}}
    <div class="mahasiswa-filter-card">
        <div class="filter-heading">
            <div>
                <h3>Daftar Mahasiswa</h3>
                <p>Cari dan saring data mahasiswa berdasarkan kriteria.</p>
            </div>
        </div>

        <form class="mahasiswa-toolbar" method="GET" action="{{ route('staff.mahasiswa.index') }}">

            <div class="mahasiswa-search">
                <span class="search-icon">⌕</span>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama atau NIM..."
                >
            </div>

            <select name="status" class="mahasiswa-select">
                <option value="">Semua Status</option>
                <option value="aktif" @selected(request('status') === 'aktif')>
                    Aktif
                </option>
                <option value="nonaktif" @selected(request('status') === 'nonaktif')>
                    Non-Aktif
                </option>
            </select>

            <select name="prodi" class="mahasiswa-select">
                <option value="Teknologi Informasi"
                    @selected(request('prodi', 'Teknologi Informasi') === 'Teknologi Informasi')>
                    Teknologi Informasi
                </option>
            </select>

            <select name="semester" class="mahasiswa-select">
                <option value="">Semua Semester</option>
                @foreach(range(1, 8) as $semester)
                    <option value="{{ $semester }}" @selected(request('semester') == $semester)>
                        Semester {{ $semester }}
                    </option>
                @endforeach
            </select>

            <button type="submit" class="mahasiswa-filter-btn">
                Terapkan
            </button>

            @if(request()->filled('q') || request()->filled('status') || request()->filled('prodi') || request()->filled('semester'))
                <a class="mahasiswa-reset-btn" href="{{ route('staff.mahasiswa.index') }}">
                    Reset
                </a>
            @endif
        </form>
    </div>

    {{-- TABEL DATA MAHASISWA --}}
    <div class="mahasiswa-table-card">

        <div class="mahasiswa-table-header">
            <div>
                <h3>Data Mahasiswa Terdaftar</h3>
                <p>Informasi mahasiswa dalam sistem rekomendasi.</p>
            </div>

            <span class="mahasiswa-total">
                {{ $mahasiswas->total() }} Mahasiswa
            </span>
        </div>

        <div class="mahasiswa-table-wrapper">
            <table class="mahasiswa-table">
                <thead>
                    <tr>
                        <th>MAHASISWA</th>
                        <th>NIM</th>
                        <th>PRODI</th>
                        <th>SEMESTER</th>
                        <th>IPK</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mahasiswas as $m)
                        <tr>
                            <td>
                                <div class="mahasiswa-name">
                                    <div class="mahasiswa-avatar">
                                        {{ strtoupper(substr($m->nama_lengkap, 0, 1)) }}
                                    </div>
                                    <b>{{ $m->nama_lengkap }}</b>
                                </div>
                            </td>

                            <td>{{ $m->nim }}</td>
                            <td>{{ $m->prodi }}</td>
                            <td>
                                <span class="semester-label">
                                    Semester {{ $m->semester }}
                                </span>
                            </td>
                            <td>
                                <b class="ipk-value">
                                    {{ number_format($m->ipk ?? 0, 2) }}
                                </b>
                            </td>

                            <td>
                                @if($m->is_active)
                                    <span class="mahasiswa-status active">
                                        <span></span> Aktif
                                    </span>
                                @else
                                    <span class="mahasiswa-status inactive">
                                        <span></span> Non-Aktif
                                    </span>
                                @endif
                            </td>

                            <td>
                                <div class="mahasiswa-actions">

                                    <a class="action-btn detail-btn"
                                       href="{{ route('staff.mahasiswa.show', $m) }}">
                                        Detail
                                    </a>

                                    <a class="action-btn edit-btn"
                                       href="{{ route('staff.mahasiswa.edit', $m) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('staff.mahasiswa.toggle', $m) }}">
                                        @csrf
                                        @method('PATCH')

                                        <button
                                            type="submit"
                                            class="action-btn {{ $m->is_active ? 'deactivate-btn' : 'activate-btn' }}"
                                            data-confirm="{{ $m->is_active ? 'Non-aktifkan' : 'Aktifkan' }} mahasiswa ini?"
                                        >
                                            {{ $m->is_active ? 'Non-Aktifkan' : 'Aktifkan' }}
                                        </button>
                                    </form>

                                    <form method="POST"
                                          action="{{ route('staff.mahasiswa.destroy', $m) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                            data-confirm="Hapus mahasiswa ini?"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7">
                                <div class="mahasiswa-empty">
                                    <div class="empty-icon">!</div>
                                    <b>Belum Ada Data Mahasiswa</b>
                                    <p>Data mahasiswa yang tersedia akan ditampilkan di sini.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mahasiswa-pagination">
            {{ $mahasiswas->links('layouts.pagination') }}
        </div>
    </div>

</div>

<style>
    /* HALAMAN UTAMA */
    .staff-mahasiswa-page {
        padding-top: 32px;
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* BOX JUDUL */
    .staff-mahasiswa-page .mahasiswa-heading {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 26px 30px;
        margin-bottom: 24px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 20px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }

    .mahasiswa-heading-label {
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

    .staff-mahasiswa-page .mahasiswa-heading h1 {
        font-size: 25px;
        font-weight: 750;
        color: #1e3a5f;
        margin: 0 0 7px;
    }

    .staff-mahasiswa-page .mahasiswa-heading p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .mahasiswa-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        background: #2563eb;
        color: #ffffff !important;
        padding: 11px 17px;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        text-decoration: none !important;
        white-space: nowrap;
        transition: 0.2s;
    }

    .mahasiswa-add-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .mahasiswa-add-btn span {
        font-size: 19px;
        line-height: 1;
    }

    /* FILTER CARD */
    .mahasiswa-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .filter-heading h3,
    .mahasiswa-table-header h3 {
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .filter-heading p,
    .mahasiswa-table-header p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    .mahasiswa-toolbar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 19px;
    }

    .mahasiswa-search {
        flex: 1 1 210px;
        min-width: 180px;
        height: 40px;
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 0 12px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #ffffff;
    }

    .mahasiswa-search:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .mahasiswa-search .search-icon {
        color: #94a3b8;
        font-size: 21px;
    }

    .mahasiswa-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: #334155;
        font-size: 12px;
    }

    .mahasiswa-search input::placeholder {
        color: #94a3b8;
    }

    .mahasiswa-select {
        height: 40px;
        min-width: 135px;
        padding: 0 11px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        outline: none;
        cursor: pointer;
    }

    .mahasiswa-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .mahasiswa-filter-btn,
    .mahasiswa-reset-btn {
        height: 40px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0 17px;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        cursor: pointer;
        text-decoration: none !important;
        transition: 0.2s;
    }

    .mahasiswa-filter-btn {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .mahasiswa-filter-btn:hover {
        background: #1d4ed8;
    }

    .mahasiswa-reset-btn {
        background: #ffffff;
        color: #64748b !important;
        border: 1px solid #cbd5e1;
    }

    .mahasiswa-reset-btn:hover {
        background: #f8fafc;
    }

    /* TABEL */
    .mahasiswa-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .mahasiswa-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid #edf1f5;
    }

    .mahasiswa-total {
        background: #eff6ff;
        color: #2563eb;
        padding: 7px 12px;
        border-radius: 20px;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .mahasiswa-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .mahasiswa-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        text-align: left;
    }

    .mahasiswa-table thead {
        background: #f8fafc;
    }

    .mahasiswa-table th {
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 15px 17px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .mahasiswa-table td {
        color: #475569;
        font-size: 12px;
        padding: 15px 17px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .mahasiswa-table tbody tr {
        transition: background 0.2s;
    }

    .mahasiswa-table tbody tr:hover {
        background: #f8fbff;
    }

    .mahasiswa-table tbody tr:last-child td {
        border-bottom: none;
    }

    .mahasiswa-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 170px;
    }

    .mahasiswa-name b {
        color: #334155;
        font-size: 12px;
        font-weight: 650;
    }

    .mahasiswa-avatar {
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

    .semester-label {
        display: inline-block;
        background: #f1f5f9;
        color: #475569;
        padding: 5px 9px;
        border-radius: 5px;
        font-size: 11px;
    }

    .ipk-value {
        color: #1e3a5f;
        font-size: 13px;
    }

    /* STATUS */
    .mahasiswa-status {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 650;
        white-space: nowrap;
    }

    .mahasiswa-status span {
        width: 6px;
        height: 6px;
        border-radius: 50%;
    }

    .mahasiswa-status.active {
        background: #ecfdf5;
        color: #047857;
    }

    .mahasiswa-status.active span {
        background: #10b981;
    }

    .mahasiswa-status.inactive {
        background: #fef2f2;
        color: #dc2626;
    }

    .mahasiswa-status.inactive span {
        background: #ef4444;
    }

    /* TOMBOL AKSI */
    .mahasiswa-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        min-width: 245px;
    }

    .mahasiswa-actions form {
        margin: 0;
    }

    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 29px;
        padding: 5px 9px;
        border: 1px solid transparent;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 600;
        text-decoration: none !important;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.2s;
    }

    .detail-btn {
        color: #2563eb !important;
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .detail-btn:hover {
        background: #dbeafe;
    }

    .edit-btn {
        color: #475569 !important;
        background: #f1f5f9;
        border-color: #e2e8f0;
    }

    .edit-btn:hover {
        background: #e2e8f0;
    }

    .activate-btn {
        color: #047857;
        background: #ecfdf5;
        border-color: #a7f3d0;
    }

    .activate-btn:hover {
        background: #d1fae5;
    }

    .deactivate-btn {
        color: #b45309;
        background: #fffbeb;
        border-color: #fde68a;
    }

    .deactivate-btn:hover {
        background: #fef3c7;
    }

    .delete-btn {
        color: #dc2626;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .delete-btn:hover {
        background: #fee2e2;
    }

    /* DATA KOSONG */
    .mahasiswa-empty {
        padding: 45px 15px;
        text-align: center;
    }

    .empty-icon {
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

    .mahasiswa-empty b {
        color: #334155;
        font-size: 13px;
    }

    .mahasiswa-empty p {
        color: #94a3b8;
        font-size: 12px;
        margin: 6px 0 0;
    }

    /* PAGINATION */
    .mahasiswa-pagination {
        padding: 16px 22px;
        border-top: 1px solid #edf1f5;
        overflow-x: auto;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .staff-mahasiswa-page {
            padding-top: 24px;
        }

        .mahasiswa-toolbar {
            align-items: stretch;
        }

        .mahasiswa-search {
            flex-basis: 100%;
        }

        .mahasiswa-select {
            flex: 1 1 140px;
        }
    }

    @media (max-width: 600px) {
        .staff-mahasiswa-page {
            padding-top: 18px;
        }

        .staff-mahasiswa-page .mahasiswa-heading {
            align-items: flex-start;
            flex-direction: column;
            padding: 21px;
        }

        .staff-mahasiswa-page .mahasiswa-heading h1 {
            font-size: 21px;
        }

        .mahasiswa-add-btn {
            width: 100%;
        }

        .mahasiswa-filter-card {
            padding: 17px;
        }

        .mahasiswa-toolbar {
            flex-direction: column;
        }

        .mahasiswa-search,
        .mahasiswa-select,
        .mahasiswa-filter-btn,
        .mahasiswa-reset-btn {
            width: 100%;
            flex: auto;
        }

        .mahasiswa-table-header {
            padding: 17px;
            align-items: flex-start;
        }

        .mahasiswa-pagination {
            padding: 14px;
        }
    }
</style>
@endsection
