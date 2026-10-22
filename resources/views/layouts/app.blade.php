@php
    $role = session('role');

    $mahasiswa = null;

    if ($role === 'mahasiswa') {
        $mahasiswa = \App\Models\Mahasiswa::where(
            'user_id',
            session('user_id')
        )->first();
    }

    $unreadNotifications = 0;

    if (session('user_id')) {
        $unreadNotifications = \App\Models\Notification::where(
            'user_id',
            session('user_id')
        )
        ->where('is_read', false)
        ->count();
    }
@endphp

<!DOCTYPE html>
<html lang="id">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>
        @yield('title', 'Sistem Rekomendasi Mahasiswa')
    </title>

    <link
        rel="stylesheet"
        href="{{ asset('css/app.css') }}"
    >

    <style>

        /* =====================================================
           DASAR
        ===================================================== */

        * {
            box-sizing: border-box;
        }

        html,
        body {
            margin: 0;
            padding: 0;

            overflow-x: hidden;
        }

        body {
            background: #f8fafc;

            color: #172033;

            font-family:
                Arial,
                Helvetica,
                sans-serif;
        }


        /* =====================================================
           SIDEBAR STAFF
        ===================================================== */

        .sidebar-staff {

            position: fixed;

            top: 0;
            left: 0;

            width: 265px;
            height: 100vh;

            background: #0f2942;

            color: white;

            z-index: 9999;

            display: flex;
            flex-direction: column;

            overflow: hidden;

            box-shadow:
                6px 0 25px
                rgba(15, 41, 66, 0.18);

            transition:
                left 0.28s ease;
        }


        /* =====================================================
           SIDEBAR HEADER
        ===================================================== */

        .sidebar-header {

            height: 82px;

            padding: 0 18px;

            display: flex;

            align-items: center;

            border-bottom:
                1px solid
                rgba(255,255,255,0.08);

            flex-shrink: 0;
        }


        .sidebar-brand {

            display: flex;

            align-items: center;

            gap: 12px;

            color: white;

            text-decoration: none;

            min-width: 0;
        }


        /* =====================================================
           LOGO
        ===================================================== */

        .sidebar-logo {

            width: 42px;
            height: 42px;

            border-radius: 11px;

            background: #075eb8;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            flex-shrink: 0;

            box-shadow:
                0 5px 15px
                rgba(7,94,184,0.30);
        }


        .sidebar-logo svg {

            width: 23px;
            height: 23px;

            display: block;
        }


        .sidebar-brand-text {

            display: flex;

            flex-direction: column;

            min-width: 0;

            line-height: 1.15;
        }


        .sidebar-brand-text strong {

            font-size: 12px;

            font-weight: 700;

            letter-spacing: 0.2px;

            color: white;

            white-space: nowrap;
        }


        .sidebar-brand-text span {

            margin-top: 4px;

            font-size: 10px;

            color: #91a9bd;
        }


        /* =====================================================
           CLOSE BUTTON
        ===================================================== */

        .sidebar-header .close-btn {

            display: none;

            margin-left: auto;

            width: 32px;
            height: 32px;

            border: none;

            border-radius: 8px;

            background: transparent;

            color: #cbd5e1;

            font-size: 23px;

            cursor: pointer;

            align-items: center;

            justify-content: center;
        }


        .sidebar-header .close-btn:hover {

            background:
                rgba(255,255,255,0.08);

            color: white;
        }


        /* =====================================================
           SIDEBAR NAVIGATION
        ===================================================== */

        .sidebar-nav {

            display: flex;

            flex-direction: column;

            gap: 5px;

            padding: 22px 13px;

            flex: 1;

            overflow-y: auto;

            overflow-x: hidden;
        }


        /* JUDUL MENU */

        .sidebar-section-title {

            padding:
                0 13px;

            margin:
                2px 0 10px;

            color: #718aa2;

            font-size: 10px;

            font-weight: 700;

            letter-spacing: 1px;

            text-transform: uppercase;
        }


        /* LINK MENU */

        .sidebar-nav a {

            position: relative;

            min-height: 46px;

            padding:
                0 13px;

            border-radius: 10px;

            display: flex;

            align-items: center;

            gap: 13px;

            color: #cbd5e1;

            text-decoration: none;

            font-size: 13px;

            font-weight: 500;

            transition:
                background 0.2s ease,
                color 0.2s ease,
                transform 0.2s ease;
        }


        /* HOVER */

        .sidebar-nav a:hover {

            background:
                rgba(255,255,255,0.08);

            color: white;

            transform:
                translateX(2px);
        }


        /* ACTIVE */

        .sidebar-nav a.active {

            background: #075eb8;

            color: white;

            box-shadow:
                0 5px 14px
                rgba(7,94,184,0.25);
        }


        /* GARIS KIRI MENU AKTIF */

        .sidebar-nav a.active::before {

            content: "";

            position: absolute;

            left: 0;

            top: 9px;

            bottom: 9px;

            width: 3px;

            background: white;

            border-radius:
                0 4px 4px 0;
        }


        /* =====================================================
           ICON MENU SVG
        ===================================================== */

        .menu-icon {

            width: 22px;
            height: 22px;

            display: flex;

            align-items: center;

            justify-content: center;

            color: currentColor;

            flex-shrink: 0;

            opacity: 0.9;
        }


        .menu-icon svg {

            width: 19px;
            height: 19px;

            display: block;
        }


        .sidebar-nav a:hover .menu-icon,
        .sidebar-nav a.active .menu-icon {

            opacity: 1;
        }


        /* =====================================================
           PROFILE STAFF
        ===================================================== */

        .sidebar-profile {

            padding:
                14px;

            border-top:
                1px solid
                rgba(255,255,255,0.08);

            background:
                rgba(0,0,0,0.10);

            flex-shrink: 0;
        }


        /* Sesuaikan inner agar tombol terdorong ke paling kanan */
        .sidebar-profile-inner {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px;
            border-radius: 10px;
        }

        /* Mengatur agar info profil mengambil sisa ruang */
        .sidebar-profile-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex: 1; /* PENTING: Mendorong tombol logout ke kanan */
        }

        /* Form Logout */
        .sidebar-logout-form {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        /* Tombol Logout Ikon Merah/Transparan */
        .btn-sidebar-logout {
            background: transparent;
            border: none;
            color: #ef4444; /* Warna merah */
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: background 0.2s, color 0.2s;
        }

        .btn-sidebar-logout:hover {
            background: rgba(239, 68, 68, 0.15); /* Efek hover merah transparan */
            color: #f87171;
        }

        .btn-sidebar-logout svg {
            width: 18px;
            height: 18px;
        }


        .sidebar-profile-icon {

            width: 38px;
            height: 38px;

            border-radius: 50%;

            background: #075eb8;

            display: flex;

            align-items: center;

            justify-content: center;

            color: white;

            flex-shrink: 0;
        }


        .sidebar-profile-icon svg {

            width: 19px;
            height: 19px;
        }


        .sidebar-profile-info {

            display: flex;

            flex-direction: column;

            min-width: 0;
        }


        .sidebar-profile-info strong {

            font-size: 12px;

            color: white;

            white-space: nowrap;
        }


        .sidebar-profile-info span {

            margin-top: 3px;

            font-size: 10px;

            color: #8fa7bd;
        }


        /* =====================================================
           SCROLLBAR SIDEBAR
        ===================================================== */

        .sidebar-nav::-webkit-scrollbar {

            width: 4px;
        }


        .sidebar-nav::-webkit-scrollbar-track {

            background: transparent;
        }


        .sidebar-nav::-webkit-scrollbar-thumb {

            background:
                rgba(255,255,255,0.15);

            border-radius: 10px;
        }


        /* =====================================================
           KONTEN STAFF
        ===================================================== */

        /* KODE PERBAIKAN */
        body:has(.sidebar-staff) main,
        body:has(.sidebar-staff) footer {
            margin-left: 265px; /* Beri margin kiri agar footer sejajar dengan main */
        }

        body:has(.sidebar-staff) .page-content {
            margin-left: 0;
        }


        /* =====================================================
           NAVBAR MAHASISWA
        ===================================================== */

        .navbar {

            width: 100%;

            height: 64px;

            background: white;

            border-bottom:
                1px solid #e5e7eb;

            position: relative;

            z-index: 1000;
        }


        .nav-inner {

            height: 100%;

            max-width: 1400px;

            margin: 0 auto;

            padding: 0 22px;

            display: flex;

            align-items: center;

            justify-content: space-between;
        }


        .brand {

            display: flex;

            align-items: center;

            gap: 10px;

            color: #172033;

            text-decoration: none;

            font-size: 13px;

            line-height: 1.1;
        }


        .brand .logo {

            width: 38px;
            height: 38px;

            border-radius: 8px;

            background: #075eb8;

            color: white;

            display: flex;

            align-items: center;

            justify-content: center;

            font-size: 18px;
        }


        .navbar nav {

            display: flex;

            align-items: center;

            gap: 4px;
        }


        .navbar nav a {

            padding:
                8px 10px;

            color: #334155;

            text-decoration: none;

            font-size: 13px;

            border-radius: 6px;
        }


        .navbar nav a:hover {

            background: #f1f5f9;

            color: #075eb8;
        }


        .user-area {

            display: flex;

            align-items: center;

            gap: 12px;
        }


        .user-name {

            font-size: 13px;

            font-weight: 600;

            color: #334155;
        }


        .btn.small {

            border: none;

            background: #075eb8;

            color: white;

            padding:
                7px 12px;

            border-radius: 6px;

            cursor: pointer;

            font-size: 12px;
        }


        .btn.small:hover {

            background: #064d96;
        }


        .btn-toggle-sidebar {

            border: none;

            background: transparent;

            cursor: pointer;

            padding: 5px;

            display: none;
        }


        /* =====================================================
           MAIN
        ===================================================== */

        main {

            min-height:
                calc(100vh - 64px);
        }


        .page-content {

            min-height: 100vh;
        }


        /* =====================================================
           OVERLAY
        ===================================================== */

        .sidebar-overlay {

            display: none;

            position: fixed;

            inset: 0;

            background:
                rgba(0,0,0,0.40);

            z-index: 9998;
        }


        .sidebar-overlay.active {

            display: block;
        }


        /* =====================================================
           RESPONSIVE
        ===================================================== */

        @media (max-width: 900px) {

            .sidebar-staff {

                left: -265px;
            }


            .sidebar-staff.open {

                left: 0;
            }


            .sidebar-header .close-btn {

                display: flex;
            }


            .btn-toggle-sidebar {

                display: block;
            }


            body:has(.sidebar-staff) main {

                margin-left: 0;
            }


            .navbar nav {

                display: none;
            }


            .nav-inner {

                padding: 0 15px;
            }

        }

    </style>

</head>


<body>


{{-- =====================================================
     SIDEBAR STAFF
===================================================== --}}

@if($role === 'staff')

    <aside
        id="staffSidebar"
        class="sidebar-staff"
    >

        {{-- HEADER SIDEBAR --}}

        <div class="sidebar-header">

            <a
                href="{{ route('staff.dashboard') }}"
                class="sidebar-brand"
            >

                <div class="sidebar-logo">

                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M3 9l9-5 9 5-9 5-9-5z"/>
                        <path d="M7 11.2V16c2.8 2.3 7.2 2.3 10 0v-4.8"/>
                        <path d="M21 10v5"/>
                    </svg>

                </div>


                <div class="sidebar-brand-text">

                    <strong>
                        SISTEM REKOMENDASI
                    </strong>

                    <span>
                        Panel Staff
                    </span>

                </div>

            </a>


            <button
                type="button"
                id="closeSidebarBtn"
                class="close-btn"
            >
                ×
            </button>

        </div>


        {{-- MENU --}}
        <nav class="sidebar-nav">

            <div class="sidebar-section-title">
                Menu Utama
            </div>

            {{-- DASHBOARD --}}
            <a
                href="{{ route('staff.dashboard') }}"
                class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                <span>
                    Dashboard
                </span>
            </a>

            {{-- DATA MAHASISWA --}}
            <a
                href="{{ route('staff.mahasiswa.index') }}"
                class="{{ request()->routeIs('staff.mahasiswa.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
                <span>
                    Data Mahasiswa
                </span>
            </a>

            {{-- DATA PORTFOLIO --}}
            <a
                href="{{ route('staff.portfolio.index') }}"
                class="{{ request()->routeIs('staff.portfolio.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="2" y="7" width="20" height="14" rx="2" ry="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </span>
                <span>
                    Data Portfolio
                </span>
            </a>

            {{-- DATA LOMBA --}}
            <a
                href="{{ route('staff.lomba.index') }}"
                class="{{ request()->routeIs('staff.lomba.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M8 21h8"/>
                        <path d="M12 17v4"/>
                        <path d="M7 4h10v5a5 5 0 0 1-10 0V4z"/>
                        <path d="M7 6H3v2a4 4 0 0 0 4 4"/>
                        <path d="M17 6h4v2a4 4 0 0 1-4 4"/>
                        <path d="M9 2h6"/>
                    </svg>
                </span>
                <span>
                    Data Lomba
                </span>
            </a>

            {{-- KRITERIA --}}
            <a
                href="{{ route('staff.kriteria.index') }}"
                class="{{ request()->routeIs('staff.kriteria.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V21h-2v-.09a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7v-2h.84A1.7 1.7 0 0 0 9.4 11a1.7 1.7 0 0 0-.34-1.88L9 9.06l1.42-1.42.06.06A1.7 1.7 0 0 0 12.36 8.7 1.7 1.7 0 0 0 13.4 7.14V7h2v.14a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 11c.22.63.81 1.03 1.48 1.03H21v2h-.12A1.7 1.7 0 0 0 19.4 15z"/>
                    </svg>
                </span>
                <span>
                    Kriteria
                </span>
            </a>

            {{-- REKOMENDASI --}}
            <a
                href="{{ route('staff.rekomendasi.index') }}"
                class="{{ request()->routeIs('staff.rekomendasi.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <path d="M12 3l2.2 4.45 4.92.72-3.56 3.47.84 4.9L12 14.2l-4.4 2.34.84-4.9-3.56-3.47 4.92-.72L12 3z"/>
                    </svg>
                </span>
                <span>
                    Rekomendasi
                </span>
            </a>

            {{-- PENDAFTARAN --}}
            <a
                href="{{ route('staff.pendaftaran.index') }}"
                class="{{ request()->routeIs('staff.pendaftaran.*') ? 'active' : '' }}"
            >
                <span class="menu-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                    >
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="M8 7h8"/>
                        <path d="M8 11h8"/>
                        <path d="M8 15h5"/>
                        <path d="M8 18h3"/>
                    </svg>
                </span>
                <span>
                    Pendaftaran
                </span>
            </a>

        </nav>


        {{-- PROFILE STAFF DENGAN TOMBOL LOGOUT --}}
        <div class="sidebar-profile">
            <div class="sidebar-profile-inner">
                <div class="sidebar-profile-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/>
                    </svg>
                </div>

                <div class="sidebar-profile-info">
                    <strong>Staff Admin</strong>
                    <span>Administrator</span>
                </div>

                {{-- Tombol Logout di Samping Kanan --}}
                <form method="POST" action="{{ route('logout') }}" class="sidebar-logout-form">
                    @csrf
                    <button type="submit" class="btn-sidebar-logout" title="Logout">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path>
                            <polyline points="16 17 21 12 16 7"></polyline>
                            <line x1="21" y1="12" x2="9" y2="12"></line>
                        </svg>
                    </button>
                </form>
            </div>
        </div>

    </aside>


    <div
        id="sidebarOverlay"
        class="sidebar-overlay"
    ></div>

@endif



{{-- =====================================================
     NAVBAR MAHASISWA
===================================================== --}}

@if($role !== 'staff')

    <header class="navbar">

        <div class="nav-inner">


            {{-- BRAND --}}

            <a
                class="brand"
                href="{{ $role === 'mahasiswa'
                    ? route('mahasiswa.dashboard')
                    : route('home') }}"
            >

                <span class="logo">
                    🎓
                </span>

                <span>
                    Sistem<br>
                    <b>
                        Rekomendasi Mahasiswa
                    </b>
                </span>

            </a>


            {{-- NAVIGASI --}}

            @if($role === 'mahasiswa')

                <nav>

                    <a
                        href="{{ route('mahasiswa.dashboard') }}"
                    >
                        Beranda
                    </a>

                    <a
                        href="{{ route('mahasiswa.profil.show') }}"
                    >
                        Profil Mahasiswa
                    </a>

                    <a
                        href="{{ route('mahasiswa.portfolio.index') }}"
                    >
                        Portfolio
                    </a>

                    <a
                        href="{{ route('mahasiswa.lomba.index') }}"
                    >
                        Data Lomba
                    </a>

                    <a
                        href="{{ route('mahasiswa.rekomendasi') }}"
                    >
                        Rekomendasi
                    </a>

                    <a
                        href="{{ route('mahasiswa.pendaftaran.index') }}"
                    >
                        Pendaftaran
                    </a>

                </nav>

            @endif


            {{-- USER AREA --}}

            @if($role)

                <div class="user-area">


                    {{-- NOTIFIKASI --}}

                    @if($role === 'mahasiswa')

                        <a
                            href="{{ route('notifications.index') }}"
                            style="
                                position:relative;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                width:38px;
                                height:38px;
                                text-decoration:none;
                                font-size:18px;
                                color:#334155;
                            "
                        >

                            <svg
                                width="19"
                                height="19"
                                viewBox="0 0 24 24"
                                fill="none"
                                stroke="currentColor"
                                stroke-width="1.8"
                            >
                                <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                                <path d="M10 21h4"/>
                            </svg>


                            @if($unreadNotifications > 0)

                                <span
                                    style="
                                        position:absolute;
                                        top:1px;
                                        right:1px;
                                        min-width:16px;
                                        height:16px;
                                        padding:0 4px;
                                        border-radius:999px;
                                        background:#dc2626;
                                        color:white;
                                        font-size:9px;
                                        font-weight:700;
                                        display:flex;
                                        align-items:center;
                                        justify-content:center;
                                    "
                                >
                                    {{
                                        $unreadNotifications > 99
                                        ? '99+'
                                        : $unreadNotifications
                                    }}
                                </span>

                            @endif

                        </a>

                    @endif


                    {{-- NAMA --}}

                    <span class="user-name">

                        @if($role === 'mahasiswa')

                            {{
                                $mahasiswa?->nama_lengkap
                                ?? 'Mahasiswa'
                            }}

                        @else

                            Staff Admin

                        @endif

                    </span>


                    {{-- LOGOUT --}}

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

@endif



{{-- =====================================================
     KONTEN
===================================================== --}}

<main>

    <div class="page-content">

        @yield('content')

    </div>

</main>



{{-- =====================================================
     FOOTER
===================================================== --}}

@if(View::exists('layouts.footer'))

    @include('layouts.footer')

@endif



{{-- =====================================================
     SCRIPT SIDEBAR
===================================================== --}}

<script>

document.addEventListener(
    'DOMContentLoaded',
    function () {

        const toggleBtn =
            document.getElementById(
                'toggleSidebarBtn'
            );

        const closeBtn =
            document.getElementById(
                'closeSidebarBtn'
            );

        const sidebar =
            document.getElementById(
                'staffSidebar'
            );

        const overlay =
            document.getElementById(
                'sidebarOverlay'
            );


        function openSidebar() {

            if (!sidebar || !overlay) {
                return;
            }

            sidebar.classList.add('open');

            overlay.classList.add('active');

            document.body.style.overflow = 'hidden';
        }


        function closeSidebar() {

            if (!sidebar || !overlay) {
                return;
            }

            sidebar.classList.remove('open');

            overlay.classList.remove('active');

            document.body.style.overflow = '';
        }


        if (toggleBtn) {

            toggleBtn.addEventListener(
                'click',
                openSidebar
            );

        }


        if (closeBtn) {

            closeBtn.addEventListener(
                'click',
                closeSidebar
            );

        }


        if (overlay) {

            overlay.addEventListener(
                'click',
                closeSidebar
            );

        }


        document.addEventListener(
            'keydown',
            function (event) {

                if (event.key === 'Escape') {

                    closeSidebar();

                }

            }
        );

    }
);

</script>


</body>

</html>