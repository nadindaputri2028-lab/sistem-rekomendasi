
@extends('layouts.app')

@section('title', 'Portfolio Mahasiswa')

@section('content')
<div class="container">

    <div class="page-title">
        <h1>Portfolio Mahasiswa</h1>
        <p>Daftar pengalaman, kegiatan, dan prestasi mahasiswa.</p>
    </div>

    <div class="card">

        <form action="{{ route('dosen.portfolio.index') }}"
              method="GET"
              style="display: flex; gap: 10px; margin-bottom: 20px; flex-wrap: wrap;">

            <input
                type="text"
                name="search"
                value="{{ $search }}"
                placeholder="Cari nama mahasiswa, NIM, atau kegiatan..."
                style="flex: 1; min-width: 200px; padding: 10px; border: 1px solid #ddd; border-radius: 6px;"
            >

            <button type="submit" class="btn btn-primary">
                Cari
            </button>

            @if($search)
                <a href="{{ route('dosen.portfolio.index') }}" class="btn">
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
                        <th>Nama Kegiatan</th>
                        <th>Posisi</th>
                        <th>Organisasi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($portfolios as $index => $portfolio)
                        <tr>
                            <td>
                                {{ $portfolios->firstItem() + $index }}
                            </td>

                            <td>
                                {{ $portfolio->mahasiswa->nama_lengkap ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->mahasiswa->nim ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->nama_kegiatan }}
                            </td>

                            <td>
                                {{ $portfolio->posisi ?? '-' }}
                            </td>

                            <td>
                                {{ $portfolio->organisasi ?? '-' }}
                            </td>

                            <td>
                                <a href="{{ route('dosen.portfolio.show', $portfolio->id) }}"
                                   class="btn btn-primary">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" style="text-align: center; padding: 25px;">
                                Belum ada data portfolio mahasiswa.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px;">
            {{ $portfolios->links() }}
        </div>

    </div>

</div>
@endsection