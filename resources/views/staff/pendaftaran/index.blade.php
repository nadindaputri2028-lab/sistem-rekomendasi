@extends('layouts.app')

@section('title', 'Pendaftaran Lomba')

@section('content')
<div class="container">
    <div class="page-title">
        <h1>Pendaftaran Lomba</h1>
        <p>Kelola pendaftaran mahasiswa dan status seleksi.</p>
    </div>

    <div class="table-card card">
        <table class="table">
            <thead>
                <tr>
                    <th>MAHASISWA</th>
                    <th>LOMBA</th>
                    <th>TANGGAL</th>
                    <th>STATUS</th>
                    <th>CATATAN</th>
                    <th>AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($pendaftarans as $p)
                    <tr>
                        <!-- 1. Kolom Mahasiswa -->
                        <td>
                            <b>{{ $p->mahasiswa->nama_lengkap }}</b><br>
                            <small class="text-muted">{{ $p->mahasiswa->nim }}</small>
                        </td>

                        <!-- 2. Kolom Lomba -->
                        <td>{{ $p->lomba->nama }}</td>

                        <!-- 3. Kolom Tanggal -->
                        <td>{{ $p->tanggal_daftar->format('d M Y') }}</td>

                        <!-- 4. Kolom Status -->
                        <td>{{ $p->status }}</td>

                        <!-- 5. Kolom Catatan -->
                        <td>{{ $p->catatan ?? '-' }}</td>

                        <!-- 6. Kolom Aksi -->
                        <td>
                            <a href="{{ route('staff.pendaftaran.edit', $p) }}" class="btn small">
                                Edit
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="empty">Belum ada pendaftaran.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $pendaftarans->links('layouts.pagination') }}
    </div>
</div>
@endsection