
@extends('layouts.app')

@section('title', 'Profil Mahasiswa')

@section('content')

@php
    $foto = $m->foto ?? $m->foto_profil ?? null;
    $nama = $m->nama_lengkap ?? $m->nama ?? 'Mahasiswa';

    $avatarDefault = 'https://ui-avatars.com/api/?name='
        . urlencode($nama)
        . '&background=075eb8&color=ffffff&bold=true';

    if ($foto) {
        $foto = str_replace('\\', '/', $foto);
        $foto = preg_replace('#^/?(public/|storage/)#', '', $foto);
        $avatarUrl = asset('storage/' . ltrim($foto, '/'));
    } else {
        $avatarUrl = $avatarDefault;
    }
@endphp

<style>
/* PROFIL MAHASISWA */

.srp-page {
    background: #f3f7fc;
    min-height: calc(100vh - 70px);
    padding: 22px;
    color: #17365d;
}

.srp-container {
    max-width: 1500px;
    margin: auto;
}

.srp-card {
    background: #fff;
    border: 1px solid #e5edf6;
    border-radius: 17px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(25,55,90,.05);
}

.srp-cover {
    height: 145px;
    background: linear-gradient(110deg,#123e78,#075eb8,#398bd5);
    position: relative;
    overflow: hidden;
}

.srp-cover::after {
    content: "";
    position: absolute;
    width: 260px;
    height: 260px;
    border: 30px solid rgba(255,255,255,.09);
    border-radius: 50%;
    right: 10%;
    top: -150px;
}

.srp-profile-body {
    padding: 25px;
}

.srp-profile-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 20px;
    margin-bottom: 25px;
    margin-top: -85px;
    position: relative;
}

.srp-identity {
    display: flex;
    align-items: center;
    gap: 18px;
    min-width: 0;
}

.srp-avatar {
    width: 115px !important;
    height: 115px !important;
    min-width: 115px !important;
    max-width: 115px !important;
    min-height: 115px !important;
    max-height: 115px !important;
    flex: 0 0 115px !important;
    object-fit: cover !important;
    object-position: center;
    border-radius: 50% !important;
    border: 5px solid white;
    background: #eaf2ff;
    box-shadow: 0 3px 12px rgba(0,0,0,.12);
}

.srp-name {
    padding-top: 75px;
    min-width: 0;
}

.srp-name h2 {
    color: #17365d;
    font-size: 23px;
    margin: 0 0 7px;
    font-weight: 800;
    overflow-wrap: anywhere;
}

.srp-name p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

.srp-actions {
    display: flex;
    flex-wrap: wrap;
    gap: 9px;
    padding-top: 75px;
}

.srp-btn {
    display: inline-flex;
    justify-content: center;
    align-items: center;
    padding: 11px 16px;
    border-radius: 9px;
    text-decoration: none;
    font-size: 12px;
    font-weight: 700;
    border: 1px solid transparent;
    transition: .2s;
    cursor: pointer;
}

.srp-btn-primary {
    background: #075eb8;
    color: white;
}

.srp-btn-primary:hover {
    background: #064b91;
    color: white;
}

.srp-btn-outline {
    background: white;
    border-color: #cbdff8;
    color: #075eb8;
}

.srp-btn-outline:hover {
    background: #eff6ff;
    color: #075eb8;
}

.srp-section-title {
    font-size: 18px;
    font-weight: 800;
    color: #17365d;
    margin: 0 0 16px;
}

.srp-info-grid {
    display: grid;
    grid-template-columns: repeat(2,minmax(0,1fr));
    gap: 15px;
}

.srp-info-box {
    background: #fff;
    border: 1px solid #e5edf6;
    border-radius: 13px;
    padding: 19px;
    min-width: 0;
    transition: .2s;
}

.srp-info-box:hover {
    border-color: #bfd9f8;
}

.srp-info-box h4 {
    color: #075eb8;
    font-size: 14px;
    margin: 0 0 15px;
    font-weight: 800;
}

.srp-info-box p {
    font-size: 13px;
    color: #52657d;
    line-height: 1.8;
    margin: 7px 0;
    overflow-wrap: anywhere;
}

.srp-info-box b {
    color: #17365d;
}

.srp-info-icon {
    width: 38px;
    height: 38px;
    background: #eaf3ff;
    color: #075eb8;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 10px;
    font-size: 19px;
    margin-bottom: 12px;
}

.srp-portfolio-section {
    margin-top: 23px;
}

.srp-portfolio-head {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    flex-wrap: wrap;
    margin-bottom: 15px;
}

.srp-portfolio-head h2 {
    margin: 0 0 5px;
    font-size: 19px;
    color: #17365d;
}

.srp-portfolio-head p {
    color: #718096;
    font-size: 12px;
    margin: 0;
}

.srp-table-wrap {
    background: white;
    border: 1px solid #e5edf6;
    border-radius: 15px;
    overflow-x: auto;
    box-shadow: 0 3px 12px rgba(25,55,90,.05);
}

.srp-table {
    width: 100%;
    min-width: 700px;
    border-collapse: collapse;
}

.srp-table th {
    background: #eaf3ff;
    color: #174b83;
    font-size: 11px;
    font-weight: 800;
    text-align: left;
    padding: 15px;
    white-space: nowrap;
}

.srp-table td {
    padding: 14px 15px;
    border-bottom: 1px solid #edf1f6;
    font-size: 12px;
    color: #52657d;
    vertical-align: middle;
}

.srp-table tbody tr:hover {
    background: #f8fbff;
}

.srp-table tbody tr:last-child td {
    border-bottom: none;
}

.srp-table td b {
    color: #17365d;
}

.srp-table small {
    display: inline-block;
    margin-top: 5px;
    color: #718096;
    line-height: 1.5;
}

.srp-empty {
    padding: 35px 15px !important;
    text-align: center;
    color: #718096 !important;
}

.srp-actions-cell {
    display: flex;
    gap: 6px;
    align-items: center;
}

.srp-actions-cell form {
    margin: 0;
}

.srp-btn-small {
    padding: 7px 10px;
    font-size: 11px;
}

.srp-btn-danger {
    background: #fff1f0;
    color: #dc2626;
    border: 1px solid #fecaca;
}

.srp-btn-danger:hover {
    background: #fee2e2;
}

@media(max-width: 768px) {
    .srp-page {
        padding: 13px;
    }

    .srp-profile-body {
        padding: 16px;
    }

    .srp-profile-head {
        align-items: flex-start;
        gap: 12px;
    }

    .srp-identity {
        width: 100%;
        align-items: center;
    }

    .srp-avatar {
        width: 85px !important;
        height: 85px !important;
        min-width: 85px !important;
        max-width: 85px !important;
        min-height: 85px !important;
        max-height: 85px !important;
        flex-basis: 85px !important;
    }

    .srp-name {
        padding-top: 60px;
    }

    .srp-name h2 {
        font-size: 17px;
    }

    .srp-actions {
        padding-top: 0;
        width: 100%;
    }

    .srp-info-grid {
        grid-template-columns: 1fr;
    }

    .srp-portfolio-head {
        align-items: flex-start;
    }
}

@media(max-width: 420px) {
    .srp-actions {
        flex-direction: column;
    }

    .srp-actions .srp-btn {
        width: 100%;
    }
}
</style>

<div class="srp-page">
<div class="srp-container">

    {{-- PROFIL MAHASISWA --}}
    <div class="srp-card">

        <div class="srp-cover"></div>

        <div class="srp-profile-body">

            <div class="srp-profile-head">

                <div class="srp-identity">

                    <img
                        src="{{ $avatarUrl }}"
                        alt="Foto Profil {{ $nama }}"
                        class="srp-avatar"
                        onerror="this.onerror=null; this.src='{{ $avatarDefault }}';"
                    >

                    <div class="srp-name">

                        <h2>{{ $nama }}</h2>

                        <p>NIM: {{ $m->nim ?? '-' }}</p>

                    </div>

                </div>

                <div class="srp-actions">

                    <a href="{{ route('mahasiswa.portfolio.pdf') }}"
                       target="_blank"
                       class="srp-btn srp-btn-outline">
                        Cetak Portofolio PDF
                    </a>

                    <a href="{{ route('mahasiswa.profil.edit') }}"
                       class="srp-btn srp-btn-primary">
                        Edit Profil
                    </a>

                </div>

            </div>

            {{-- INFORMASI MAHASISWA --}}
            <h3 class="srp-section-title">Informasi Mahasiswa</h3>

            <div class="srp-info-grid">

                <div class="srp-info-box">

                    <div class="srp-info-icon">🎓</div>

                    <h4>Ringkasan Akademik</h4>

                    <p>
                        Semester:
                        <b>{{ $m->semester ?? '-' }}</b>
                    </p>

                    <p>
                        IPK:
                        <b>{{ number_format($m->ipk ?? 0, 2) }}</b>
                    </p>

                    <p>
                        IPS:
                        <b>{{ number_format($m->ips ?? 0, 2) }}</b>
                    </p>

                </div>

                <div class="srp-info-box">

                    <div class="srp-info-icon">📚</div>

                    <h4>Informasi Akademik</h4>

                    <p>
                        Program Studi:
                        <b>{{ $m->prodi ?? 'Teknologi Informasi' }}</b>
                    </p>

                    <p>Email: {{ $m->email ?? '-' }}</p>

                    <p>No. HP: {{ $m->no_hp ?? '-' }}</p>

                </div>

                <div class="srp-info-box">

                    <div class="srp-info-icon">🏆</div>

                    <h4>Prestasi</h4>

                    <p>
                        {{ $m->prestasi ?: 'Belum ada data.' }}
                    </p>

                </div>

                <div class="srp-info-box">

                    <div class="srp-info-icon">💡</div>

                    <h4>Keahlian & Minat</h4>

                    <p>
                        <b>Keahlian:</b>
                        {{ $m->keahlian ?: '-' }}
                    </p>

                    <p>
                        <b>Minat:</b>
                        {{ $m->minat ?: '-' }}
                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- PORTOFOLIO --}}
    <section class="srp-portfolio-section">

        <div class="srp-portfolio-head">

            <div>
                <h2>Portofolio & Pengalaman</h2>

                <p>
                    Riwayat kegiatan, organisasi, dan pengalaman pendukung rekomendasi.
                </p>
            </div>

            <a class="srp-btn srp-btn-primary"
               href="{{ route('mahasiswa.portfolio.create') }}">
                + Tambah Portofolio
            </a>

        </div>

        <div class="srp-table-wrap">

            <table class="srp-table">

                <thead>
                    <tr>
                        <th>KEGIATAN</th>
                        <th>POSISI</th>
                        <th>ORGANISASI</th>
                        <th>PERIODE</th>
                        <th>BUKTI</th>
                        <th>AKSI</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($m->portfolios as $p)

                        @php
                            $fileBukti = $p->bukti
                                ?? $p->file_path
                                ?? $p->file_bukti
                                ?? null;
                        @endphp

                        <tr>

                            <td>
                                <b>{{ $p->nama_kegiatan }}</b>
                                <br>
                                <small>{{ $p->deskripsi }}</small>
                            </td>

                            <td>{{ $p->posisi ?? '-' }}</td>

                            <td>{{ $p->organisasi ?? '-' }}</td>

                            <td>
                                {{ $p->periode_mulai?->format('M Y') ?? '-' }}
                                -
                                {{ $p->periode_selesai?->format('M Y') ?? 'Sekarang' }}
                            </td>

                            <td>
                                @if($fileBukti)

                                    <a href="{{ route('file.preview', $fileBukti) }}"
                                       target="_blank"
                                       class="srp-btn srp-btn-outline srp-btn-small">
                                        Lihat
                                    </a>

                                @else
                                    -
                                @endif
                            </td>

                            <td>
                                <div class="srp-actions-cell">

                                    <a class="srp-btn srp-btn-outline srp-btn-small"
                                       href="{{ route('mahasiswa.portfolio.edit', $p) }}">
                                        Edit
                                    </a>

                                    <form method="POST"
                                          action="{{ route('mahasiswa.portfolio.destroy', $p) }}">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="srp-btn srp-btn-danger srp-btn-small"
                                                data-confirm="Hapus portfolio ini?">
                                            Hapus
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="6" class="srp-empty">
                                Belum ada portofolio.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </section>

</div>
</div>

@endsection
