
@extends('layouts.app')

@section('title', 'Penilaian Mahasiswa')

@section('content')
<div class="container penilaian-list-container">

    {{-- HEADER --}}
    <div class="page-heading">
        <div>
            <h1>Penilaian Mahasiswa</h1>
            <p>Kelola dan pantau hasil penilaian akademik mahasiswa.</p>
        </div>
    </div>

    {{-- STATISTIK --}}
    <div class="stats-grid">
        <div class="stats-card">
            <div class="stats-icon blue">
                <i class="fas fa-users"></i>
            </div>
            <div>
                <span>Total Mahasiswa</span>
                <h2>{{ $totalMahasiswa }}</h2>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon green">
                <i class="fas fa-check-circle"></i>
            </div>
            <div>
                <span>Sudah Dinilai</span>
                <h2>{{ $totalDinilai }}</h2>
            </div>
        </div>

        <div class="stats-card">
            <div class="stats-icon orange">
                <i class="fas fa-clock"></i>
            </div>
            <div>
                <span>Belum Dinilai</span>
                <h2>{{ $totalBelumDinilai }}</h2>
            </div>
        </div>
    </div>

    {{-- DAFTAR MAHASISWA --}}
    <div class="content-card">

        <div class="list-header">
            <div>
                <h3>Daftar Mahasiswa</h3>
                <p>Pilih mahasiswa untuk melihat atau memberikan penilaian.</p>
            </div>

            <form action="{{ route('dosen.penilaian.index') }}"
                  method="GET"
                  class="search-form">

                <input type="text"
                       name="search"
                       value="{{ $search }}"
                       placeholder="Cari nama atau NIM...">

                <button type="submit">
                    <i class="fas fa-search"></i>
                    Cari
                </button>
            </form>
        </div>

        <div class="table-wrapper">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Mahasiswa</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Status Penilaian</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($mahasiswa as $index => $item)
                        <tr>
                            <td>
                                {{ $mahasiswa->firstItem() + $index }}
                            </td>

                            <td>
                                <div class="student-name">
                                    <div class="student-avatar">
                                        {{ strtoupper(substr($item->nama_lengkap, 0, 1)) }}
                                    </div>

                                    <strong>{{ $item->nama_lengkap }}</strong>
                                </div>
                            </td>

                            <td>{{ $item->nim }}</td>

                            <td>{{ $item->prodi }}</td>

                            <td>
                                @if ($item->penilaian)
                                    <span class="status-badge status-done">
                                        <i class="fas fa-check-circle"></i>
                                        Sudah Dinilai
                                    </span>
                                @else
                                    <span class="status-badge status-pending">
                                        <i class="fas fa-clock"></i>
                                        Belum Dinilai
                                    </span>
                                @endif
                            </td>

                            <td>
                                @if ($item->penilaian)
                                    <a href="{{ route('dosen.penilaian.show', $item->penilaian->id) }}"
                                       class="action-button btn-detail">
                                        Lihat Hasil
                                    </a>
                                @else
                                    <a href="{{ route('dosen.penilaian.create', $item->id) }}"
                                       class="action-button btn-assess">
                                        Buat Penilaian
                                    </a>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="empty-data">
                                <i class="fas fa-user-slash"></i>
                                <strong>Data mahasiswa tidak ditemukan</strong>
                                <span>Periksa kembali nama atau NIM yang dicari.</span>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        {{-- PAGINATION --}}
        @if ($mahasiswa->hasPages())
            <div class="pagination-wrapper">
                {{ $mahasiswa->links() }}
            </div>
        @endif

    </div>
</div>

<style>
.penilaian-list-container {
    max-width: 1150px;
    margin: 0 auto;
    padding-bottom: 35px;
    color: #243247;
}

.page-heading {
    margin-bottom: 25px;
}

.page-heading h1 {
    font-size: 25px;
    font-weight: 700;
    color: #1e3a5f;
    margin: 0 0 7px;
}

.page-heading p {
    margin: 0;
    color: #718096;
    font-size: 13px;
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 17px;
    margin-bottom: 22px;
}

.stats-card {
    display: flex;
    align-items: center;
    gap: 15px;
    background: #fff;
    border: 1px solid #e5eaf0;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 3px 12px rgba(30, 58, 95, 0.04);
}

.stats-icon {
    width: 45px;
    height: 45px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 9px;
    font-size: 18px;
    flex-shrink: 0;
}

.stats-icon.blue {
    color: #376da8;
    background: #edf3fa;
}

.stats-icon.green {
    color: #26865c;
    background: #eaf7f0;
}

.stats-icon.orange {
    color: #c18431;
    background: #fff5e7;
}

.stats-card span {
    color: #718096;
    font-size: 12px;
}

.stats-card h2 {
    color: #1e3a5f;
    font-size: 25px;
    margin: 5px 0 0;
    font-weight: 700;
}

.content-card {
    background: #fff;
    border: 1px solid #e5eaf0;
    border-radius: 11px;
    padding: 23px;
    box-shadow: 0 3px 12px rgba(30, 58, 95, 0.04);
}

.list-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 18px;
    margin-bottom: 20px;
}

.list-header h3 {
    color: #1e3a5f;
    font-size: 17px;
    margin: 0 0 6px;
}

.list-header p {
    color: #8491a3;
    font-size: 12px;
    margin: 0;
}

.search-form {
    display: flex;
    gap: 8px;
    max-width: 350px;
    width: 100%;
}

.search-form input {
    min-width: 0;
    flex: 1;
    padding: 10px 12px;
    border: 1px solid #dce3eb;
    border-radius: 7px;
    outline: none;
    font-size: 12px;
}

.search-form input:focus {
    border-color: #376da8;
}

.search-form button {
    padding: 10px 15px;
    border: none;
    border-radius: 7px;
    background: #1e3a5f;
    color: white;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
}

.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.student-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 750px;
}

.student-table th {
    padding: 14px 12px;
    background: #f3f6fa;
    color: #52647a;
    text-align: left;
    font-size: 12px;
    font-weight: 700;
    white-space: nowrap;
}

.student-table td {
    padding: 14px 12px;
    border-bottom: 1px solid #edf0f4;
    color: #52647a;
    font-size: 12px;
}

.student-table tbody tr:hover {
    background: #fafbfd;
}

.student-name {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 180px;
}

.student-name strong {
    color: #29384d;
    font-weight: 600;
}

.student-avatar {
    width: 33px;
    height: 33px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #edf3fa;
    color: #1e3a5f;
    font-weight: 700;
    flex-shrink: 0;
}

.status-badge {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 6px 9px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
    white-space: nowrap;
}

.status-done {
    background: #eaf7f0;
    color: #26865c;
}

.status-pending {
    background: #fff5e7;
    color: #b77a27;
}

.action-button {
    display: inline-block;
    padding: 8px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: 600;
    text-decoration: none;
    white-space: nowrap;
}

.btn-detail {
    background: #edf3fa;
    color: #1e3a5f;
}

.btn-assess {
    background: #1e3a5f;
    color: white;
}

.btn-detail:hover {
    background: #dce8f5;
}

.btn-assess:hover {
    background: #294f7d;
    color: white;
}

.empty-data {
    text-align: center;
    padding: 45px 15px !important;
}

.empty-data i {
    display: block;
    color: #a6b1bf;
    font-size: 25px;
    margin-bottom: 12px;
}

.empty-data strong,
.empty-data span {
    display: block;
}

.empty-data strong {
    color: #34445a;
    font-size: 13px;
    margin-bottom: 5px;
}

.empty-data span {
    color: #8491a3;
    font-size: 12px;
}

.pagination-wrapper {
    margin-top: 20px;
    display: flex;
    justify-content: flex-end;
}

@media (max-width: 768px) {
    .penilaian-list-container {
        padding: 0 12px 25px;
    }

    .page-heading h1 {
        font-size: 21px;
    }

    .stats-grid {
        grid-template-columns: 1fr;
        gap: 12px;
    }

    .content-card {
        padding: 16px;
    }

    .list-header {
        flex-direction: column;
        align-items: stretch;
    }

    .search-form {
        max-width: 100%;
    }

    .pagination-wrapper {
        justify-content: center;
        overflow-x: auto;
    }
}
</style>
@endsection
