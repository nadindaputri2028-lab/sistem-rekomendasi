
@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container dosen-mahasiswa">

    <div class="page-header">
        <div>
            <span class="header-label">DOSEN PEMBIMBING AKADEMIK</span>
            <h1>Data Mahasiswa</h1>
            <p>Lihat informasi mahasiswa yang terdaftar dalam sistem.</p>
        </div>
    </div>

    <div class="content-card">

        <div class="card-heading">
            <div>
                <h2>Daftar Mahasiswa</h2>
                <p>Total data: {{ $mahasiswa->total() }} mahasiswa</p>
            </div>
        </div>

        {{-- PENCARIAN --}}
        <form action="{{ route('dosen.mahasiswa.index') }}"
              method="GET"
              class="search-form">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama atau NIM mahasiswa..."
            >

            <button type="submit">Cari</button>

            @if($search)
                <a href="{{ route('dosen.mahasiswa.index') }}"
                   class="reset-button">
                    Reset
                </a>
            @endif
        </form>

        {{-- TABEL MAHASISWA --}}
        <div class="table-responsive">
            <table class="student-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mahasiswa as $index => $mhs)
                        <tr>
                            <td>{{ $mahasiswa->firstItem() + $index }}</td>

                            <td>
                                <strong>{{ $mhs->nama_lengkap }}</strong>
                            </td>

                            <td>{{ $mhs->nim }}</td>

                            <td>{{ $mhs->prodi }}</td>

                            <td>{{ $mhs->semester }}</td>

                            <td>
                                @if($mhs->is_active)
                                    <span class="status-active">Aktif</span>
                                @else
                                    <span class="status-inactive">Tidak Aktif</span>
                                @endif
                            </td>

                            <td>
                                <a href="{{ route('dosen.mahasiswa.show', $mhs->id) }}"
                                   class="detail-button">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="empty-data">
                                Data mahasiswa tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="pagination-wrapper">
            {{ $mahasiswa->links() }}
        </div>

    </div>
</div>

<style>
.dosen-mahasiswa {
    padding-bottom: 30px;
}

.page-header {
    background: linear-gradient(120deg, #1e3a5f, #315f91);
    color: white;
    padding: 32px;
    border-radius: 18px;
    margin-bottom: 25px;
}

.header-label {
    font-size: 11px;
    letter-spacing: 1.4px;
    color: #c9ddf3;
    font-weight: 700;
}

.page-header h1 {
    color: white;
    font-size: 27px;
    margin: 10px 0;
}

.page-header p {
    color: #e2edf8;
    font-size: 14px;
    margin: 0;
}

.content-card {
    background: white;
    border: 1px solid #e8edf3;
    border-radius: 16px;
    padding: 25px;
    box-shadow: 0 4px 15px rgba(15,23,42,.04);
}

.card-heading h2 {
    color: #1e3a5f;
    font-size: 19px;
    margin: 0 0 6px;
}

.card-heading p {
    color: #7b8797;
    font-size: 13px;
    margin: 0;
}

.search-form {
    display: flex;
    gap: 10px;
    margin: 22px 0;
}

.search-form input {
    flex: 1;
    min-width: 0;
    padding: 11px 14px;
    border: 1px solid #dce3ec;
    border-radius: 9px;
    outline: none;
}

.search-form input:focus {
    border-color: #315f91;
}

.search-form button,
.detail-button {
    background: #1e3a5f;
    color: white;
    border: none;
    padding: 10px 18px;
    border-radius: 8px;
    text-decoration: none;
    cursor: pointer;
    font-size: 13px;
}

.reset-button {
    display: flex;
    align-items: center;
    color: #64748b;
    text-decoration: none;
    font-size: 13px;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

.student-table {
    width: 100%;
    border-collapse: collapse;
    white-space: nowrap;
}

.student-table th {
    background: #f1f5f9;
    color: #475569;
    text-align: left;
    padding: 14px 12px;
    font-size: 12px;
}

.student-table td {
    padding: 15px 12px;
    border-bottom: 1px solid #edf0f4;
    font-size: 13px;
    color: #475569;
}

.student-table td strong {
    color: #1e3a5f;
}

.status-active,
.status-inactive {
    padding: 5px 10px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 600;
}

.status-active {
    background: #dcfce7;
    color: #15803d;
}

.status-inactive {
    background: #fee2e2;
    color: #b91c1c;
}

.detail-button:hover {
    background: #315f91;
}

.empty-data {
    text-align: center;
    padding: 30px !important;
    color: #94a3b8 !important;
}

.pagination-wrapper {
    margin-top: 20px;
}

@media(max-width: 600px) {
    .page-header {
        padding: 24px 20px;
    }

    .content-card {
        padding: 16px;
    }

    .search-form {
        flex-wrap: wrap;
    }

    .search-form input {
        flex-basis: 100%;
    }
}
</style>
@endsection
