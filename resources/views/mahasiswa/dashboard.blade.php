@extends('layouts.app')
@section('title','Dashboard Mahasiswa')
@section('content')
<div class="container">
<div class="page-title"><h1>Selamat Datang, {{ $m->nama_lengkap }} 👋</h1><p>Berikut adalah ringkasan informasi akademik dan rekomendasi lomba untuk Anda.</p></div>
<div class="stats">
<div class="stat"><span class="ico">⭐</span><small>IPK Terakhir</small><strong>{{ number_format($m->ipk ?? 0,2) }}</strong></div>
<div class="stat"><span class="ico">▱</span><small>IPS Semester Ini</small><strong>{{ number_format($m->ips ?? 0,2) }}</strong></div>
<div class="stat"><span class="ico">💼</span><small>Jumlah Portfolio</small><strong>{{ $m->portfolios->count() }}</strong></div>
<div class="stat"><span class="ico">📝</span><small>Jumlah Pendaftaran</small><strong>{{ $pendaftaran }}</strong></div>
</div>
<div class="section-head"><h2>◉ Rekomendasi Lomba</h2><a href="{{ route('mahasiswa.rekomendasi') }}" style="color:#075eb8;font-size:10px">Lihat Semua Lomba ›</a></div>
<div class="cards">
@forelse($lombas as $l)
<div class="lomba-card"><span class="badge">{{ strtoupper($l->kategori) }}</span><h3>{{ $l->nama }}</h3><div class="meta">▣ Deadline: {{ $l->deadline->format('d M Y') }}<br>⌖ {{ $l->lokasi ?? 'Online' }}<br>♟ {{ $l->penyelenggara }}</div><a class="btn" href="{{ route('mahasiswa.lomba.show',$l) }}">Lihat Detail</a></div>
@empty <div class="card empty">Belum ada lomba aktif.</div>@endforelse
</div></div>
@endsection
