@extends('layouts.app')

@section('title', 'Login')

@section('content')
<div class="login-wrapper">
    <div class="hero">
        <h1>Selamat Datang</h1>
        <p>Masukkan informasi login Anda untuk mengakses portal.</p>
    </div>

    <div class="login-card-single">
        <div class="login-icon">🎓</div>
        <h3>Masuk ke Sistem</h3>
        <p>Akses akun Mahasiswa dan Staff dalam satu portal.</p>

        <form method="POST" action="{{ route('login') }}" class="login-form">
            @csrf

            <div class="form-group">
                <label for="username">Username / Email</label>
                <input 
                    type="text" 
                    id="username" 
                    name="username" 
                    placeholder="Masukkan Username / Email" 
                    required 
                    autofocus
                >
            </div>

            <div class="form-group">
                <label for="password">Password</label>
                <input 
                    type="password" 
                    id="password" 
                    name="password" 
                    placeholder="Masukkan Password" 
                    required
                >
            </div>

            <button type="submit" class="btn-primary">
                Login Sistem
            </button>
        </form>
    </div>

<div style="text-align: center; margin: 15px 0; color: #999;">
    atau
</div>

<a href="{{ route('auth.google') }}"
   style="
       display: flex;
       align-items: center;
       justify-content: center;
       gap: 10px;
       width: 100%;
       padding: 12px;
       background: #ffffff;
       color: #333333;
       border: 1px solid #d1d5db;
       border-radius: 8px;
       text-decoration: none;
       font-weight: 600;
       box-sizing: border-box;
   ">
    <span style="font-weight: bold; font-size: 18px;">G</span>
    Login dengan Google
</a>


    <div class="features">
        ◉ Single Sign On (SSO) &nbsp;&nbsp; 
        ◉ Akses Terproteksi &nbsp;&nbsp; 
        ◉ Optimized UI/UX
    </div>
</div>

<style>
    .login-wrapper {
        max-width: 460px;
        margin: 40px auto;
        padding: 0 16px;
        text-align: center;
    }

    .hero h1 {
        font-size: 28px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 8px;
    }

    .hero p {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 28px;
    }

    .login-card-single {
        background: #ffffff;
        padding: 32px 28px;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.05), 0 8px 10px -6px rgba(0, 0, 0, 0.01);
        border: 1px solid #f1f5f9;
    }

    .login-icon {
        width: 52px;
        height: 52px;
        background-color: #eff6ff;
        border-radius: 12px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        margin: 0 auto 16px auto;
    }

    .login-card-single h3 {
        font-size: 20px;
        font-weight: 700;
        color: #0f172a;
        margin-bottom: 6px;
    }

    .login-card-single p {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 24px;
        line-height: 1.5;
    }

    .login-form {
        text-align: left;
    }

    .form-group {
        margin-bottom: 18px;
    }

    .form-group label {
        display: block;
        font-size: 13px;
        font-weight: 600;
        color: #334155;
        margin-bottom: 6px;
    }

    .form-group input {
        width: 100%;
        padding: 10px 14px;
        border: 1px solid #cbd5e1;
        border-radius: 8px;
        font-size: 14px;
        color: #1e293b;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
    }

    .form-group input:focus {
        border-color: #0284c7;
        box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
    }

    .btn-primary {
        width: 100%;
        padding: 12px;
        background-color: #0284c7;
        color: #ffffff;
        border: none;
        border-radius: 8px;
        font-size: 15px;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.2s;
        margin-top: 8px;
    }

    .btn-primary:hover {
        background-color: #0369a1;
    }

    .features {
        margin-top: 32px;
        font-size: 12px;
        color: #94a3b8;
    }
</style>
@endsection