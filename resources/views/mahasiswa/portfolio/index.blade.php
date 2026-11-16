
@extends('layouts.app')

@section('title', 'Portfolio Saya')

@section('content')
<div class="portfolio-page">

    <div class="portfolio-heading">
        <div>
            <span class="portfolio-label">PORTFOLIO MAHASISWA</span>
            <h1>Portfolio Saya</h1>
            <p>Kelola pengalaman, prestasi, dan kegiatan Anda untuk mendukung rekomendasi.</p>
        </div>

        <a class="portfolio-add-btn" href="{{ route('mahasiswa.portfolio.create') }}">
            <span>+</span> Tambah Portfolio
        </a>
    </div>

    <div class="portfolio-card">

        <div class="portfolio-card-header">
            <div>
                <h2>Pengalaman / Kegiatan</h2>
                <p>Daftar pengalaman dan kegiatan yang telah Anda tambahkan.</p>
            </div>

            <div class="portfolio-total">
                {{ $portfolios->count() }} Portfolio
            </div>
        </div>

        <div class="portfolio-table-wrapper">
            <table class="portfolio-table">
                <thead>
                    <tr>
                        <th>KEGIATAN</th>
                        <th>POSISI</th>
                        <th>INSTITUSI / ORGANISASI</th>
                        <th>PERIODE</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($portfolios as $p)
                        <tr>
                            <td class="activity-cell">
                                <strong>{{ $p->nama_kegiatan }}</strong>
                                <small>{{ $p->deskripsi ?: 'Tidak ada deskripsi.' }}</small>
                            </td>

                            <td>{{ $p->posisi ?: '-' }}</td>

                            <td>{{ $p->organisasi ?: '-' }}</td>

                            <td class="period-cell">
                                {{ $p->periode_mulai?->format('M Y') ?? '-' }}
                                <span>sampai</span>
                                {{ $p->periode_selesai?->format('M Y') ?? 'Sekarang' }}
                            </td>

                            <td>
                                <div class="portfolio-actions">

                                    <button
                                        type="button"
                                        class="portfolio-btn detail-btn js-detail-portfolio"
                                        data-kegiatan="{{ $p->nama_kegiatan }}"
                                        data-posisi="{{ $p->posisi }}"
                                        data-organisasi="{{ $p->organisasi }}"
                                        data-periode-mulai="{{ $p->periode_mulai?->format('d M Y') }}"
                                        data-periode-selesai="{{ $p->periode_selesai?->format('d M Y') }}"
                                        data-deskripsi="{{ $p->deskripsi }}"
                                    >
                                        Detail
                                    </button>

                                    <a
                                        class="portfolio-btn edit-btn"
                                        href="{{ route('mahasiswa.portfolio.edit', $p) }}"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('mahasiswa.portfolio.destroy', $p) }}"
                                        onsubmit="return confirm('Hapus portfolio ini?')"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="portfolio-btn delete-btn">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="5">
                                <div class="portfolio-empty">
                                    <div class="empty-icon">▤</div>
                                    <strong>Belum Ada Portfolio</strong>
                                    <p>Tambahkan pengalaman atau kegiatan pertama Anda.</p>
                                    <a href="{{ route('mahasiswa.portfolio.create') }}">
                                        + Tambah Portfolio
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

{{-- MODAL DETAIL PORTFOLIO --}}
<div id="modalDetailPortfolio" class="portfolio-modal">
    <div class="portfolio-modal-box">

        <div class="portfolio-modal-header">
            <div>
                <span>INFORMASI PORTFOLIO</span>
                <h3>Detail Portfolio</h3>
            </div>

            <button type="button" class="portfolio-modal-close" id="portfolioModalClose">
                &times;
            </button>
        </div>

        <div class="portfolio-modal-body">

            <div class="portfolio-detail-item">
                <strong>Kegiatan</strong>
                <span id="detail_kegiatan"></span>
            </div>

            <div class="portfolio-detail-item">
                <strong>Posisi</strong>
                <span id="detail_posisi"></span>
            </div>

            <div class="portfolio-detail-item">
                <strong>Organisasi</strong>
                <span id="detail_organisasi"></span>
            </div>

            <div class="portfolio-detail-item">
                <strong>Periode</strong>
                <span id="detail_periode"></span>
            </div>

            <div class="portfolio-detail-item description-item">
                <strong>Deskripsi</strong>
                <p id="detail_deskripsi"></p>
            </div>

        </div>
    </div>
</div>

<style>
    .portfolio-page {
        padding: 10px 5px 30px;
        color: #24364b;
    }

    .portfolio-heading {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 20px;
        margin-bottom: 28px;
    }

    .portfolio-label {
        display: inline-block;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 1.2px;
        margin-bottom: 8px;
    }

    .portfolio-heading h1 {
        margin: 0 0 8px;
        color: #1e3a5f;
        font-size: 27px;
        font-weight: 750;
    }

    .portfolio-heading p {
        margin: 0;
        color: #718096;
        font-size: 14px;
        line-height: 1.6;
    }

    .portfolio-add-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        padding: 11px 18px;
        background: #2563eb;
        color: white !important;
        text-decoration: none !important;
        border-radius: 9px;
        font-size: 13px;
        font-weight: 600;
        white-space: nowrap;
        transition: .2s;
    }

    .portfolio-add-btn:hover {
        background: #1d4ed8;
        transform: translateY(-1px);
    }

    .portfolio-add-btn span {
        font-size: 19px;
        line-height: 1;
    }

    .portfolio-card {
        background: #ffffff;
        border: 1px solid #e5edf6;
        border-radius: 14px;
        box-shadow: 0 4px 18px rgba(30, 58, 95, .05);
        overflow: hidden;
    }

    .portfolio-card-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 15px;
        padding: 22px 24px;
        border-bottom: 1px solid #edf2f7;
    }

    .portfolio-card-header h2 {
        margin: 0 0 6px;
        color: #1e3a5f;
        font-size: 17px;
        font-weight: 700;
    }

    .portfolio-card-header p {
        margin: 0;
        color: #8492a6;
        font-size: 12px;
    }

    .portfolio-total {
        padding: 7px 12px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        white-space: nowrap;
    }

    .portfolio-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .portfolio-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
    }

    .portfolio-table thead {
        background: #f8faff;
    }

    .portfolio-table th {
        padding: 15px 18px;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .5px;
        text-align: left;
        white-space: nowrap;
        border-bottom: 1px solid #edf2f7;
    }

    .portfolio-table td {
        padding: 17px 18px;
        color: #475569;
        font-size: 12px;
        vertical-align: middle;
        border-bottom: 1px solid #f0f3f8;
    }

    .portfolio-table tbody tr:last-child td {
        border-bottom: none;
    }

    .portfolio-table tbody tr:hover {
        background: #fafcff;
    }

    .activity-cell strong {
        display: block;
        color: #1e3a5f;
        font-size: 13px;
        font-weight: 650;
        margin-bottom: 5px;
    }

    .activity-cell small {
        display: block;
        max-width: 220px;
        color: #8996a8;
        font-size: 11px;
        line-height: 1.5;
    }

    .period-cell {
        white-space: nowrap;
    }

    .period-cell span {
        color: #94a3b8;
        font-size: 10px;
        margin: 0 3px;
    }

    .portfolio-actions {
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .portfolio-actions form {
        margin: 0;
    }

    .portfolio-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 7px 10px;
        border-radius: 6px;
        border: 1px solid transparent;
        font-family: inherit;
        font-size: 11px;
        font-weight: 600;
        text-decoration: none !important;
        cursor: pointer;
        transition: .2s;
        white-space: nowrap;
    }

    .detail-btn {
        background: #eff6ff;
        color: #2563eb;
        border-color: #dbeafe;
    }

    .detail-btn:hover {
        background: #dbeafe;
    }

    .edit-btn {
        background: #f0f9ff;
        color: #0284c7;
        border-color: #e0f2fe;
    }

    .edit-btn:hover {
        background: #e0f2fe;
    }

    .delete-btn {
        background: #fff1f2;
        color: #e11d48;
        border-color: #ffe4e6;
    }

    .delete-btn:hover {
        background: #ffe4e6;
    }

    .portfolio-empty {
        padding: 55px 20px;
        text-align: center;
    }

    .empty-icon {
        width: 52px;
        height: 52px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 14px;
        background: #eff6ff;
        color: #2563eb;
        border-radius: 14px;
        font-size: 25px;
    }

    .portfolio-empty strong {
        display: block;
        color: #1e3a5f;
        font-size: 15px;
        margin-bottom: 7px;
    }

    .portfolio-empty p {
        color: #8492a6;
        font-size: 12px;
        margin: 0 0 15px;
    }

    .portfolio-empty a {
        display: inline-block;
        padding: 9px 15px;
        background: #2563eb;
        color: #fff;
        text-decoration: none;
        border-radius: 7px;
        font-size: 12px;
        font-weight: 600;
    }

    /* MODAL */

    .portfolio-modal {
        display: none;
        position: fixed;
        inset: 0;
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 20px;
        background: rgba(15, 35, 60, .55);
    }

    .portfolio-modal.open {
        display: flex;
    }

    .portfolio-modal-box {
        width: 100%;
        max-width: 510px;
        max-height: 90vh;
        overflow-y: auto;
        background: #ffffff;
        border-radius: 14px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, .2);
        animation: portfolioModalShow .2s ease;
    }

    @keyframes portfolioModalShow {
        from {
            opacity: 0;
            transform: translateY(10px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .portfolio-modal-header {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 21px 23px;
        border-bottom: 1px solid #edf2f7;
    }

    .portfolio-modal-header span {
        display: block;
        margin-bottom: 5px;
        color: #2563eb;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
    }

    .portfolio-modal-header h3 {
        margin: 0;
        color: #1e3a5f;
        font-size: 18px;
        font-weight: 700;
    }

    .portfolio-modal-close {
        width: 32px;
        height: 32px;
        border: none;
        background: #f1f5f9;
        color: #64748b;
        border-radius: 8px;
        font-size: 23px;
        cursor: pointer;
    }

    .portfolio-modal-close:hover {
        background: #e2e8f0;
        color: #1e3a5f;
    }

    .portfolio-modal-body {
        padding: 10px 23px 20px;
    }

    .portfolio-detail-item {
        padding: 13px 0;
        border-bottom: 1px solid #edf2f7;
    }

    .portfolio-detail-item:last-child {
        border-bottom: none;
    }

    .portfolio-detail-item strong {
        display: block;
        margin-bottom: 6px;
        color: #8492a6;
        font-size: 11px;
        font-weight: 600;
    }

    .portfolio-detail-item span,
    .portfolio-detail-item p {
        color: #334155;
        font-size: 13px;
        line-height: 1.7;
        overflow-wrap: anywhere;
    }

    .portfolio-detail-item p {
        margin: 0;
    }

    @media (max-width: 768px) {
        .portfolio-heading {
            align-items: flex-start;
            flex-direction: column;
        }

        .portfolio-heading h1 {
            font-size: 23px;
        }

        .portfolio-card-header {
            padding: 18px;
        }

        .portfolio-card-header p {
            line-height: 1.5;
        }
    }

    @media (max-width: 480px) {
        .portfolio-page {
            padding: 5px 0 20px;
        }

        .portfolio-add-btn {
            width: 100%;
        }

        .portfolio-card-header {
            align-items: flex-start;
            flex-direction: column;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('modalDetailPortfolio');
        const closeBtn = document.getElementById('portfolioModalClose');

        function openModal(data) {
            document.getElementById('detail_kegiatan').textContent = data.kegiatan || '-';
            document.getElementById('detail_posisi').textContent = data.posisi || '-';
            document.getElementById('detail_organisasi').textContent = data.organisasi || '-';

            document.getElementById('detail_periode').textContent =
                (data.periodeMulai || '-') + ' - ' + (data.periodeSelesai || 'Sekarang');

            document.getElementById('detail_deskripsi').textContent = data.deskripsi || '-';

            modal.classList.add('open');
        }

        function closeModal() {
            modal.classList.remove('open');
        }

        document.querySelectorAll('.js-detail-portfolio').forEach(function (btn) {
            btn.addEventListener('click', function () {
                openModal({
                    kegiatan: btn.dataset.kegiatan,
                    posisi: btn.dataset.posisi,
                    organisasi: btn.dataset.organisasi,
                    periodeMulai: btn.dataset.periodeMulai,
                    periodeSelesai: btn.dataset.periodeSelesai,
                    deskripsi: btn.dataset.deskripsi,
                });
            });
        });

        if (closeBtn) {
            closeBtn.addEventListener('click', closeModal);
        }

        if (modal) {
            modal.addEventListener('click', function (event) {
                if (event.target === modal) {
                    closeModal();
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape') {
                closeModal();
            }
        });
    });
</script>
@endsection
