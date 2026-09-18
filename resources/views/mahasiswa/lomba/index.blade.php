@extends('layouts.app')
@section('title','Daftar Lomba')
@section('content')
<div class="container"><div class="page-title"><h1>Daftar Lomba</h1><p>Temukan kompetisi akademik dan nonakademik yang sesuai dengan profil Anda.</p></div>
<form class="toolbar" method="GET"><div class="search"><input name="q" value="{{ $q }}" placeholder="🔍 Cari nama lomba atau penyelenggara..."></div><select name="kategori"><option value="">Semua Kategori</option><option value="Akademik" @selected($kategori==='Akademik')>Akademik</option><option value="Nonakademik" @selected($kategori==='Nonakademik')>Nonakademik</option></select><select name="tingkat"><option value="">Semua Tingkat</option><option>Nasional</option><option>Internasional</option><option>Regional</option></select><button class="btn">Filter</button></form>
<div class="cards">@forelse($lombas as $l)<div class="lomba-card"><span class="badge">{{ $l->kategori }}</span><h3>{{ $l->nama }}</h3><div class="meta">▣ Deadline: {{ $l->deadline->format('d M Y') }}<br>⌖ {{ $l->tingkat }} · {{ $l->lokasi ?? 'Online' }}<br>♟ {{ $l->penyelenggara }}</div><a class="btn" href="{{ route('mahasiswa.lomba.show',$l) }}">Lihat Detail ›</a></div>@empty<div class="card empty">Data lomba belum tersedia.</div>@endforelse</div>{{ $lombas->links('layouts.pagination') }}</div>
@endsection
