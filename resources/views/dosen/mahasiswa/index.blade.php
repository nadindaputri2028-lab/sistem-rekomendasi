@extends('layouts.app')

@section('title', 'Data Mahasiswa')

@section('content')
<div class="container">

    <div class="page-title">
        <h1>Data Mahasiswa</h1>
        <p>Daftar mahasiswa yang dapat dilihat oleh Dosen Pembimbing Akademik.</p>
    </div>

    <div class="card">

        <form action="{{ route('dosen.mahasiswa.index') }}"
              method="GET"
              style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama atau NIM mahasiswa..."
                style="flex: 1; min-width: 200px; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
            >

            <button type="submit" class="btn btn-primary">
                Cari
            </button>

            @if($search)
                <a href="{{ route('dosen.mahasiswa.index') }}"
                   class="btn">
                    Reset
                </a>
            @endif

        </form>

        <div style="overflow-x: auto;">
            <table class="table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Mahasiswa</th>
                        <th>NIM</th>
                        <th>Program Studi</th>
                        <th>Semester</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($mahasiswa as $index => $mhs)
                        <tr>
                            <td>
                                {{ $mahasiswa->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $mhs->nama_lengkap }}
                            </td>

                            <td>
                                {{ $mhs->nim }}
                            </td>

                            <td>
                                {{ $mhs->prodi ?? '-' }}
                            </td>

                            <td>
                                {{ $mhs->semester ?? '-' }}
                            </td>

                            <td>
                                <a href="{{ route('dosen.mahasiswa.show', $mhs->id) }}"
                                   class="btn btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" style="text-align: center; padding: 25px;">
                                Data mahasiswa tidak ditemukan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $mahasiswa->links() }}
        </div>

    </div>
</div>
@endsection