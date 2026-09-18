@extends('layouts.app')
@section('title','Rekomendasi Lomba')
@section('content')
<div class="container"><div class="page-title"><h1>Rekomendasi Lomba</h1><p>Daftar lomba yang dapat Anda pertimbangkan berdasarkan profil, prestasi, keahlian, minat, dan pengalaman.</p></div>
<div class="cards">@forelse($lombas as $l)<div class="lomba-card"><span class="badge green">REKOMENDASI</span><h3>{{ $l->nama }}</h3><div class="meta">Kategori: {{ $l->kategori }}<br>Deadline: {{ $l->deadline->format('d M Y') }}<br>Tingkat: {{ $l->tingkat ?? '-' }}<br>Lokasi: {{ $l->lokasi ?? 'Online' }}</div><a class="btn" href="{{ route('mahasiswa.lomba.show',$l) }}">Lihat Detail</a></div>@empty<div class="card empty">Belum ada lomba yang dapat direkomendasikan.</div>@endforelse</div></div>
@endsection
