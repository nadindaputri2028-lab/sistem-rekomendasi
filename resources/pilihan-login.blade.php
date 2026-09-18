@extends('layouts.app')
@section('title','Beranda')
@section('content')
<section class="hero"><h1>Selamat Datang</h1><p>Silakan pilih jenis akun untuk masuk ke dalam sistem.</p></section>
<div class="login-grid">
<div class="login-card"><div class="login-icon">🎓</div><h3>Mahasiswa</h3><p>Login untuk melihat profil, portfolio, lomba, rekomendasi, dan pendaftaran Anda secara mandiri.</p><a class="btn" href="{{ route('login.mahasiswa') }}">Login Mahasiswa</a></div>
<div class="login-card"><div class="login-icon">👤</div><h3>Staff / Admin</h3><p>Login untuk mengelola data mahasiswa, informasi lomba, validasi portfolio, dan hasil rekomendasi.</p><a class="btn outline" href="{{ route('login.staff') }}">Login Staff</a></div>
</div>
<div class="features">◉ Single Sign On (SSO) &nbsp;&nbsp; ◉ Akses Terproteksi &nbsp;&nbsp; ◉ Optimized UI/UX</div>
@endsection
