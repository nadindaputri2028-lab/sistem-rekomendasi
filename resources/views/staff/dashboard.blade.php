@extends('layouts.app')
@section('title','Dashboard Staff')
@section('content')
<div class="container"><div class="page-title"><h1>Dashboard Staff</h1><p>Selamat datang kembali, berikut adalah ringkasan data operasional sistem hari ini.</p></div>
<div class="stats"><div class="stat">👥<small>Total Mahasiswa</small><strong>{{ number_format($totalMahasiswa) }}</strong></div><div class="stat">💼<small>Total Portfolio</small><strong>{{ number_format($totalPortfolio) }}</strong></div><div class="stat">🏆<small>Total Lomba</small><strong>{{ number_format($totalLomba) }}</strong></div><div class="stat">📝<small>Total Pendaftaran</small><strong>{{ number_format($totalPendaftaran) }}</strong></div></div>
<div class="section-head"><h2>Aktivitas Terbaru</h2></div><div class="table-card card"><table class="table"><thead><tr><th>AKTIVITAS</th><th>MAHASISWA</th><th>LOMBA</th><th>WAKTU</th><th>STATUS</th></tr></thead><tbody>@forelse($terbaru as $p)<tr><td>Pendaftaran Lomba</td><td>{{ $p->mahasiswa->nama_lengkap }}</td><td>{{ $p->lomba->nama }}</td><td>{{ $p->created_at->diffForHumans() }}</td><td><span class="badge orange">{{ $p->status }}</span></td></tr>@empty<tr><td colspan="5" class="empty">Belum ada aktivitas.</td></tr>@endforelse</tbody></table></div></div>
@endsection
