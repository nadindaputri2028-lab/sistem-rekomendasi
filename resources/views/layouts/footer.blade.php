@php
    $role = session('role');
@endphp

<footer class="footer">

    <div class="container footer-grid">

        {{-- Tentang Sistem --}}
        <div>

            <div class="brand footer-brand">

                <span class="logo">🎓</span>

                <span>
                    Sistem<br>
                    <b>Rekomendasi<br>Mahasiswa</b>
                </span>

            </div>

            <p>
                Platform digital untuk membantu mahasiswa menemukan
                kompetisi yang sesuai dengan minat dan bakat berdasarkan
                profil, prestasi, dan portofolio.
            </p>

        </div>


        {{-- Tautan Cepat --}}
        <div>

            <h4>Tautan Cepat</h4>

            <a href="{{ route('home') }}">
                Beranda
            </a>


            @if($role === 'staff')

                <a href="{{ route('staff.mahasiswa.index') }}">
                    Data Mahasiswa
                </a>

                <a href="{{ route('staff.lomba.index') }}">
                    Data Lomba
                </a>

                <a href="{{ route('staff.rekomendasi.index') }}">
                    Rekomendasi
                </a>


            @elseif($role === 'mahasiswa')

                <!-- KODE BARU -->
                <a href="{{ route('mahasiswa.profil.show') }}">
                    Profil
                </a>

                <a href="{{ route('mahasiswa.lomba.index') }}">
                    Data Lomba
                </a>

                <a href="{{ route('mahasiswa.rekomendasi') }}">
                    Rekomendasi
                </a>


            @else

                <a href="{{ route('login') }}">
                    Data Mahasiswa
                </a>

                <a href="{{ route('login') }}">
                    Data Lomba
                </a>

                <a href="{{ route('login') }}">
                    Rekomendasi
                </a>

            @endif

        </div>


        {{-- Kontak --}}
        <div>

            <h4>Kontak</h4>

            <p>
                📍 Politeknik Negeri Tanah Laut
            </p>

            <p>
                ✉ mail@politala.ac.id
            </p>

            <p>
                ☎ (0512) 2021065
            </p>

        </div>


        {{-- Newsletter --}}
        <div>

            <h4>Newsletter</h4>

            <p>
                Dapatkan update info lomba terbaru.
            </p>

            <div class="newsletter">

                <input
                    type="email"
                    placeholder="Email Anda"
                >

                <button type="button">
                    ➤
                </button>

            </div>

        </div>

    </div>


    {{-- Copyright --}}
    <div class="container copyright">

        © 2026 Sistem Rekomendasi Mahasiswa.
        All rights reserved.

    </div>

</footer>