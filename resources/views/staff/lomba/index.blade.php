
@extends('layouts.app')

@section('title', 'Data Lomba')

@section('content')

<div class="container staff-lomba-page">

    {{-- BOX JUDUL --}}
    <div class="lomba-heading">
        <div>
            <span class="lomba-heading-label">MANAJEMEN DATA</span>
            <h1>Data Lomba</h1>
            <p>Tambah dan kelola kompetisi yang tersedia untuk mahasiswa.</p>
        </div>

        <a class="lomba-add-btn" href="{{ route('staff.lomba.create') }}">
            <span>+</span> Tambah Lomba
        </a>
    </div>

    {{-- BOX FILTER --}}
    <div class="lomba-filter-card">

        <div class="lomba-filter-heading">
            <h3>Daftar Lomba</h3>
            <p>Cari dan saring kompetisi berdasarkan kategori dan tingkat.</p>
        </div>

        <form class="lomba-toolbar" method="GET" action="{{ route('staff.lomba.index') }}">

            <div class="lomba-search">
                <span class="search-icon">⌕</span>
                <input
                    type="text"
                    name="q"
                    value="{{ request('q') }}"
                    placeholder="Cari nama lomba..."
                >
            </div>

            <select name="kategori" class="lomba-select">
                <option value="">Semua Kategori</option>
                <option value="Akademik" @selected(request('kategori') === 'Akademik')>
                    Akademik
                </option>
                <option value="Non-Akademik" @selected(request('kategori') === 'Non-Akademik')>
                    Non-Akademik
                </option>
            </select>

            <select name="tingkat" class="lomba-select">
                <option value="">Semua Tingkat</option>
                <option value="Kampus" @selected(request('tingkat') === 'Kampus')>
                    Internal / Kampus
                </option>
                <option value="Regional" @selected(request('tingkat') === 'Regional')>
                    Regional / Wilayah
                </option>
                <option value="Nasional" @selected(request('tingkat') === 'Nasional')>
                    Nasional
                </option>
                <option value="Internasional" @selected(request('tingkat') === 'Internasional')>
                    Internasional
                </option>
            </select>

            <button type="submit" class="lomba-filter-btn">
                Terapkan
            </button>

            @if(request()->filled('q') || request()->filled('kategori') || request()->filled('tingkat'))
                <a class="lomba-reset-btn" href="{{ route('staff.lomba.index') }}">
                    Reset
                </a>
            @endif

        </form>
    </div>

    {{-- BOX TABEL --}}
    <div class="lomba-table-card">

        <div class="lomba-table-header">
            <div>
                <h3>Data Kompetisi</h3>
                <p>Informasi kompetisi yang tersedia dalam sistem.</p>
            </div>
        </div>

        <div class="lomba-table-wrapper">

            <table class="lomba-table">

                <thead>
                    <tr>
                        <th>NAMA LOMBA</th>
                        <th>KATEGORI</th>
                        <th>PENYELENGGARA</th>
                        <th>TANGGAL BERAKHIR</th>
                        <th>STATUS</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($lombas as $l)

                        <tr>

                            <td>
                                <div class="lomba-name">
                                    <div class="lomba-icon">L</div>
                                    <b>{{ $l->nama }}</b>
                                </div>
                            </td>

                            <td>
                                <span class="lomba-category">
                                    {{ $l->kategori }}
                                </span>
                            </td>

                            <td>
                                {{ $l->penyelenggara ?? '-' }}
                            </td>

                            <td>
                                <span class="lomba-deadline">
                                    {{ $l->deadline?->format('d M Y') ?? '-' }}
                                </span>
                            </td>

                            <td>
                                <span class="lomba-status {{ $l->status_class }}">
                                    {{ $l->status_label }}
                                </span>
                            </td>

                            <td>
                                <div class="lomba-actions">

                                    <a class="action-btn kriteria-btn"
                                       href="{{ route('staff.kriteria.index', ['lomba_id' => $l->id]) }}">
                                        Kriteria
                                    </a>

                                    <a class="action-btn edit-btn"
                                       href="{{ route('staff.lomba.edit', $l) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('staff.lomba.destroy', $l) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="action-btn delete-btn"
                                            data-confirm="Hapus lomba ini?"
                                        >
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6">
                                <div class="lomba-empty">
                                    <div class="empty-icon">!</div>
                                    <strong>Belum Ada Data Lomba</strong>
                                    <p>Data kompetisi yang ditambahkan akan ditampilkan di sini.</p>
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
    .staff-lomba-page {
        padding-top: 32px;
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* BOX JUDUL */
    .lomba-heading {
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

    .lomba-heading-label {
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

    .lomba-heading h1 {
        font-size: 25px;
        font-weight: 750;
        color: #1e3a5f;
        margin: 0 0 7px;
    }

    .lomba-heading p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    .lomba-add-btn {
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

    .lomba-add-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .lomba-add-btn span {
        font-size: 19px;
        line-height: 1;
    }

    /* FILTER */
    .lomba-filter-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .lomba-filter-heading h3 {
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .lomba-filter-heading p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    .lomba-toolbar {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 10px;
        margin-top: 19px;
    }

    .lomba-search {
        flex: 1 1 220px;
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

    .lomba-search:focus-within {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .lomba-search .search-icon {
        color: #94a3b8;
        font-size: 21px;
    }

    .lomba-search input {
        width: 100%;
        border: none;
        outline: none;
        background: transparent;
        color: #334155;
        font-size: 12px;
    }

    .lomba-search input::placeholder {
        color: #94a3b8;
    }

    .lomba-select {
        height: 40px;
        min-width: 150px;
        padding: 0 11px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        outline: none;
        cursor: pointer;
    }

    .lomba-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .lomba-filter-btn,
    .lomba-reset-btn {
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

    .lomba-filter-btn {
        background: #2563eb;
        color: #ffffff;
        border: 1px solid #2563eb;
    }

    .lomba-filter-btn:hover {
        background: #1d4ed8;
    }

    .lomba-reset-btn {
        background: #ffffff;
        color: #64748b !important;
        border: 1px solid #cbd5e1;
    }

    .lomba-reset-btn:hover {
        background: #f8fafc;
    }

    /* BOX TABEL */
    .lomba-table-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        overflow: hidden;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .lomba-table-header {
        padding: 21px 23px;
        border-bottom: 1px solid #edf1f5;
    }

    .lomba-table-header h3 {
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .lomba-table-header p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    /* TABEL */
    .lomba-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .lomba-table {
        width: 100%;
        min-width: 950px;
        border-collapse: collapse;
        text-align: left;
    }

    .lomba-table thead {
        background: #f8fafc;
    }

    .lomba-table th {
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        padding: 15px 17px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .lomba-table td {
        padding: 15px 17px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .lomba-table tbody tr {
        transition: background 0.2s;
    }

    .lomba-table tbody tr:hover {
        background: #f8fbff;
    }

    .lomba-table tbody tr:last-child td {
        border-bottom: none;
    }

    /* NAMA LOMBA */
    .lomba-name {
        display: flex;
        align-items: center;
        gap: 10px;
        min-width: 180px;
    }

    .lomba-name b {
        color: #334155;
        font-size: 12px;
        font-weight: 650;
    }

    .lomba-icon {
        width: 34px;
        height: 34px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 9px;
        background: #eaf2ff;
        color: #2563eb;
        font-size: 13px;
        font-weight: 700;
    }

    .lomba-category {
        display: inline-block;
        background: #eff6ff;
        color: #2563eb;
        padding: 5px 9px;
        border-radius: 5px;
        font-size: 11px;
        font-weight: 600;
        white-space: nowrap;
    }

    .lomba-deadline {
        color: #475569;
        white-space: nowrap;
    }

    /* STATUS */
    .lomba-status {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 650;
        white-space: nowrap;
        background: #eff6ff;
        color: #2563eb;
    }

    .lomba-status.green,
    .lomba-status.active {
        background: #ecfdf5;
        color: #047857;
    }

    .lomba-status.red,
    .lomba-status.expired {
        background: #fef2f2;
        color: #dc2626;
    }

    .lomba-status.yellow,
    .lomba-status.warning {
        background: #fffbeb;
        color: #b45309;
    }

    /* AKSI */
    .lomba-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        min-width: 190px;
    }

    .lomba-actions form {
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

    .kriteria-btn {
        color: #2563eb !important;
        background: #eff6ff;
        border-color: #dbeafe;
    }

    .kriteria-btn:hover {
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

    .delete-btn {
        color: #dc2626;
        background: #fef2f2;
        border-color: #fecaca;
    }

    .delete-btn:hover {
        background: #fee2e2;
    }

    /* DATA KOSONG */
    .lomba-empty {
        padding: 45px 15px;
        text-align: center;
    }

    .lomba-empty .empty-icon {
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

    .lomba-empty strong {
        color: #334155;
        font-size: 13px;
    }

    .lomba-empty p {
        color: #94a3b8;
        font-size: 12px;
        margin: 6px 0 0;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .staff-lomba-page {
            padding-top: 24px;
        }

        .lomba-search {
            flex-basis: 100%;
        }
    }

    @media (max-width: 600px) {
        .staff-lomba-page {
            padding-top: 18px;
        }

        .lomba-heading {
            align-items: flex-start;
            flex-direction: column;
            padding: 21px;
        }

        .lomba-heading h1 {
            font-size: 21px;
        }

        .lomba-add-btn {
            width: 100%;
        }

        .lomba-filter-card {
            padding: 17px;
        }

        .lomba-toolbar {
            flex-direction: column;
        }

        .lomba-search,
        .lomba-select,
        .lomba-filter-btn,
        .lomba-reset-btn {
            width: 100%;
            flex: auto;
        }

        .lomba-table-header {
            padding: 17px;
        }
    }

</style>

@endsection
