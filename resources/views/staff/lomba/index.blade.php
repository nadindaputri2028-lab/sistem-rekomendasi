@extends('layouts.app')

@section('title', 'Data Lomba')

@section('content')
<div class="container">
    <div class="section-head">
        <div class="page-title" style="margin: 0;">
            <h1>Input Data Lomba</h1>
            <p>Tambah dan kelola kompetisi yang tersedia untuk mahasiswa.</p>
        </div>
        <a class="btn" href="{{ route('staff.lomba.create') }}">+ Tambah Lomba</a>
    </div>

    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>NAMA LOMBA</th>
                    <th>KATEGORI</th>
                    <th>PENYELENGGARA</th>
                    <th>TANGGAL BERAKHIR</th>
                    <th>STATUS</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($lombas as $l)
                    <tr>
                        <td>
                            <b>{{ $l->nama }}</b>
                        </td>
                        <td>{{ $l->kategori }}</td>
                        <td>{{ $l->penyelenggara }}</td>
                        <td>{{ $l->deadline->format('d M Y') }}</td>
                        <td>
                            <span class="badge green">{{ $l->status }}</span>
                        </td>
                        <td>
                            <div class="actions">
                                <a class="btn small outline" href="{{ route('staff.kriteria.index', ['lomba_id' => $l->id]) }}">
                                    Kriteria
                                </a>
                                <a class="btn small" href="{{ route('staff.lomba.edit', $l) }}">
                                    Edit
                                </a>
                                <form method="POST" action="{{ route('staff.lomba.destroy', $l) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn small danger" data-confirm="Hapus lomba ini?">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada data lomba.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection