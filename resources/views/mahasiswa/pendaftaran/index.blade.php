@extends('layouts.app')
@section('title','Pendaftaran')
@section('content')
<div class="container"><div class="page-title"><h1>Pendaftaran Lomba</h1><p>Riwayat pendaftaran dan status seleksi Anda.</p></div><div class="table-card card"><table class="table"><thead><tr><th>LOMBA</th><th>TANGGAL DAFTAR</th><th>STATUS</th><th>CATATAN</th></tr></thead><tbody>@forelse($pendaftarans as $p)<tr><td><b>{{ $p->lomba->nama }}</b><br>{{ $p->lomba->kategori }}</td><td>{{ $p->tanggal_daftar->format('d M Y') }}</td><td><span class="badge {{ $p->status==='Diterima'?'green':($p->status==='Ditolak'?'red':'orange') }}">{{ $p->status }}</span></td><td>{{ $p->catatan ?: '-' }}</td></tr>@empty<tr><td colspan="4" class="empty">Belum ada pendaftaran.</td></tr>@endforelse</tbody></table>{{ $pendaftarans->links('layouts.pagination') }}</div></div>
@endsection
