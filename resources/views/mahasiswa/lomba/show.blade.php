
@extends('layouts.app')

@section('title', 'Detail Lomba')

@section('content')
<div class="detail-lomba-page">

    {{-- HEADER --}}
    <div class="detail-heading">
        <div>
            <span class="detail-label">INFORMASI KOMPETISI</span>
            <h1>Detail Lomba</h1>
            <p>Informasi lengkap mengenai kompetisi yang dapat Anda ikuti.</p>
        </div>

        <a href="{{ route('mahasiswa.lomba.index') }}" class="back-btn">
            ‹ Kembali ke Daftar Lomba
        </a>
    </div>

    <div class="detail-grid">

        {{-- INFORMASI UTAMA --}}
        <div class="detail-main-card">

            <div class="detail-top">
                <span class="detail-category">
                    {{ $lomba->kategori }}
                </span>

                <span class="detail-level">
                    {{ $lomba->tingkat }}
                </span>
            </div>

            <h2 class="detail-title">{{ $lomba->nama }}</h2>

            <div class="detail-meta-grid">

                <div class="detail-meta-item">
                    <span class="detail-meta-icon">♟</span>
                    <div>
                        <small>Penyelenggara</small>
                        <strong>{{ $lomba->penyelenggara }}</strong>
                    </div>
                </div>

                <div class="detail-meta-item">
                    <span class="detail-meta-icon">▣</span>
                    <div>
                        <small>Batas Pendaftaran</small>
                        <strong>{{ $lomba->deadline?->format('d M Y') ?? '-' }}</strong>
                    </div>
                </div>

                <div class="detail-meta-item">
                    <span class="detail-meta-icon">⌖</span>
                    <div>
                        <small>Lokasi</small>
                        <strong>{{ $lomba->lokasi ?? 'Online' }}</strong>
                    </div>
                </div>

            </div>

            <div class="detail-divider"></div>

            {{-- DESKRIPSI --}}
            <section class="detail-section">
                <div class="detail-section-title">
                    <span class="section-indicator"></span>
                    <h3>Deskripsi Lomba</h3>
                </div>

                <p>{{ $lomba->deskripsi ?: 'Deskripsi lomba belum dicantumkan.' }}</p>
            </section>

            {{-- PERSYARATAN --}}
            <section class="detail-section">
                <div class="detail-section-title">
                    <span class="section-indicator"></span>
                    <h3>Persyaratan Pendaftaran</h3>
                </div>

                <p>{{ $lomba->persyaratan ?: 'Persyaratan belum dicantumkan.' }}</p>
            </section>

            {{-- BENEFIT --}}
            <section class="detail-section">
                <div class="detail-section-title">
                    <span class="section-indicator"></span>
                    <h3>Benefit</h3>
                </div>

                <p>{{ $lomba->benefit ?: 'Informasi benefit belum dicantumkan.' }}</p>
            </section>

        </div>

        {{-- SIDEBAR PENDAFTARAN --}}
        <div class="detail-sidebar">

            <div class="registration-card">

                <div class="registration-heading">
                    <span class="registration-icon">▣</span>
                    <div>
                        <h3>Status Pendaftaran</h3>
                        <p>Informasi pendaftaran kompetisi</p>
                    </div>
                </div>

                <div class="registration-status">
                    <span class="status-dot"></span>
                    <span class="{{ $lomba->status_class }}">
                        {{ $lomba->status_label }}
                    </span>
                </div>

                <div class="registration-info">

                    <div class="registration-info-item">
                        <small>Batas Pendaftaran</small>
                        <strong>
                            {{ $lomba->deadline?->format('d M Y') ?? '-' }}
                        </strong>
                    </div>

                    <div class="registration-info-item">
                        <small>Peserta Terdaftar</small>
                        <strong>{{ $lomba->pendaftarans()->count() }} Mahasiswa</strong>
                    </div>

                </div>

                <div class="registration-divider"></div>

                {{-- GOOGLE CALENDAR --}}
                @if($lomba->deadline)
                    <a
                        class="detail-secondary-btn"
                        href="{{ $lomba->google_calendar_url }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <span>▦</span>
                        Tambah ke Google Calendar
                    </a>
                @endif

                {{-- PANDUAN --}}
                @if($lomba->panduan)
                    <a
                        class="detail-secondary-btn"
                        href="{{ $lomba->panduan }}"
                        target="_blank"
                        rel="noopener noreferrer"
                    >
                        <span>↓</span>
                        Unduh Panduan
                    </a>
                @endif

                {{-- DAFTAR --}}
                <form
                    method="POST"
                    action="{{ route('mahasiswa.pendaftaran.store', $lomba) }}"
                    class="registration-form"
                >
                    @csrf

                    <button
                        type="submit"
                        class="detail-register-btn"
                        @disabled($lomba->is_expired)
                    >
                        {{ $lomba->is_expired ? 'Pendaftaran Ditutup' : 'Daftar Lomba' }}
                        <span>›</span>
                    </button>
                </form>

                <p class="registration-note">
                    Pastikan Anda membaca seluruh informasi dan persyaratan sebelum mendaftar.
                </p>

            </div>

        </div>

    </div>
</div>

<style>
    .detail-lomba-page {
        padding: 10px 5px 30px;
        color: #24364b;
    }

    /* HEADER */

    .detail-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        margin-bottom: 25px;
    }

    .detail-label {
        display: inline-block;
        margin-bottom: 8px;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
    }

    .detail-heading h1 {
        margin: 0 0 8px;
        color: #1e3a5f;
        font-size: 27px;
        font-weight: 750;
    }

    .detail-heading p {
        margin: 0;
        color: #718096;
        font-size: 13px;
    }

    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 5px;
        padding: 10px 14px;
        background: #ffffff;
        color: #2563eb !important;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        font-size: 12px;
        font-weight: 600;
        text-decoration: none !important;
        white-space: nowrap;
        transition: .2s;
    }

    .back-btn:hover {
        background: #eff6ff;
    }

    /* GRID */

    .detail-grid {
        display: grid;
        grid-template-columns: minmax(0, 1fr) 310px;
        align-items: start;
        gap: 20px;
    }

    .detail-main-card,
    .registration-card {
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(30, 58, 95, .05);
    }

    .detail-main-card {
        padding: 25px;
        min-width: 0;
    }

    /* INFORMASI UTAMA */

    .detail-top {
        display: flex;
        align-items: center;
        gap: 9px;
        margin-bottom: 15px;
    }

    .detail-category {
        padding: 6px 11px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 700;
    }

    .detail-level {
        padding: 6px 11px;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 600;
    }

    .detail-title {
        margin: 0 0 22px;
        color: #1e3a5f;
        font-size: 24px;
        font-weight: 750;
        line-height: 1.4;
        overflow-wrap: anywhere;
    }

    .detail-meta-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 17px;
    }

    .detail-meta-item {
        display: flex;
        align-items: center;
        gap: 11px;
        min-width: 0;
    }

    .detail-meta-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 9px;
        font-size: 16px;
    }

    .detail-meta-item div {
        min-width: 0;
    }

    .detail-meta-item small {
        display: block;
        margin-bottom: 4px;
        color: #94a3b8;
        font-size: 10px;
    }

    .detail-meta-item strong {
        display: block;
        color: #475569;
        font-size: 12px;
        font-weight: 600;
        overflow-wrap: anywhere;
    }

    .detail-divider {
        height: 1px;
        margin: 25px 0;
        background: #edf2f7;
    }

    /* DETAIL SECTION */

    .detail-section {
        margin-bottom: 25px;
    }

    .detail-section:last-child {
        margin-bottom: 0;
    }

    .detail-section-title {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .section-indicator {
        width: 4px;
        height: 19px;
        background: #2563eb;
        border-radius: 5px;
    }

    .detail-section-title h3 {
        margin: 0;
        color: #1e3a5f;
        font-size: 15px;
        font-weight: 700;
    }

    .detail-section p {
        margin: 0;
        color: #64748b;
        font-size: 13px;
        line-height: 1.8;
        white-space: pre-line;
        overflow-wrap: anywhere;
    }

    /* SIDEBAR */

    .detail-sidebar {
        position: sticky;
        top: 20px;
    }

    .registration-card {
        padding: 21px;
    }

    .registration-heading {
        display: flex;
        align-items: center;
        gap: 11px;
        margin-bottom: 20px;
    }

    .registration-icon {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 38px;
        height: 38px;
        flex-shrink: 0;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 10px;
        font-size: 17px;
    }

    .registration-heading h3 {
        margin: 0 0 5px;
        color: #1e3a5f;
        font-size: 15px;
        font-weight: 700;
    }

    .registration-heading p {
        margin: 0;
        color: #94a3b8;
        font-size: 10px;
    }

    .registration-status {
        display: flex;
        align-items: center;
        gap: 9px;
        padding: 12px;
        background: #f8faff;
        border: 1px solid #edf2f7;
        border-radius: 9px;
        margin-bottom: 17px;
        font-size: 12px;
        font-weight: 600;
    }

    .status-dot {
        width: 8px;
        height: 8px;
        flex-shrink: 0;
        background: #22c55e;
        border-radius: 50%;
    }

    .registration-info {
        display: flex;
        flex-direction: column;
        gap: 15px;
    }

    .registration-info-item small {
        display: block;
        margin-bottom: 5px;
        color: #94a3b8;
        font-size: 10px;
    }

    .registration-info-item strong {
        color: #334155;
        font-size: 13px;
        font-weight: 650;
    }

    .registration-divider {
        height: 1px;
        margin: 19px 0;
        background: #edf2f7;
    }

    /* BUTTONS */

    .detail-secondary-btn {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 9px;
        width: 100%;
        min-height: 40px;
        box-sizing: border-box;
        padding: 9px 12px;
        margin-bottom: 9px;
        background: #ffffff;
        color: #2563eb !important;
        border: 1px solid #dbeafe;
        border-radius: 8px;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none !important;
        transition: .2s;
    }

    .detail-secondary-btn:hover {
        background: #eff6ff;
    }

    .detail-secondary-btn span {
        font-size: 16px;
    }

    .registration-form {
        margin-top: 15px;
    }

    .detail-register-btn {
        display: flex;
        align-items: center;
        justify-content: space-between;
        width: 100%;
        min-height: 43px;
        padding: 10px 15px;
        background: #2563eb;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-family: inherit;
        font-size: 12px;
        font-weight: 650;
        cursor: pointer;
        transition: .2s;
    }

    .detail-register-btn:hover:not(:disabled) {
        background: #1d4ed8;
    }

    .detail-register-btn:disabled {
        background: #94a3b8;
        cursor: not-allowed;
    }

    .detail-register-btn span {
        font-size: 19px;
    }

    .registration-note {
        margin: 13px 0 0;
        color: #94a3b8;
        font-size: 10px;
        line-height: 1.6;
        text-align: center;
    }

    /* RESPONSIVE */

    @media (max-width: 900px) {
        .detail-grid {
            grid-template-columns: minmax(0, 1fr) 270px;
        }
    }

    @media (max-width: 768px) {
        .detail-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .detail-heading h1 {
            font-size: 23px;
        }

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-sidebar {
            position: static;
        }
    }

    @media (max-width: 480px) {
        .detail-lomba-page {
            padding: 5px 0 20px;
        }

        .detail-main-card {
            padding: 18px;
        }

        .detail-title {
            font-size: 20px;
        }

        .detail-meta-grid {
            grid-template-columns: 1fr;
        }

        .back-btn {
            width: fit-content;
        }
    }
</style>
@endsection
