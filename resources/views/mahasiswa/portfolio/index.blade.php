@extends('layouts.app')
@section('title','Portfolio Saya')
@section('content')
<div class="container"><div class="page-title"><h1>Portfolio Saya</h1><p>Kelola pengalaman, prestasi, dan pengalaman kegiatan Anda untuk mendukung rekomendasi.</p></div>
<div class="section-head"><h2>Pengalaman / Kegiatan</h2><a class="btn" href="{{ route('mahasiswa.portfolio.create') }}">+ Tambah Portfolio</a></div>
<div class="table-card card"><table class="table"><thead><tr><th>KEGIATAN</th><th>POSISI</th><th>INSTITUSI / ORGANISASI</th><th>PERIODE</th><th>AKSI</th></tr></thead><tbody>
@forelse($portfolios as $p)<tr><td><b>{{ $p->nama_kegiatan }}</b><br><small>{{ $p->deskripsi }}</small></td><td>{{ $p->posisi }}</td><td>{{ $p->organisasi }}</td><td>{{ $p->periode_mulai?->format('M Y') }} - {{ $p->periode_selesai?->format('M Y') }}</td><td><div class="actions"><a class="btn small outline" href="{{ route('mahasiswa.portfolio.edit',$p) }}">Edit</a><form method="POST" action="{{ route('mahasiswa.portfolio.destroy',$p) }}">@csrf @method('DELETE')<button class="btn small danger" data-confirm="Hapus portfolio ini?">Hapus</button></form></div></td></tr>@empty<tr><td colspan="5" class="empty">Belum ada portfolio.</td></tr>@endforelse
</tbody></table></div></div>
@endsection
