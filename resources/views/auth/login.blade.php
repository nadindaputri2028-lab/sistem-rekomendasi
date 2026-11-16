
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Login - Sistem Rekomendasi Mahasiswa</title>

    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Plus Jakarta Sans', 'sans-serif'],
                    },
                    colors: {
                        brand: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#0284c7',
                            700: '#0066cc',
                            800: '#0052a5',
                            900: '#0f172a',
                        }
                    }
                }
            }
        }
    </script>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .input-box {
            transition: all 0.2s ease-in-out;
        }

        .input-box:focus-within {
            border-color: #0066cc;
            box-shadow: 0 0 0 4px rgba(0, 102, 204, 0.15);
        }
    </style>
</head>

<body>

<div class="bg-slate-50 min-h-screen flex flex-col justify-between overflow-x-hidden text-slate-800 w-full">

    <!-- MAIN CONTAINER -->
    <main class="flex-1 flex flex-col lg:flex-row relative w-full">

        <!-- LEFT COLUMN: LOGIN FORM -->
        <div class="w-full lg:w-[50%] xl:w-[48%] bg-white px-6 sm:px-12 md:px-16 lg:px-16 xl:px-20 py-8 flex flex-col justify-between relative z-20">

            <!-- HEADER BRAND -->
            <div class="flex items-center gap-3.5 mb-8 lg:mb-4">

                <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-blue-600 to-sky-400 flex items-center justify-center shadow-lg shadow-blue-500/20 text-white">
                    <i class="fa-solid fa-graduation-cap text-2xl"></i>
                </div>

                <div class="pl-2 border-l-2 border-slate-300">
                    <h2 class="font-bold text-slate-900 leading-tight text-sm sm:text-base">
                        Sistem
                    </h2>

                    <h2 class="font-bold text-slate-900 leading-tight text-sm sm:text-base">
                        Rekomendasi Mahasiswa
                    </h2>
                </div>

            </div>


            <!-- TITLE -->
            <div class="mb-6 text-center lg:text-left">

                <h1 class="text-3xl sm:text-4xl xl:text-5xl font-extrabold text-[#0a192f] tracking-tight mb-2">
                    Selamat Datang
                </h1>

                <p class="text-slate-500 font-medium text-sm sm:text-base">
                    Masukkan informasi login Anda untuk mengakses portal.
                </p>

            </div>


            <!-- LOGIN CARD -->
            <div class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_15px_40px_-15px_rgba(0,102,204,0.12)] max-w-md mx-auto w-full my-auto">

                <!-- CARD HEADER -->
                <div class="text-center mb-6">

                    <div class="w-16 h-16 rounded-2xl bg-gradient-to-tr from-blue-500 to-sky-400 text-white flex items-center justify-center mx-auto mb-4 shadow-md shadow-blue-400/30">
                        <i class="fa-solid fa-graduation-cap text-3xl"></i>
                    </div>

                    <h3 class="text-xl sm:text-2xl font-bold text-slate-900 mb-1">
                        Masuk ke Sistem
                    </h3>

                    <p class="text-xs sm:text-sm text-slate-500 px-2">
                        Akses akun Mahasiswa dan Staff dalam satu portal.
                    </p>

                </div>


                <!-- PESAN ERROR -->
                @if(session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-600">
                        {{ session('error') }}
                    </div>
                @endif

                @if($errors->any())
                    <div class="mb-4 rounded-lg bg-red-50 border border-red-200 p-3 text-sm text-red-600">
                        {{ $errors->first() }}
                    </div>
                @endif

                <!-- PESAN SUKSES -->
                @if(session('success'))
                    <div class="mb-4 rounded-lg bg-green-50 border border-green-200 p-3 text-sm text-green-600">
                        {{ session('success') }}
                    </div>
                @endif


                <!-- FORM LOGIN -->
              <form method="POST" action="{{ url('/login') }}" class="space-y-4">
                @csrf

                    <!-- USERNAME / EMAIL -->
                    <div class="space-y-1.5 text-left">

                        <label for="username" class="block text-xs sm:text-sm font-semibold text-slate-800">
                            Username / Email
                        </label>

                        <div class="input-box flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-3 text-slate-700">

                            <i class="fa-regular fa-envelope text-slate-400 mr-3 text-base"></i>

                            <input
                                type="text"
                                id="username"
                                name="username"
                                value="{{ old('username') }}"
                                placeholder="Masukkan Username / Email / NIM"
                                required
                                autofocus
                                class="w-full bg-transparent border-none outline-none text-sm text-slate-800 placeholder-slate-400"
                            >

                        </div>

                        @error('username')
                            <span class="text-xs text-red-500 mt-1 block">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- PASSWORD -->
                    <div class="space-y-1.5 text-left">

                        <label for="password" class="block text-xs sm:text-sm font-semibold text-slate-800">
                            Password
                        </label>

                        <div class="input-box flex items-center bg-slate-50 border border-slate-200 rounded-xl px-3.5 py-3 text-slate-700">

                            <i class="fa-solid fa-lock text-slate-400 mr-3 text-base"></i>

                            <input
                                type="password"
                                id="password"
                                name="password"
                                placeholder="Masukkan Password"
                                required
                                class="w-full bg-transparent border-none outline-none text-sm text-slate-800 placeholder-slate-400"
                            >

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="text-slate-400 hover:text-slate-600 focus:outline-none ml-2"
                            >
                                <i id="eyeIcon" class="fa-regular fa-eye-slash text-base"></i>
                            </button>

                        </div>

                        @error('password')
                            <span class="text-xs text-red-500 mt-1 block">
                                {{ $message }}
                            </span>
                        @enderror

                    </div>


                    <!-- SUBMIT BUTTON -->
                    <button
                        type="submit"
                        class="w-full bg-[#0066cc] hover:bg-[#0052a5] active:scale-[0.99] transition-all text-white font-semibold py-3.5 px-4 rounded-xl shadow-lg shadow-blue-600/30 flex items-center justify-center gap-2 text-sm sm:text-base mt-2 cursor-pointer"
                    >
                        <span>Login Sistem</span>
                        <i class="fa-solid fa-arrow-right text-xs"></i>
                    </button>

                </form>


                <!-- DIVIDER -->
                <div class="relative my-5 flex items-center justify-center">

                    <div class="border-t border-slate-200 w-full"></div>

                    <span class="bg-white px-3 text-xs text-slate-400 font-medium absolute">
                        atau
                    </span>

                </div>


                <!-- GOOGLE LOGIN -->
                <a
                    href="{{ route('auth.google') }}"
                    class="w-full bg-white hover:bg-slate-50 border border-slate-200 text-slate-700 font-semibold py-3 px-4 rounded-xl transition-colors flex items-center justify-center gap-3 text-sm no-underline"
                >

                    <svg class="w-4 h-4" viewBox="0 0 24 24">

                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>

                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>

                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>

                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>

                    </svg>

                    <span>Login dengan Google</span>

                </a>

            </div>


            <!-- FOOTER FEATURES -->
            <div class="mt-6 flex flex-wrap items-center justify-center gap-4 sm:gap-6 text-xs sm:text-sm font-semibold text-slate-600">

                <div class="flex items-center gap-1.5">

                    <div class="w-5 h-5 rounded-full bg-blue-100 text-[#0066cc] flex items-center justify-center text-[10px]">
                        <i class="fa-solid fa-check"></i>
                    </div>

                    <span>Single Sign On (SSO)</span>

                </div>

                <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>

                <div class="flex items-center gap-1.5">

                    <i class="fa-solid fa-shield-halved text-[#0066cc] text-xs"></i>

                    <span>Akses Terproteksi</span>

                </div>

                <div class="h-3 w-px bg-slate-300 hidden sm:block"></div>

                <div class="flex items-center gap-1.5">

                    <i class="fa-solid fa-bolt text-[#0066cc] text-xs"></i>

                    <span>Optimized UI/UX</span>

                </div>

            </div>

        </div>


        <!-- RIGHT COLUMN: CAMPUS PHOTO -->
        <div class="w-full lg:w-[50%] xl:w-[52%] relative min-h-[350px] lg:min-h-screen bg-slate-900 overflow-hidden flex items-end">

            <!-- CAMPUS IMAGE -->
            <img
                src="{{ asset('images/Gemini_Generated_Image_t3narqt3narqt3na.jpg') }}"
                alt="Gedung Politeknik Negeri Tanah Laut"
                class="absolute inset-0 w-full h-full object-cover object-center"
            >

            <!-- OVERLAY -->
            <div class="absolute inset-0 bg-gradient-to-r from-white/90 via-transparent to-black/20 lg:block hidden"></div>

            <!-- CURVED DIVIDER -->
            <div class="absolute top-0 bottom-0 left-[-1px] w-48 h-full hidden lg:block pointer-events-none z-10">

                <svg viewBox="0 0 100 100" preserveAspectRatio="none" class="w-full h-full fill-white">

                    <path d="M0,0 L40,0 C70,30 20,70 50,100 L0,100 Z"></path>

                </svg>

            </div>

            <!-- BLUE ACCENT -->
            <div class="absolute top-0 bottom-0 left-0 w-full h-full pointer-events-none opacity-40">

                <svg viewBox="0 0 500 500" preserveAspectRatio="none" class="w-full h-full">

                    <path d="M0,0 C150,90 350,-40 500,100 L500,0 Z" fill="#0066cc" opacity="0.3"></path>

                </svg>

            </div>

        </div>

    </main>


    <!-- FOOTER BAR -->
    <footer class="w-full bg-white border-t border-slate-100 py-3.5 px-6 sm:px-12 flex flex-col sm:flex-row items-center justify-between gap-3 text-xs text-slate-500 font-medium z-30">

        <div>
            &copy; 2026 Sistem Rekomendasi Mahasiswa. Politeknik Negeri Tanah Laut. All rights reserved.
        </div>

        <div class="flex items-center gap-1.5 text-slate-600 font-semibold">

            <i class="fa-solid fa-location-dot text-[#0066cc]"></i>

            <span>Politeknik Negeri Tanah Laut</span>

        </div>

    </footer>

</div>


<!-- JAVASCRIPT -->
<script>

    // Tampilkan / sembunyikan password
    function togglePassword() {

        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        if (passwordInput.type === 'password') {

            passwordInput.type = 'text';

            eyeIcon.classList.remove('fa-eye-slash');
            eyeIcon.classList.add('fa-eye');

        } else {

            passwordInput.type = 'password';

            eyeIcon.classList.remove('fa-eye');
            eyeIcon.classList.add('fa-eye-slash');

        }

    }

</script>

</body>
</html>
