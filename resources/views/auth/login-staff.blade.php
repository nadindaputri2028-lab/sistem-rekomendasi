@extends('layouts.app')
@section('title','Login Staff')
@section('content')
<div class="form-wrap"><div class="form-card card"><div class="login-icon">👤</div><h2>Login Staff / Admin</h2><p class="sub">Gunakan Username atau Email Resmi</p>
<form method="POST" action="{{ route('login.staff.process') }}">@csrf
<div class="field"><label>Username / Email</label><input name="login" value="{{ old('login') }}" required></div>
<div class="field"><label>Password</label><input type="password" name="password" required></div>
<div style="text-align:right;margin:8px 0 14px"><small style="color:#075eb8">Lupa Password?</small></div>
<button class="btn outline" style="width:100%">Login Staff</button>
</form><p style="text-align:center;margin:18px 0 0;font-size:10px"><a href="{{ route('login') }}">← Kembali ke Pilihan Login</a></p>
</div></div>
@endsection
