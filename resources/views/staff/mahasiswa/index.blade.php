@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container">
    <div class="section-head">
        <div class="page-title" style="margin: 0;">
            <h1>Input Data Mahasiswa</h1>
            <p>Kelola data mahasiswa yang menjadi sumber sistem rekomendasi.</p>
        </div>
        <a class="btn" href="{{ route('staff.mahasiswa.create') }}">+ Tambah Mahasiswa</a>
    </div>

    <form class="toolbar">
        <div class="search">
            <input name="q" value="{{ request('q') }}" placeholder="🔍 Cari nama atau NIM...">
        </div>
        <button class="btn">Cari</button>
    </form>

    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>MAHASISWA</th>
                    <th>NIM</th>
                    <th>PRODI</th>
                    <th>SEMESTER</th>
                    <th>IPK</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($mahasiswas as $m)
                    <tr>
                        <td>
                            <b>{{ $m->nama_lengkap }}</b>
                        </td>
                        <td>{{ $m->nim }}</td>
                        <td>{{ $m->prodi }}</td>
                        <td>{{ $m->semester }}</td>
                        <td>{{ number_format($m->ipk ?? 0, 2) }}</td>
                        <td>
                            <span class="badge green">Aktif</span>
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn small outline" href="{{ route('staff.mahasiswa.show', $m) }}">
                                    Detail
                                </a>
                                <a class="btn small" href="{{ route('staff.mahasiswa.edit', $m) }}">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('staff.mahasiswa.destroy', $m) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn small danger" data-confirm="Hapus mahasiswa ini?">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="empty">Belum ada data mahasiswa.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $mahasiswas->links('layouts.pagination') }}
    </div>
</div>
@endsection