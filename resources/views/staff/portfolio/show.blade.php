@extends('layouts.app')

@section('title', 'Detail Portfolio')

@section('content')

<div class="container">

    <div class="page-title">
        <h1>Detail Portfolio</h1>
        <p>Informasi portfolio mahasiswa.</p>
    </div>

    <div class="top-action">
        <a href="{{ route('staff.portfolio.index') }}" class="btn-back">
            ← Kembali ke Portfolio
        </a>
    </div>

    <div class="portfolio-detail-card">

        {{-- DATA MAHASISWA --}}
        <div class="detail-section">

            <div class="section-title">
                <h2>Data Mahasiswa</h2>
            </div>

            <div class="detail-grid">

                <div class="detail-item">
                    <span class="label">Nama Lengkap</span>
                    <span class="value">
                        {{ $portfolio->mahasiswa->nama_lengkap ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">NIM</span>
                    <span class="value">
                        {{ $portfolio->mahasiswa->nim ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Program Studi</span>
                    <span class="value">
                        {{ $portfolio->mahasiswa->prodi ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Semester</span>
                    <span class="value">
                        {{ $portfolio->mahasiswa->semester ?? '-' }}
                    </span>
                </div>

            </div>

        </div>


        {{-- INFORMASI PORTFOLIO --}}
        <div class="detail-section">

            <div class="section-title">
                <h2>Informasi Portfolio</h2>
            </div>

            <div class="detail-grid">

                <div class="detail-item full-width">
                    <span class="label">Nama Kegiatan</span>
                    <span class="value">
                        {{ $portfolio->nama_kegiatan ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Posisi</span>
                    <span class="value">
                        {{ $portfolio->posisi ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Organisasi</span>
                    <span class="value">
                        {{ $portfolio->organisasi ?? '-' }}
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Periode Mulai</span>
                    <span class="value">
                        @if($portfolio->periode_mulai)
                            {{ \Carbon\Carbon::parse($portfolio->periode_mulai)->format('d F Y') }}
                        @else
                            -
                        @endif
                    </span>
                </div>

                <div class="detail-item">
                    <span class="label">Periode Selesai</span>
                    <span class="value">
                        @if($portfolio->periode_selesai)
                            {{ \Carbon\Carbon::parse($portfolio->periode_selesai)->format('d F Y') }}
                        @else
                            -
                        @endif
                    </span>
                </div>

            </div>

        </div>


        {{-- DESKRIPSI --}}
        <div class="detail-section">

            <div class="section-title">
                <h2>Deskripsi</h2>
            </div>

            <div class="description-box">
                {{ $portfolio->deskripsi ?? '-' }}
            </div>

        </div>


        {{-- BUKTI PORTFOLIO --}}
        <div class="detail-section">

            <div class="section-title">
                <h2>Bukti Portfolio</h2>
            </div>

            @if($portfolio->bukti)

                <div class="file-box">

                    <div>
                        <strong>File Bukti</strong>

                        <p>
                            File pendukung portfolio mahasiswa.
                        </p>
                    </div>

                    <div class="file-actions">

                        {{-- LIHAT FILE TANPA DOWNLOAD --}}
                        <a href="{{ route('staff.portfolio.preview', $portfolio->id) }}"
                           target="_blank"
                           class="btn-preview">
                            Lihat File
                        </a>

                        {{-- DOWNLOAD FILE --}}
                        <a href="{{ route('staff.portfolio.bukti', $portfolio->id) }}"
                           class="btn-file">
                            Download File
                        </a>

                    </div>

                </div>

            @else

                <div class="no-file">
                    Tidak ada file bukti yang diunggah.
                </div>

            @endif

        </div>

    </div>

</div>


<style>

    .top-action {
        margin: 20px 0;
    }

    .btn-back {
        display: inline-block;
        padding: 10px 16px;
        background: #f1f5f9;
        color: #334155;
        text-decoration: none;
        border-radius: 8px;
        font-size: 14px;
        font-weight: 600;
        transition: 0.2s;
    }

    .btn-back:hover {
        background: #e2e8f0;
    }

    .portfolio-detail-card {
        background: #ffffff;
        border-radius: 14px;
        border: 1px solid #e5e7eb;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .detail-section {
        padding: 24px;
        border-bottom: 1px solid #e5e7eb;
    }

    .detail-section:last-child {
        border-bottom: none;
    }

    .section-title {
        margin-bottom: 20px;
    }

    .section-title h2 {
        margin: 0;
        font-size: 18px;
        color: #0f172a;
    }

    .detail-grid {
        display: grid;
        grid-template-columns: repeat(2, 1fr);
        gap: 18px 24px;
    }

    .detail-item {
        display: flex;
        flex-direction: column;
        gap: 5px;
    }

    .detail-item.full-width {
        grid-column: 1 / -1;
    }

    .label {
        font-size: 12px;
        color: #64748b;
        font-weight: 600;
        text-transform: uppercase;
    }

    .value {
        font-size: 15px;
        color: #1e293b;
        font-weight: 500;
    }

    .description-box {
        background: #f8fafc;
        padding: 16px;
        border-radius: 8px;
        color: #475569;
        line-height: 1.7;
        white-space: pre-line;
    }

    .file-box {
        background: #f8fafc;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 16px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
    }

    .file-box strong {
        color: #334155;
        font-size: 15px;
    }

    .file-box p {
        margin: 4px 0 0;
        color: #64748b;
        font-size: 13px;
    }

    .file-actions {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .btn-preview,
    .btn-file {
        display: inline-block;
        padding: 9px 15px;
        color: white;
        text-decoration: none;
        border-radius: 8px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
    }

    .btn-preview {
        background: #2563eb;
    }

    .btn-preview:hover {
        background: #1d4ed8;
    }

    .btn-file {
        background: #1e3a5f;
    }

    .btn-file:hover {
        background: #16304f;
    }

    .no-file {
        background: #f8fafc;
        padding: 15px;
        border-radius: 8px;
        color: #64748b;
        font-size: 14px;
    }

    @media (max-width: 700px) {

        .detail-grid {
            grid-template-columns: 1fr;
        }

        .detail-item.full-width {
            grid-column: auto;
        }

        .file-box {
            flex-direction: column;
            align-items: flex-start;
        }

        .file-actions {
            width: 100%;
            flex-direction: column;
        }

        .btn-preview,
        .btn-file {
            width: 100%;
            text-align: center;
        }

    }

</style>

@endsection