
@extends('layouts.app')

@section('title', 'Daftar Lomba')

@section('content')
<div class="lomba-page">

    {{-- HEADER HALAMAN --}}
    <div class="lomba-heading">
        <div>
            <span class="lomba-label">INFORMASI KOMPETISI</span>
            <h1>Daftar Lomba</h1>
            <p>Temukan kompetisi akademik dan nonakademik yang sesuai dengan profil Anda.</p>
        </div>
    </div>

    {{-- FILTER DAN PENCARIAN --}}
    <form class="lomba-filter" method="GET" action="{{ route('mahasiswa.lomba.index') }}">

        <div class="lomba-search">
            <span class="search-icon">⌕</span>
            <input
                type="text"
                name="q"
                value="{{ $q }}"
                placeholder="Cari nama lomba atau penyelenggara..."
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
            Filter
        </button>

        @if(request()->filled('q') || request()->filled('kategori') || request()->filled('tingkat'))
            <a class="lomba-reset-btn" href="{{ route('mahasiswa.lomba.index') }}">
                Reset
            </a>
        @endif

    </form>

    {{-- DAFTAR LOMBA --}}
    <div class="lomba-section-header">
        <div>
            <h2>Kompetisi Tersedia</h2>
            <p>Pilih lomba yang sesuai dengan minat dan kemampuan Anda.</p>
        </div>
    </div>

    <div class="lomba-grid">

        @forelse($lombas as $l)
            <div class="lomba-card">

                <div class="lomba-card-top">
                    <span class="lomba-category">
                        {{ $l->kategori }}
                    </span>

                    <span class="lomba-level">
                        {{ $l->tingkat }}
                    </span>
                </div>

                <h3>{{ $l->nama }}</h3>

                <div class="lomba-info">

                    <div class="lomba-info-item">
                        <span class="info-icon">▣</span>
                        <div>
                            <small>Batas Pendaftaran</small>
                            <strong>
                                {{ $l->deadline?->format('d M Y') ?? '-' }}
                            </strong>
                        </div>
                    </div>

                    <div class="lomba-info-item">
                        <span class="info-icon">⌖</span>
                        <div>
                            <small>Lokasi</small>
                            <strong>{{ $l->lokasi ?? 'Online' }}</strong>
                        </div>
                    </div>

                    <div class="lomba-info-item">
                        <span class="info-icon">♟</span>
                        <div>
                            <small>Penyelenggara</small>
                            <strong>{{ $l->penyelenggara }}</strong>
                        </div>
                    </div>

                </div>

                <div class="lomba-card-footer">
                    <a
                        class="lomba-detail-btn"
                        href="{{ route('mahasiswa.lomba.show', $l) }}"
                    >
                        Lihat Detail <span>›</span>
                    </a>
                </div>

            </div>

        @empty
            <div class="lomba-empty">
                <div class="lomba-empty-icon">⌕</div>
                <h3>Data Lomba Tidak Ditemukan</h3>
                <p>Belum ada lomba yang sesuai dengan pencarian atau filter Anda.</p>

                <a href="{{ route('mahasiswa.lomba.index') }}">
                    Lihat Semua Lomba
                </a>
            </div>
        @endforelse

    </div>

    {{-- PAGINATION --}}
    <div class="lomba-pagination">
        {{ $lombas->links('layouts.pagination') }}
    </div>

</div>

<style>
    .lomba-page {
        padding: 10px 5px 30px;
        color: #24364b;
    }

    /* HEADER */

    .lomba-heading {
        margin-bottom: 25px;
    }

    .lomba-label {
        display: inline-block;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .lomba-heading h1 {
        margin: 0 0 8px;
        color: #1e3a5f;
        font-size: 27px;
        font-weight: 750;
    }

    .lomba-heading p {
        margin: 0;
        color: #718096;
        font-size: 14px;
        line-height: 1.6;
    }

    /* FILTER */

    .lomba-filter {
        display: flex;
        align-items: center;
        gap: 12px;
        flex-wrap: wrap;
        padding: 18px;
        margin-bottom: 28px;
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 13px;
        box-shadow: 0 4px 18px rgba(30, 58, 95, .04);
    }

    .lomba-search {
        position: relative;
        flex: 1;
        min-width: 220px;
    }

    .lomba-search input {
        width: 100%;
        height: 40px;
        padding: 0 13px 0 38px;
        border: 1px solid #dbe4ef;
        border-radius: 8px;
        outline: none;
        background: #ffffff;
        color: #334155;
        font-size: 12px;
        box-sizing: border-box;
        transition: .2s;
    }

    .lomba-search input:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
    }

    .search-icon {
        position: absolute;
        top: 7px;
        left: 13px;
        color: #94a3b8;
        font-size: 21px;
    }

    .lomba-select {
        height: 40px;
        min-width: 150px;
        padding: 0 12px;
        border: 1px solid #dbe4ef;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        outline: none;
        cursor: pointer;
    }

    .lomba-select:focus {
        border-color: #2563eb;
        box-shadow: 0 0 0 3px rgba(37, 99, 235, .10);
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
        text-decoration: none !important;
        cursor: pointer;
        transition: .2s;
    }

    .lomba-filter-btn {
        border: none;
        background: #2563eb;
        color: #ffffff;
    }

    .lomba-filter-btn:hover {
        background: #1d4ed8;
    }

    .lomba-reset-btn {
        border: 1px solid #dbe4ef;
        background: #ffffff;
        color: #64748b;
    }

    .lomba-reset-btn:hover {
        background: #f1f5f9;
    }

    /* SECTION HEADER */

    .lomba-section-header {
        margin-bottom: 17px;
    }

    .lomba-section-header h2 {
        margin: 0 0 5px;
        color: #1e3a5f;
        font-size: 17px;
        font-weight: 700;
    }

    .lomba-section-header p {
        margin: 0;
        color: #8492a6;
        font-size: 12px;
    }

    /* CARD GRID */

    .lomba-grid {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 18px;
    }

    .lomba-card {
        display: flex;
        flex-direction: column;
        min-width: 0;
        padding: 20px;
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 13px;
        box-shadow: 0 4px 15px rgba(30, 58, 95, .04);
        transition: .2s;
    }

    .lomba-card:hover {
        border-color: #bfdbfe;
        box-shadow: 0 8px 22px rgba(30, 58, 95, .08);
        transform: translateY(-3px);
    }

    .lomba-card-top {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 8px;
        margin-bottom: 17px;
    }

    .lomba-category {
        padding: 6px 10px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .lomba-level {
        color: #64748b;
        font-size: 10px;
        font-weight: 600;
        text-align: right;
    }

    .lomba-card h3 {
        min-height: 45px;
        margin: 0 0 17px;
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        line-height: 1.5;
        overflow-wrap: anywhere;
    }

    .lomba-info {
        display: flex;
        flex-direction: column;
        gap: 14px;
        margin-bottom: 20px;
    }

    .lomba-info-item {
        display: flex;
        align-items: flex-start;
        gap: 11px;
    }

    .info-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 30px;
        height: 30px;
        background: #f1f6fd;
        color: #2563eb;
        border-radius: 8px;
        font-size: 14px;
    }

    .lomba-info-item div {
        min-width: 0;
    }

    .lomba-info-item small {
        display: block;
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .lomba-info-item strong {
        display: block;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .lomba-card-footer {
        margin-top: auto;
        padding-top: 15px;
        border-top: 1px solid #edf2f7;
    }

    .lomba-detail-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 10px 13px;
        background: #2563eb;
        color: #ffffff !important;
        border-radius: 8px;
        text-decoration: none !important;
        font-size: 12px;
        font-weight: 600;
        transition: .2s;
    }

    .lomba-detail-btn:hover {
        background: #1d4ed8;
    }

    .lomba-detail-btn span {
        font-size: 19px;
        line-height: 1;
    }

    /* EMPTY STATE */

    .lomba-empty {
        grid-column: 1 / -1;
        padding: 55px 20px;
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 13px;
        text-align: center;
    }

    .lomba-empty-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 52px;
        height: 52px;
        margin: 0 auto 14px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 14px;
        font-size: 25px;
    }

    .lomba-empty h3 {
        margin: 0 0 7px;
        color: #1e3a5f;
        font-size: 16px;
    }

    .lomba-empty p {
        margin: 0 0 16px;
        color: #8492a6;
        font-size: 12px;
    }

    .lomba-empty a {
        display: inline-block;
        padding: 9px 15px;
        background: #2563eb;
        color: #ffffff;
        border-radius: 7px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
    }

    /* PAGINATION */

    .lomba-pagination {
        display: flex;
        justify-content: center;
        margin-top: 25px;
    }

    /* RESPONSIVE */

    @media (max-width: 1100px) {
        .lomba-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }
    }

    @media (max-width: 768px) {
        .lomba-heading h1 {
            font-size: 23px;
        }

        .lomba-filter {
            padding: 14px;
        }

        .lomba-search {
            flex-basis: 100%;
        }

        .lomba-select {
            flex: 1;
            min-width: 130px;
        }
    }

    @media (max-width: 520px) {
        .lomba-page {
            padding: 5px 0 20px;
        }

        .lomba-grid {
            grid-template-columns: 1fr;
        }

        .lomba-card h3 {
            min-height: auto;
        }

        .lomba-filter {
            gap: 9px;
        }

        .lomba-select {
            width: 100%;
        }

        .lomba-filter-btn,
        .lomba-reset-btn {
            flex: 1;
        }
    }
</style>
@endsection
