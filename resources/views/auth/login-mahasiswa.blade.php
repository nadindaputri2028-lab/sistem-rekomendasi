@extends('layouts.app')
@section('title','Login Mahasiswa')
@section('content')
<div class="form-wrap"><div class="form-card card"><div class="login-icon">🎓</div><h2>Login Mahasiswa</h2><p class="sub">Gunakan NIM atau Email Kampus Anda</p>
<form method="POST" action="{{ route('login.mahasiswa.process') }}">@csrf
<div class="field"><label>NIM / Email</label><input name="login" value="{{ old('login') }}" required></div>
<div class="field"><label>Password</label><input type="password" name="password" required></div>
<div style="text-align:right;margin:8px 0 14px"><small style="color:#075eb8">Lupa Password?</small></div>
<button class="btn" style="width:100%">Login Mahasiswa</button>
</form><p style="text-align:center;margin:18px 0 0;font-size:10px"><a href="{{ route('login') }}">← Kembali ke Pilihan Login</a></p>
</div></div>
@endsection
