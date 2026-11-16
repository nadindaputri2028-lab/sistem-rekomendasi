@extends('layouts.app')

@section('title', 'Detail Portfolio')

@section('content')

<div class="container staff-portfolio-detail">

    {{-- HEADER --}}
    <div class="portfolio-page-header">
        <div>
            <h1>Detail Portfolio</h1>
            <p>Informasi portfolio dan bukti kegiatan mahasiswa.</p>
        </div>
    </div>

    {{-- TOMBOL KEMBALI --}}
    <div class="top-action">
        <a href="{{ route('staff.portfolio.index') }}" class="btn-back">
            &larr; Kembali ke Portfolio
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
                        {{ $portfolio->mahasiswa->nama_lengkap ?? $portfolio->mahasiswa->nama ?? '-' }}
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
                        {{ $portfolio->mahasiswa->prodi ?? 'Teknologi Informasi' }}
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
                        {{ $portfolio->nama_kegiatan ?? $portfolio->judul ?? '-' }}
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
                        {{ $portfolio->organisasi ?? $portfolio->penyelenggara ?? '-' }}
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
                {{ $portfolio->deskripsi ?? 'Tidak ada deskripsi.' }}
            </div>

        </div>

        {{-- BUKTI PORTFOLIO --}}
        @php
            $fileBukti = $portfolio->bukti ?? $portfolio->file_path ?? $portfolio->file_bukti ?? null;
        @endphp

        <div class="detail-section">

            <div class="section-title">
                <h2>Bukti Portfolio</h2>
                <p>Dokumen atau gambar pendukung kegiatan mahasiswa.</p>
            </div>

            @if($fileBukti)

                <div class="file-box">

                    <div class="file-information">

                        <div class="file-icon">
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="1.8"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                                <path d="M14 2v6h6"/>
                                <path d="M8 13h8"/>
                                <path d="M8 17h8"/>
                            </svg>
                        </div>

                        <div>
                            <strong>File Bukti Portfolio</strong>
                            <p>File pendukung portfolio mahasiswa.</p>
                            <small>{{ basename($fileBukti) }}</small>
                        </div>

                    </div>

                    {{-- TOMBOL LIHAT DAN DOWNLOAD --}}
                    <div class="file-actions">

                        {{-- LIHAT FILE --}}
                        <a href="{{ route('file.preview', $fileBukti) }}"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-preview">
                            <svg viewBox="0 0 24 24"
                                 fill="none"
                                 stroke="currentColor"
                                 stroke-width="2"
                                 stroke-linecap="round"
                                 stroke-linejoin="round">
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            Lihat Bukti
                        </a>

                        {{-- DOWNLOAD FILE --}}
                        @if(Route::has('staff.portfolio.bukti'))
                            <a href="{{ route('staff.portfolio.bukti', $portfolio->id) }}"
                               class="btn-file">
                                <svg viewBox="0 0 24 24"
                                     fill="none"
                                     stroke="currentColor"
                                     stroke-width="2"
                                     stroke-linecap="round"
                                     stroke-linejoin="round">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/>
                                    <path d="m7 10 5 5 5-5"/>
                                    <path d="M12 15V3"/>
                                </svg>
                                Download Bukti
                            </a>
                        @else
                            <a href="{{ route('file.preview', $fileBukti) }}"
                               download
                               class="btn-file">
                                Download Bukti
                            </a>
                        @endif

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

/* HALAMAN */
.staff-portfolio-detail {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER */
.staff-portfolio-detail .portfolio-page-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 22px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-portfolio-detail .portfolio-page-header h1 {
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 8px;
}

.staff-portfolio-detail .portfolio-page-header p {
    color: #64748b;
    font-size: 14px;
    margin: 0;
    line-height: 1.6;
}

/* TOMBOL KEMBALI */
.staff-portfolio-detail .top-action {
    margin-bottom: 20px;
}

.staff-portfolio-detail .btn-back {
    display: inline-flex;
    align-items: center;
    padding: 10px 16px;
    background: #ffffff;
    color: #1e3a5f;
    border: 1px solid #cbd5e1;
    text-decoration: none;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    transition: 0.2s;
}

.staff-portfolio-detail .btn-back:hover {
    background: #f1f5f9;
}

/* CARD UTAMA */
.staff-portfolio-detail .portfolio-detail-card {
    background: #ffffff;
    border-radius: 14px;
    border: 1px solid #e2e8f0;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    overflow: hidden;
}

/* SECTION */
.staff-portfolio-detail .detail-section {
    padding: 25px 28px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-portfolio-detail .detail-section:last-child {
    border-bottom: none;
}

.staff-portfolio-detail .section-title {
    margin-bottom: 20px;
}

.staff-portfolio-detail .section-title h2 {
    margin: 0 0 6px;
    font-size: 17px;
    font-weight: 700;
    color: #1e3a5f;
}

.staff-portfolio-detail .section-title p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

/* GRID */
.staff-portfolio-detail .detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 25px;
}

.staff-portfolio-detail .detail-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.staff-portfolio-detail .detail-item.full-width {
    grid-column: 1 / -1;
}

.staff-portfolio-detail .label {
    font-size: 11px;
    color: #64748b;
    font-weight: 700;
    text-transform: uppercase;
}

.staff-portfolio-detail .value {
    font-size: 14px;
    color: #1e293b;
    font-weight: 500;
}

/* DESKRIPSI */
.staff-portfolio-detail .description-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    padding: 17px;
    border-radius: 9px;
    color: #475569;
    font-size: 14px;
    line-height: 1.7;
    white-space: pre-line;
}

/* FILE */
.staff-portfolio-detail .file-box {
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 11px;
    padding: 20px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
}

.staff-portfolio-detail .file-information {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.staff-portfolio-detail .file-icon {
    width: 46px;
    height: 46px;
    min-width: 46px;
    display: flex;
    align-items: center;
    justify-content: center;
    background: #dbeafe;
    color: #1e5b9f;
    border-radius: 10px;
}

.staff-portfolio-detail .file-icon svg {
    width: 24px;
    height: 24px;
}

.staff-portfolio-detail .file-information strong {
    display: block;
    color: #1e3a5f;
    font-size: 14px;
    margin-bottom: 4px;
}

.staff-portfolio-detail .file-information p {
    color: #64748b;
    font-size: 12px;
    margin: 0 0 5px;
}

.staff-portfolio-detail .file-information small {
    display: block;
    color: #94a3b8;
    font-size: 11px;
    overflow-wrap: anywhere;
}

/* TOMBOL FILE */
.staff-portfolio-detail .file-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-shrink: 0;
}

.staff-portfolio-detail .btn-preview,
.staff-portfolio-detail .btn-file {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 7px;
    padding: 10px 15px;
    color: #ffffff;
    text-decoration: none;
    border-radius: 8px;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
    transition: 0.2s;
}

.staff-portfolio-detail .btn-preview {
    background: #2563eb;
}

.staff-portfolio-detail .btn-preview:hover {
    background: #1d4ed8;
}

.staff-portfolio-detail .btn-file {
    background: #1e3a5f;
}

.staff-portfolio-detail .btn-file:hover {
    background: #274b78;
}

.staff-portfolio-detail .btn-preview svg,
.staff-portfolio-detail .btn-file svg {
    width: 16px;
    height: 16px;
}

/* FILE KOSONG */
.staff-portfolio-detail .no-file {
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    padding: 18px;
    border-radius: 9px;
    color: #64748b;
    font-size: 13px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .staff-portfolio-detail {
        padding-top: 20px;
    }

    .staff-portfolio-detail .portfolio-page-header {
        padding: 20px;
    }

    .staff-portfolio-detail .portfolio-page-header h1 {
        font-size: 21px;
    }

    .staff-portfolio-detail .detail-section {
        padding: 20px;
    }

    .staff-portfolio-detail .file-box {
        flex-direction: column;
        align-items: flex-start;
    }

    .staff-portfolio-detail .file-actions {
        width: 100%;
    }

    .staff-portfolio-detail .btn-preview,
    .staff-portfolio-detail .btn-file {
        flex: 1;
    }
}

@media (max-width: 480px) {
    .staff-portfolio-detail .portfolio-page-header,
    .staff-portfolio-detail .detail-section {
        padding: 16px;
    }

    .staff-portfolio-detail .detail-grid {
        grid-template-columns: 1fr;
    }

    .staff-portfolio-detail .detail-item.full-width {
        grid-column: auto;
    }

    .staff-portfolio-detail .file-actions {
        flex-direction: column;
    }

    .staff-portfolio-detail .btn-preview,
    .staff-portfolio-detail .btn-file {
        width: 100%;
        box-sizing: border-box;
    }
}

</style>

@endsection