@php

    $role = session('role');

    $mahasiswa = null;

    if ($role === 'mahasiswa') {

        $mahasiswa = \App\Models\Mahasiswa::where(
            'user_id',
            session('user_id')
        )->first();

    }

@endphp


<header class="navbar">

    <div class="container nav-inner">


        {{-- LOGO --}}

        @if($role === 'staff')

            <a
                class="brand"
                href="{{ route('staff.dashboard') }}"
            >

        @elseif($role === 'mahasiswa')

            <a
                class="brand"
                href="{{ route('mahasiswa.dashboard') }}"
            >

        @else

            <a
                class="brand"
                href="{{ route('home') }}"
            >

        @endif


            <span class="logo">🎓</span>

            <span>
                Sistem<br>
                <b>Rekomendasi<br>Mahasiswa</b>
            </span>

        </a>


        {{-- MENU --}}

        <nav>

            @if($role === 'staff')

                <a href="{{ route('staff.dashboard') }}">
                    Dashboard
                </a>

                <a href="{{ route('staff.mahasiswa.index') }}">
                    Data Mahasiswa
                </a>

                <a href="{{ route('staff.kriteria.index') }}">
                    Kriteria
                </a>

                <a href="{{ route('staff.lomba.index') }}">
                    Data Lomba
                </a>

                <a href="{{ route('staff.rekomendasi.index') }}">
                    Rekomendasi
                </a>

                <a href="{{ route('staff.pendaftaran.index') }}">
                    Pendaftaran
                </a>


            @elseif($role === 'mahasiswa')

                <a href="{{ route('mahasiswa.dashboard') }}">
                    Beranda
                </a>

                <a href="{{ route('mahasiswa.profil') }}">
                    Data Mahasiswa
                </a>

                <a href="{{ route('mahasiswa.portfolio.index') }}">
                    Portfolio
                </a>

                <a href="{{ route('mahasiswa.lomba.index') }}">
                    Data Lomba
                </a>

                <a href="{{ route('mahasiswa.rekomendasi') }}">
                    Rekomendasi
                </a>

                <a href="{{ route('mahasiswa.pendaftaran.index') }}">
                    Pendaftaran
                </a>


            @else
    {{-- Tidak menampilkan menu saat belum login --}}
@endif

        </nav>


        {{-- USER --}}

        @if($role)

            <div class="user-area">

                <span class="bell">
                    🔔
                </span>


                <span class="user-name">

                    @if($role === 'mahasiswa')

                        {{ $mahasiswa?->nama_lengkap }}

                    @else

                        Staff Admin

                    @endif

                </span>


                <form
                    method="POST"
                    action="{{ route('logout') }}"
                >

                    @csrf

                    <button
                        type="submit"
                        class="btn small"
                    >
                        Logout
                    </button>

                </form>

            </div>

        @endif


    </div>

</header>