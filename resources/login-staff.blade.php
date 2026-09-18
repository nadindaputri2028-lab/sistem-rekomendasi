@extends('layouts.app')

@section('title', 'Login Staff')

@section('content')

<div class="container">

    <div class="login-card">

        {{-- Icon --}}
        <div class="login-icon">
            👤
        </div>

        {{-- Judul --}}
        <h1>Login Staff / Admin</h1>

        <p class="login-subtitle">
            Masuk untuk mengelola data sistem
        </p>

        {{-- Pesan error --}}
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif

        {{-- Pesan sukses --}}
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Form Login --}}
        <form
            method="POST"
            action="{{ route('login.staff.process') }}"
        >

            @csrf

            {{-- Email --}}
            <div class="form-group">

                <label for="email">
                    Email
                </label>

                <input
                    type="email"
                    id="email"
                    name="email"
                    value="{{ old('email') }}"
                    autocomplete="username"
                    required
                >

                @error('email')
                    <small class="error-text">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Password --}}
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="password-wrapper">

                    <input
                        type="password"
                        id="password"
                        name="password"
                        autocomplete="current-password"
                        required
                    >

                    <button
                        type="button"
                        id="togglePassword"
                        class="password-toggle"
                        aria-label="Lihat password"
                    >
                        👁
                    </button>

                </div>

                @error('password')
                    <small class="error-text">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Tombol Login --}}
            <button
                type="submit"
                class="btn-login"
            >
                Login Staff
            </button>

        </form>


        {{-- Kembali --}}
        <div class="back-login">

            <a href="{{ route('login') }}">
                ← Kembali ke Pilihan Login
            </a>

        </div>

    </div>

</div>


<style>

    .login-card {
        max-width: 520px;
        margin: 30px auto;
        padding: 42px;
        background: #ffffff;
        border: 1px solid #e5eaf0;
        border-radius: 18px;
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
    }

    .login-icon {
        width: 64px;
        height: 64px;
        margin: 0 auto 25px;

        display: flex;
        align-items: center;
        justify-content: center;

        background: #edf5ff;
        border-radius: 14px;

        font-size: 30px;
    }

    .login-card h1 {
        margin: 0;
        text-align: center;

        color: #172033;
        font-size: 30px;
        font-weight: 700;
    }

    .login-subtitle {
        margin: 12px 0 30px;

        text-align: center;
        color: #718096;
        font-size: 16px;
    }

    .form-group {
        margin-bottom: 22px;
    }

    .form-group label {
        display: block;
        margin-bottom: 9px;

        color: #172033;
        font-size: 16px;
        font-weight: 600;
    }

    .form-group input {
        width: 100%;
        box-sizing: border-box;

        padding: 15px;

        border: 1px solid #e5eaf0;
        border-radius: 10px;

        background: #ffffff;

        color: #172033;
        font-size: 15px;

        outline: none;

        transition: border-color 0.2s,
                    box-shadow 0.2s;
    }

    .form-group input:focus {
        border-color: #075eb8;

        box-shadow: 0 0 0 3px rgba(7, 94, 184, 0.10);
    }


    /* Password */

    .password-wrapper {
        position: relative;
        width: 100%;
    }

    .password-wrapper input {
        padding-right: 52px;
    }

    .password-toggle {
        position: absolute;

        right: 10px;
        top: 50%;

        transform: translateY(-50%);

        width: 38px;
        height: 38px;

        display: flex;
        align-items: center;
        justify-content: center;

        border: none;
        background: transparent;

        color: #64748b;

        cursor: pointer;

        font-size: 18px;

        border-radius: 8px;
    }

    .password-toggle:hover {
        background: #edf5ff;
        color: #075eb8;
    }


    /* Tombol Login */

    .btn-login {
        width: 100%;

        padding: 14px;

        border: none;
        border-radius: 8px;

        background: #075eb8;
        color: white;

        font-size: 16px;
        font-weight: 700;

        cursor: pointer;

        transition: background 0.2s;
    }

    .btn-login:hover {
        background: #064d96;
    }


    /* Kembali */

    .back-login {
        margin-top: 25px;
        text-align: center;
    }

    .back-login a {
        color: #172033;
        text-decoration: none;
        font-size: 15px;
    }

    .back-login a:hover {
        color: #075eb8;
    }


    /* Error */

    .error-text {
        display: block;
        margin-top: 5px;
        color: #dc2626;
        font-size: 13px;
    }

</style>


<script>

    document.addEventListener('DOMContentLoaded', function () {

        const password =
            document.getElementById('password');

        const togglePassword =
            document.getElementById('togglePassword');


        if (password && togglePassword) {

            togglePassword.addEventListener(
                'click',
                function () {

                    if (password.type === 'password') {

                        password.type = 'text';

                        togglePassword.textContent = '🙈';

                        togglePassword.setAttribute(
                            'aria-label',
                            'Sembunyikan password'
                        );

                    } else {

                        password.type = 'password';

                        togglePassword.textContent = '👁';

                        togglePassword.setAttribute(
                            'aria-label',
                            'Lihat password'
                        );

                    }

                }
            );

        }

    });

</script>

@endsection