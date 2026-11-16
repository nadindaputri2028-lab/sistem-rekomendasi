
@php
    $role = session('role');
@endphp

<footer class="footer">

    <div class="container footer-grid">

        {{-- TENTANG SISTEM --}}
        <div class="footer-about">

            <div class="brand footer-brand">
                <span class="logo">🎓</span>
                <span>Sistem Rekomendasi Mahasiswa</span>
            </div>

            <p>
                Sistem Rekomendasi Mahasiswa merupakan platform untuk
                membantu mahasiswa menemukan lomba yang sesuai dengan
                kemampuan, minat, dan kriteria yang dimiliki.
            </p>

        </div>

        {{-- QUICK LINKS --}}
        <div class="footer-links">

            <h3>Quick Links</h3>

            <ul>

                {{-- MENU STAFF --}}
                @if($role === 'staff')

                    @if(Route::has('staff.dashboard'))
                        <li>
                            <a href="{{ route('staff.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.mahasiswa.index'))
                        <li>
                            <a href="{{ route('staff.mahasiswa.index') }}">
                                Data Mahasiswa
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.portfolio.index'))
                        <li>
                            <a href="{{ route('staff.portfolio.index') }}">
                                Portfolio Mahasiswa
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.lomba.index'))
                        <li>
                            <a href="{{ route('staff.lomba.index') }}">
                                Data Lomba
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.kriteria.index'))
                        <li>
                            <a href="{{ route('staff.kriteria.index') }}">
                                Kriteria
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.rekomendasi.index'))
                        <li>
                            <a href="{{ route('staff.rekomendasi.index') }}">
                                Rekomendasi
                            </a>
                        </li>
                    @endif

                    @if(Route::has('staff.pendaftaran.index'))
                        <li>
                            <a href="{{ route('staff.pendaftaran.index') }}">
                                Data Pendaftaran
                            </a>
                        </li>
                    @endif

                {{-- MENU MAHASISWA --}}
                @elseif($role === 'mahasiswa')

                    @if(Route::has('mahasiswa.dashboard'))
                        <li>
                            <a href="{{ route('mahasiswa.dashboard') }}">
                                Dashboard
                            </a>
                        </li>
                    @endif

                    @if(Route::has('mahasiswa.profil.show'))
                        <li>
                            <a href="{{ route('mahasiswa.profil.show') }}">
                                Profil Saya
                            </a>
                        </li>
                    @endif

                    @if(Route::has('mahasiswa.portfolio.index'))
                        <li>
                            <a href="{{ route('mahasiswa.portfolio.index') }}">
                                Portfolio Saya
                            </a>
                        </li>
                    @endif

                    @if(Route::has('mahasiswa.lomba.index'))
                        <li>
                            <a href="{{ route('mahasiswa.lomba.index') }}">
                                Daftar Lomba
                            </a>
                        </li>
                    @endif

                    @if(Route::has('mahasiswa.pendaftaran.index'))
                        <li>
                            <a href="{{ route('mahasiswa.pendaftaran.index') }}">
                                Pendaftaran Saya
                            </a>
                        </li>
                    @endif

                    @if(Route::has('mahasiswa.rekomendasi'))
                        <li>
                            <a href="{{ route('mahasiswa.rekomendasi') }}">
                                Rekomendasi Lomba
                            </a>
                        </li>
                    @endif

                {{-- MENU PENGUNJUNG --}}
                @else

                    @if(Route::has('login'))
                        <li>
                            <a href="{{ route('login') }}">
                                Login
                            </a>
                        </li>
                    @endif

                @endif

            </ul>

        </div>

        {{-- KONTAK --}}
        <div class="footer-contact">

            <h3>Contact</h3>

            <p>Politeknik Negeri Tanah Laut</p>

            <p>
                <a href="mailto:mail@politala.ac.id">
                    mail@politala.ac.id
                </a>
            </p>

            <p>
                <a href="tel:+625122021065">
                    (0512) 2021065
                </a>
            </p>

        </div>

    </div>

    {{-- COPYRIGHT --}}
    <div class="footer-bottom">
        <p>
            © {{ date('Y') }} Sistem Rekomendasi Mahasiswa.
            All rights reserved.
        </p>
    </div>

</footer>


<style>

/* =========================================
   FOOTER
========================================= */

.footer {
    width: 100%;
    background: #ffffff;
    border-top: 1px solid #e2e8f0;
    color: #334155;
    font-family: Arial, sans-serif;
}

/* =========================================
   FOOTER GRID
========================================= */

.footer .footer-grid {
    display: grid;
    grid-template-columns: 1.3fr 0.8fr 0.8fr;
    gap: 45px;

    width: 100%;
    max-width: 1000px;

    margin: 0 auto;
    padding: 38px 25px 30px;
}

/* =========================================
   BRAND
========================================= */

.footer .footer-brand {
    display: flex;
    align-items: center;
    gap: 10px;
    margin-bottom: 15px;
    color: #1e3a5f;
    font-size: 16px;
    font-weight: 700;
}

.footer .footer-brand .logo {
    font-size: 20px;
}

/* =========================================
   JUDUL FOOTER
========================================= */

.footer h3 {
    color: #1e3a5f;
    font-size: 14px;
    font-weight: 700;
    margin: 0 0 16px;
}

/* =========================================
   DESKRIPSI
========================================= */

.footer .footer-about p {
    color: #334155;
    font-size: 12px;
    line-height: 1.8;
    margin: 0;
}

/* =========================================
   QUICK LINKS
========================================= */

.footer .footer-links ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.footer .footer-links li {
    margin-bottom: 11px;
}

.footer .footer-links a {
    display: inline-block;
    color: #334155;
    font-size: 12px;
    text-decoration: none;
    transition: 0.2s;
    cursor: pointer;
}

.footer .footer-links a:hover {
    color: #2563eb;
    text-decoration: underline;
    padding-left: 3px;
}

/* =========================================
   KONTAK
========================================= */

.footer .footer-contact p {
    color: #334155;
    font-size: 12px;
    margin: 0 0 14px;
    line-height: 1.6;
}

.footer .footer-contact a {
    color: #334155;
    text-decoration: none;
    transition: 0.2s;
}

.footer .footer-contact a:hover {
    color: #2563eb;
    text-decoration: underline;
}

/* =========================================
   COPYRIGHT
========================================= */

.footer .footer-bottom {
    border-top: 1px solid #e2e8f0;
    text-align: center;
    padding: 15px 20px;
}

.footer .footer-bottom p {
    color: #64748b;
    font-size: 11px;
    margin: 0;
}

/* =========================================
   RESPONSIVE
========================================= */

@media (max-width: 768px) {

    .footer .footer-grid {
        grid-template-columns: 1fr 1fr;
        gap: 28px;
        padding: 30px 25px;
    }

    .footer .footer-about {
        grid-column: 1 / -1;
    }

}

@media (max-width: 480px) {

    .footer .footer-grid {
        grid-template-columns: 1fr;
        gap: 25px;
        padding: 28px 22px;
    }

    .footer .footer-about {
        grid-column: auto;
    }

}

</style>
