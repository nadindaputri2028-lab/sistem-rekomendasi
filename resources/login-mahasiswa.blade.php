@extends('layouts.app')

@section('title', 'Login Mahasiswa')

@section('content')

<div class="container">

    <div class="login-card">

        {{-- Icon --}}
        <div class="login-icon">
            🎓
        </div>

        {{-- Judul --}}
        <h1>Login Mahasiswa</h1>

        <p class="login-subtitle">
            Gunakan NIM atau Email Kampus Anda
        </p>


        {{-- Pesan Error --}}
        @if(session('error'))
            <div class="alert error">
                {{ session('error') }}
            </div>
        @endif


        {{-- Pesan Success --}}
        @if(session('success'))
            <div class="alert success">
                {{ session('success') }}
            </div>
        @endif


        {{-- Form Login --}}
        <form
            method="POST"
            action="{{ route('login.mahasiswa.process') }}"
        >

            @csrf


            {{-- NIM / EMAIL --}}
            <div class="form-group">

                <label for="login">
                    NIM / Email
                </label>

                <input
                    type="text"
                    id="login"
                    name="login"
                    value="{{ old('login') }}"
                    autocomplete="username"
                    required
                >

                @error('login')
                    <small class="error-text">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- PASSWORD --}}
            <div class="form-group">

                <label for="password">
                    Password
                </label>

                <div class="password-box">

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
                        onclick="togglePasswordVisibility()"
                        aria-label="Lihat password"
                        title="Lihat password"
                    >

                        <svg
                            id="eyeOpen"
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                        >

                            <path
                                d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7S2 12 2 12z"
                            />

                            <circle
                                cx="12"
                                cy="12"
                                r="3"
                            />

                        </svg>


                        <svg
                            id="eyeClosed"
                            xmlns="http://www.w3.org/2000/svg"
                            width="22"
                            height="22"
                            viewBox="0 0 24 24"
                            fill="none"
                            stroke="currentColor"
                            stroke-width="2"
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            style="display: none;"
                        >

                            <path d="M3 3l18 18" />

                            <path
                                d="M10.6 10.6a2 2 0 0 0 2.8 2.8"
                            />

                            <path
                                d="M9.9 4.2A10.6 10.6 0 0 1 12 4c6.5 0 10 8 10 8a18.4 18.4 0 0 1-3.1 4.5"
                            />

                            <path
                                d="M6.6 6.6C3.7 8.6 2 12 2 12s3.5 8 10 8a10.8 10.8 0 0 0 4.4-.9"
                            />

                        </svg>

                    </button>

                </div>


                @error('password')
                    <small class="error-text">
                        {{ $message }}
                    </small>
                @enderror

            </div>


            {{-- Lupa Password --}}
            <div class="forgot-password">
                <span>Lupa Password?</span>
            </div>


            {{-- Tombol Login --}}
            <button
                type="submit"
                class="btn-login"
            >
                Login Mahasiswa
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

/* =====================================================
   LOGIN CARD
===================================================== */

.login-card {

    max-width: 520px;

    margin: 30px auto;

    padding: 42px;

    background: #ffffff;

    border: 1px solid #e5eaf0;

    border-radius: 18px;

    box-shadow:
        0 8px 25px rgba(0, 0, 0, 0.04);
}


/* =====================================================
   ICON LOGIN
===================================================== */

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


/* =====================================================
   JUDUL
===================================================== */

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


/* =====================================================
   FORM
===================================================== */

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


.form-group > input {

    width: 100%;

    box-sizing: border-box;

    padding: 15px;

    border: 1px solid #e5eaf0;

    border-radius: 10px;

    background: #ffffff;

    color: #172033;

    font-size: 15px;

    outline: none;

    transition:
        border-color 0.2s,
        box-shadow 0.2s;
}


.form-group > input:focus {

    border-color: #075eb8;

    box-shadow:
        0 0 0 3px rgba(7, 94, 184, 0.10);
}


/* =====================================================
   PASSWORD
===================================================== */

.password-box {

    position: relative;

    width: 100%;
}


.password-box input {

    width: 100% !important;

    height: 50px;

    box-sizing: border-box;

    padding: 15px 58px 15px 15px !important;

    border: 1px solid #e5eaf0 !important;

    border-radius: 10px !important;

    background: #ffffff !important;

    color: #172033 !important;

    font-size: 15px;

    outline: none;

}


.password-box input:focus {

    border-color: #075eb8 !important;

    box-shadow:
        0 0 0 3px rgba(7, 94, 184, 0.10);
}


/* =====================================================
   TOMBOL MATA
===================================================== */

#togglePassword {

    position: absolute !important;

    right: 8px !important;

    top: 50% !important;

    transform: translateY(-50%) !important;

    width: 42px !important;

    height: 42px !important;

    padding: 0 !important;

    margin: 0 !important;

    display: flex !important;

    align-items: center !important;

    justify-content: center !important;

    border: none !important;

    border-radius: 8px !important;

    background: transparent !important;

    color: #64748b !important;

    cursor: pointer !important;

    z-index: 9999 !important;

    box-shadow: none !important;
}


#togglePassword:hover {

    background: #edf5ff !important;

    color: #075eb8 !important;
}


#togglePassword:focus {

    outline: none !important;

    background: #edf5ff !important;

    color: #075eb8 !important;
}


#togglePassword svg {

    display: block;

    width: 22px;

    height: 22px;

    pointer-events: none;
}


/* =====================================================
   LUPA PASSWORD
===================================================== */

.forgot-password {

    text-align: right;

    margin-top: -5px;

    margin-bottom: 22px;

    font-size: 14px;
}


.forgot-password span {

    color: #075eb8;
}


/* =====================================================
   TOMBOL LOGIN
===================================================== */

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


/* =====================================================
   KEMBALI
===================================================== */

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


/* =====================================================
   ERROR
===================================================== */

.error-text {

    display: block;

    margin-top: 5px;

    color: #dc2626;

    font-size: 13px;
}

</style>



<script>

/*
|--------------------------------------------------------------------------
| FITUR LIHAT / SEMBUNYIKAN PASSWORD
|--------------------------------------------------------------------------
*/

function togglePasswordVisibility() {

    const password =
        document.getElementById('password');

    const eyeOpen =
        document.getElementById('eyeOpen');

    const eyeClosed =
        document.getElementById('eyeClosed');

    const button =
        document.getElementById('togglePassword');


    if (!password) {
        return;
    }


    if (password.type === 'password') {

        /* Tampilkan password */

        password.type = 'text';


        /* Sembunyikan icon mata terbuka */

        if (eyeOpen) {
            eyeOpen.style.display = 'none';
        }


        /* Tampilkan icon mata dicoret */

        if (eyeClosed) {
            eyeClosed.style.display = 'block';
        }


        button.setAttribute(
            'aria-label',
            'Sembunyikan password'
        );

        button.setAttribute(
            'title',
            'Sembunyikan password'
        );


    } else {

        /* Sembunyikan password */

        password.type = 'password';


        /* Tampilkan icon mata terbuka */

        if (eyeOpen) {
            eyeOpen.style.display = 'block';
        }


        /* Sembunyikan icon mata dicoret */

        if (eyeClosed) {
            eyeClosed.style.display = 'none';
        }


        button.setAttribute(
            'aria-label',
            'Lihat password'
        );

        button.setAttribute(
            'title',
            'Lihat password'
        );

    }

}

</script>

@endsection