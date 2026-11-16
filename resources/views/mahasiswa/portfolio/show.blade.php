@extends('layouts.app')

@section('title', 'Detail Portfolio')

@section('content')

<div class="container mahasiswa-portfolio-detail">

    {{-- HEADER --}}
    <div class="detail-header">
        <div>
            <h1>Detail Portfolio</h1>
            <p>Informasi lengkap pengalaman dan kegiatan Anda.</p>
        </div>
    </div>

    <div class="top-action">
        <a href="{{ route('mahasiswa.portfolio.index') }}" class="btn-back">
            &larr; Kembali ke Portfolio
        </a>
    </div>

    <div class="detail-card">

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
                {{ $portfolio->deskripsi ?? 'Tidak ada deskripsi.' }}
            </div>
        </div>

        {{-- BUKTI PORTFOLIO --}}
        <div class="detail-section">
            <div class="section-title">
                <h2>Bukti Portfolio</h2>
                <p>File pendukung kegiatan atau pengalaman Anda.</p>
            </div>

            @if($portfolio->bukti)

                @php
                    $extension = strtolower(
                        pathinfo($portfolio->bukti, PATHINFO_EXTENSION)
                    );

                    $isImage = in_array($extension, [
                        'jpg', 'jpeg', 'png', 'webp'
                    ]);

                    $isPdf = $extension === 'pdf';
                @endphp

                <div class="file-box">

                    <div class="file-information">
                        <strong>File Bukti Portfolio</strong>
                        <p>{{ basename($portfolio->bukti) }}</p>
                    </div>

                    <div class="file-actions">
                        <a
                            href="{{ route('mahasiswa.portfolio.preview', $portfolio->id) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                            class="btn-preview"
                        >
                            Lihat Bukti
                        </a>

                        <a
                            href="{{ route('mahasiswa.portfolio.bukti', $portfolio->id) }}"
                            class="btn-download"
                        >
                            Download Bukti
                        </a>
                    </div>

                </div>

                {{-- PREVIEW GAMBAR --}}
                @if($isImage)
                    <div class="evidence-preview">
                        <h3>Pratinjau Gambar</h3>

                        <a
                            href="{{ route('mahasiswa.portfolio.preview', $portfolio->id) }}"
                            target="_blank"
                            rel="noopener noreferrer"
                        >
                            <img
                                src="{{ route('mahasiswa.portfolio.preview', $portfolio->id) }}"
                                alt="Bukti Portfolio"
                            >
                        </a>
                    </div>

                {{-- PREVIEW PDF --}}
                @elseif($isPdf)
                    <div class="evidence-preview">
                        <h3>Pratinjau Dokumen PDF</h3>

                        <iframe
                            src="{{ route('mahasiswa.portfolio.preview', $portfolio->id) }}"
                            title="Bukti Portfolio PDF"
                            class="pdf-preview"
                        ></iframe>
                    </div>
                @endif

            @else

                <div class="no-file">
                    Tidak ada file bukti yang diunggah.
                </div>

            @endif
        </div>

    </div>

</div>

<style>
.mahasiswa-portfolio-detail {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER */
.mahasiswa-portfolio-detail .detail-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 20px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.mahasiswa-portfolio-detail .detail-header h1 {
    margin: 0 0 8px;
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
}

.mahasiswa-portfolio-detail .detail-header p {
    margin: 0;
    color: #64748b;
    font-size: 14px;
}

/* KEMBALI */
.mahasiswa-portfolio-detail .top-action {
    margin-bottom: 20px;
}

.mahasiswa-portfolio-detail .btn-back {
    display: inline-block;
    padding: 10px 16px;
    background: #ffffff;
    color: #1e3a5f;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
}

.mahasiswa-portfolio-detail .btn-back:hover {
    background: #f1f5f9;
}

/* CARD */
.mahasiswa-portfolio-detail .detail-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.mahasiswa-portfolio-detail .detail-section {
    padding: 25px 28px;
    border-bottom: 1px solid #e2e8f0;
}

.mahasiswa-portfolio-detail .detail-section:last-child {
    border-bottom: none;
}

.mahasiswa-portfolio-detail .section-title {
    margin-bottom: 20px;
}

.mahasiswa-portfolio-detail .section-title h2 {
    margin: 0 0 6px;
    color: #1e3a5f;
    font-size: 17px;
    font-weight: 700;
}

.mahasiswa-portfolio-detail .section-title p {
    margin: 0;
    color: #64748b;
    font-size: 13px;
}

/* DATA */
.mahasiswa-portfolio-detail .detail-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 20px 25px;
}

.mahasiswa-portfolio-detail .detail-item {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.mahasiswa-portfolio-detail .full-width {
    grid-column: 1 / -1;
}

.mahasiswa-portfolio-detail .label {
    color: #64748b;
    font-size: 11px;
    font-weight: 700;
    text-transform: uppercase;
}

.mahasiswa-portfolio-detail .value {
    color: #1e293b;
    font-size: 14px;
    font-weight: 500;
}

/* DESKRIPSI */
.mahasiswa-portfolio-detail .description-box {
    padding: 17px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 9px;
    color: #475569;
    font-size: 14px;
    line-height: 1.7;
    white-space: pre-line;
}

/* FILE */
.mahasiswa-portfolio-detail .file-box {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    padding: 18px;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}

.mahasiswa-portfolio-detail .file-information strong {
    display: block;
    color: #1e3a5f;
    font-size: 14px;
    margin-bottom: 5px;
}

.mahasiswa-portfolio-detail .file-information p {
    margin: 0;
    color: #64748b;
    font-size: 12px;
    overflow-wrap: anywhere;
}

.mahasiswa-portfolio-detail .file-actions {
    display: flex;
    gap: 10px;
}

.mahasiswa-portfolio-detail .btn-preview,
.mahasiswa-portfolio-detail .btn-download {
    display: inline-block;
    padding: 10px 15px;
    color: #ffffff;
    border-radius: 8px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 600;
    white-space: nowrap;
}

.mahasiswa-portfolio-detail .btn-preview {
    background: #2563eb;
}

.mahasiswa-portfolio-detail .btn-preview:hover {
    background: #1d4ed8;
}

.mahasiswa-portfolio-detail .btn-download {
    background: #1e3a5f;
}

.mahasiswa-portfolio-detail .btn-download:hover {
    background: #274b78;
}

/* PREVIEW */
.mahasiswa-portfolio-detail .evidence-preview {
    margin-top: 22px;
}

.mahasiswa-portfolio-detail .evidence-preview h3 {
    margin: 0 0 12px;
    color: #1e3a5f;
    font-size: 14px;
}

.mahasiswa-portfolio-detail .evidence-preview img {
    display: block;
    max-width: 100%;
    max-height: 550px;
    object-fit: contain;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
    background: #f8fafc;
}

.mahasiswa-portfolio-detail .pdf-preview {
    display: block;
    width: 100%;
    height: 600px;
    border: 1px solid #e2e8f0;
    border-radius: 10px;
}

/* FILE KOSONG */
.mahasiswa-portfolio-detail .no-file {
    padding: 17px;
    background: #f8fafc;
    border: 1px dashed #cbd5e1;
    border-radius: 9px;
    color: #64748b;
    font-size: 13px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .mahasiswa-portfolio-detail .detail-header {
        padding: 20px;
    }

    .mahasiswa-portfolio-detail .detail-section {
        padding: 20px;
    }

    .mahasiswa-portfolio-detail .file-box {
        flex-direction: column;
        align-items: flex-start;
    }

    .mahasiswa-portfolio-detail .file-actions {
        width: 100%;
    }

    .mahasiswa-portfolio-detail .btn-preview,
    .mahasiswa-portfolio-detail .btn-download {
        flex: 1;
        text-align: center;
    }

    .mahasiswa-portfolio-detail .pdf-preview {
        height: 450px;
    }
}

@media (max-width: 480px) {
    .mahasiswa-portfolio-detail .detail-grid {
        grid-template-columns: 1fr;
    }

    .mahasiswa-portfolio-detail .full-width {
        grid-column: auto;
    }

    .mahasiswa-portfolio-detail .file-actions {
        flex-direction: column;
    }

    .mahasiswa-portfolio-detail .btn-preview,
    .mahasiswa-portfolio-detail .btn-download {
        width: 100%;
        box-sizing: border-box;
    }
}
</style>

@endsection
