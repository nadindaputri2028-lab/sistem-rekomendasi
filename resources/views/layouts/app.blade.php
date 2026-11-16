
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Sistem Rekomendasi Mahasiswa')</title>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <style>
        * {
            box-sizing: border-box;
        }

        html, body {
            margin: 0;
            padding: 0;
            overflow-x: hidden;
        }

        body {
            background: #f8fafc;
            color: #172033;
            font-family: Arial, Helvetica, sans-serif;
        }

        /* =====================================================
           SIDEBAR STAFF DAN DOSEN
        ===================================================== */

        .sidebar-staff {
            position: fixed;
            top: 0;
            left: 0;
            width: 265px;
            height: 100vh;
            background: #ffffff;
            color: #1e3a5f;
            z-index: 9999;
            display: flex;
            flex-direction: column;
            overflow: hidden;
            border-right: 1px solid #dbe5f0;
            box-shadow: 4px 0 18px rgba(30, 58, 95, 0.06);
            transition: left 0.28s ease;
        }

        .sidebar-header {
            height: 82px;
            padding: 0 18px;
            display: flex;
            align-items: center;
            border-bottom: 1px solid #e2e8f0;
            flex-shrink: 0;
        }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            color: #1e3a5f;
            text-decoration: none;
            min-width: 0;
        }

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
            box-shadow: 0 5px 15px rgba(7, 94, 184, 0.20);
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
            color: #1e3a5f;
            white-space: nowrap;
        }

        .sidebar-brand-text span {
            margin-top: 4px;
            font-size: 10px;
            color: #64748b;
        }

        .sidebar-header .close-btn {
            display: none;
            margin-left: auto;
            width: 32px;
            height: 32px;
            border: none;
            border-radius: 8px;
            background: transparent;
            color: #475569;
            font-size: 23px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
        }

        .sidebar-header .close-btn:hover {
            background: #eff6ff;
            color: #1e3a5f;
        }

        .sidebar-nav {
            display: flex;
            flex-direction: column;
            gap: 5px;
            padding: 22px 13px;
            flex: 1;
            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar-section-title {
            padding: 0 13px;
            margin: 2px 0 10px;
            color: #64748b;
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .sidebar-nav a {
            position: relative;
            min-height: 46px;
            padding: 0 13px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            gap: 13px;
            color: #334155;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
            transition: background 0.2s ease, color 0.2s ease, transform 0.2s ease;
        }

        .sidebar-nav a:hover {
            background: #eff6ff;
            color: #075eb8;
            transform: translateX(2px);
        }

        .sidebar-nav a.active {
            background: #e6f1ff;
            color: #075eb8;
            font-weight: 700;
        }

        .sidebar-nav a.active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 9px;
            bottom: 9px;
            width: 3px;
            background: #075eb8;
            border-radius: 0 4px 4px 0;
        }

        .sidebar-notification-count {
            margin-left: auto;
            min-width: 19px;
            height: 19px;
            padding: 0 5px;
            border-radius: 20px;
            background: #dc2626;
            color: #ffffff;
            font-size: 10px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            justify-content: center;
        }

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

        .sidebar-profile {
            padding: 14px;
            border-top: 1px solid #e2e8f0;
            background: #f8fafc;
            flex-shrink: 0;
        }

        .sidebar-profile-inner {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 9px;
            border-radius: 10px;
        }

        .sidebar-profile-info {
            display: flex;
            flex-direction: column;
            min-width: 0;
            flex: 1;
        }

        .sidebar-logout-form {
            margin-left: auto;
            display: flex;
            align-items: center;
        }

        .btn-sidebar-logout {
            background: transparent;
            border: none;
            color: #dc2626;
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
        }

        .btn-sidebar-logout:hover {
            background: #fee2e2;
            color: #b91c1c;
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

        .sidebar-profile-info strong {
            font-size: 12px;
            color: #1e3a5f;
            white-space: nowrap;
        }

        .sidebar-profile-info span {
            margin-top: 3px;
            font-size: 10px;
            color: #64748b;
        }

        .sidebar-nav::-webkit-scrollbar {
            width: 4px;
        }

        .sidebar-nav::-webkit-scrollbar-track {
            background: transparent;
        }

        .sidebar-nav::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 10px;
        }

        /* POSISI KONTEN STAFF DAN DOSEN */

        body:has(.sidebar-staff) main,
        body:has(.sidebar-staff) footer {
            margin-left: 265px;
        }

        body:has(.sidebar-staff) .page-content {
            margin-left: 0;
        }

        body:has(.dosen-sidebar) .navbar {
            margin-left: 265px;
            width: calc(100% - 265px);
        }

        /* =====================================================
           NAVBAR MAHASISWA
           BAGIAN INI DIPERTAHANKAN
        ===================================================== */

        .navbar {
            position: sticky;
            top: 0;
            width: 100%;
            height: 70px;
            background: rgba(255, 255, 255, 0.98);
            border-bottom: 1px solid #e6edf5;
            box-shadow: 0 3px 12px rgba(15, 45, 80, 0.06);
            z-index: 1000;
        }

        .nav-inner {
            width: 100%;
            max-width: 1600px;
            height: 100%;
            margin: 0 auto;
            padding: 0 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
        }

        .brand {
            display: flex;
            align-items: center;
            gap: 11px;
            color: #123d70;
            text-decoration: none;
            font-size: 13px;
            font-weight: 700;
            line-height: 1.2;
            white-space: nowrap;
            flex-shrink: 0;
        }

        .brand .logo {
            width: 43px;
            height: 43px;
            border-radius: 12px;
            background: #075eb8;
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(7, 94, 184, 0.20);
        }

        .brand .logo svg {
            width: 27px;
            height: 27px;
            display: block;
        }

        .navbar nav {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 5px;
            flex: 1;
            min-width: 0;
        }

        .navbar nav a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 11px 12px;
            border-radius: 10px;
            color: #344b68;
            text-decoration: none;
            font-size: 12px;
            font-weight: 600;
            white-space: nowrap;
            transition: background 0.2s ease, color 0.2s ease;
        }

        .navbar nav a svg {
            width: 17px;
            height: 17px;
            flex-shrink: 0;
        }

        .navbar nav a:hover {
            background: #eff6ff;
            color: #075eb8;
        }

        .navbar nav a.active {
            background: #075eb8;
            color: white;
            box-shadow: 0 4px 10px rgba(7, 94, 184, 0.18);
        }

        .navbar nav a.active:hover {
            background: #064d96;
            color: white;
        }

        .user-area {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-shrink: 0;
        }

        .user-name {
            max-width: 115px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            font-size: 12px;
            font-weight: 700;
            color: #263f5e;
        }

        .nav-notification {
            position: relative;
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            color: #243e60;
            text-decoration: none;
            flex-shrink: 0;
        }

        .nav-notification:hover {
            background: #eff6ff;
            color: #075eb8;
        }

        .nav-notification svg {
            width: 21px;
            height: 21px;
        }

        .nav-notification .notification-count {
            position: absolute;
            top: 0;
            right: 0;
            min-width: 17px;
            height: 17px;
            padding: 0 4px;
            border: 2px solid white;
            border-radius: 20px;
            background: #dc2626;
            color: white;
            font-size: 9px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .nav-logout {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 10px 14px;
            border: 1px solid #e2eaf3;
            border-radius: 10px;
            background: #f1f5f9;
            color: #263f5e;
            font-size: 12px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;
        }

        .nav-logout:hover {
            background: #fee2e2;
            color: #dc2626;
            border-color: #fecaca;
        }

        .nav-logout svg {
            width: 17px;
            height: 17px;
        }

        /* TOMBOL SIDEBAR DOSEN */

        .btn-toggle-sidebar {
            display: none;
            width: 38px;
            height: 38px;
            border: 1px solid #e2e8f0;
            border-radius: 9px;
            background: #ffffff;
            color: #1e3a5f;
            font-size: 21px;
            cursor: pointer;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .btn-toggle-sidebar:hover {
            background: #eff6ff;
        }

        @media (max-width: 1150px) {
            .nav-inner {
                padding: 0 14px;
                gap: 9px;
            }

            .navbar nav {
                gap: 2px;
            }

            .navbar nav a {
                padding: 10px 7px;
                gap: 5px;
                font-size: 11px;
            }

            .user-name {
                display: none;
            }
        }

        @media (max-width: 900px) {
            .navbar {
                height: auto;
                position: sticky;
            }

            .nav-inner {
                min-height: 66px;
                height: auto;
                flex-wrap: wrap;
                padding: 9px 14px;
                gap: 7px;
            }

            .navbar nav {
                order: 3;
                width: 100%;
                flex: 0 0 100%;
                justify-content: flex-start;
                overflow-x: auto;
                padding: 4px 0 6px;
                scrollbar-width: thin;
            }

            .navbar nav a {
                flex-shrink: 0;
            }

            .user-area {
                margin-left: auto;
            }

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
                display: inline-flex;
            }

            body:has(.sidebar-staff) main,
            body:has(.sidebar-staff) footer {
                margin-left: 0;
            }

            body:has(.dosen-sidebar) .navbar {
                margin-left: 0;
                width: 100%;
            }

            /* Navbar mahasiswa tetap mengikuti tampilan aslinya */
            body:not(:has(.dosen-sidebar)) .navbar nav {
                display: none;
            }
        }

        @media (max-width: 480px) {
            .brand {
                font-size: 11px;
            }

            .brand .logo {
                width: 37px;
                height: 37px;
            }

            .nav-logout {
                padding: 9px 10px;
                font-size: 10px;
            }

            .navbar nav a {
                padding: 9px 10px;
                font-size: 10px;
            }
        }

        /* =====================================================
           MAIN DAN OVERLAY
        ===================================================== */

        main {
            min-height: calc(100vh - 64px);
        }

        .page-content {
            min-height: 100vh;
        }

        .sidebar-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, 0.40);
            z-index: 9998;
        }

        .sidebar-overlay.active {
            display: block;
        }
    </style>
</head>

<body>

{{-- =====================================================
     SIDEBAR STAFF
     BAGIAN STAFF TETAP
===================================================== --}}

@if($role === 'staff')

    <aside id="staffSidebar" class="sidebar-staff">

        <div class="sidebar-header">

            <a href="{{ route('staff.dashboard') }}" class="sidebar-brand">

                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M3 9l9-5 9 5-9 5-9-5z"/>
                        <path d="M7 11.2V16c2.8 2.3 7.2 2.3 10 0v-4.8"/>
                        <path d="M21 10v5"/>
                    </svg>
                </div>

                <div class="sidebar-brand-text">
                    <strong>SISTEM REKOMENDASI</strong>
                    <span>Panel Staff</span>
                </div>

            </a>

            <button type="button" id="closeSidebarBtn" class="close-btn">×</button>

        </div>

        <nav class="sidebar-nav">

            <div class="sidebar-section-title">Menu Utama</div>

            <a href="{{ route('staff.dashboard') }}"
               class="{{ request()->routeIs('staff.dashboard') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>
                <span>Dashboard</span>
            </a>

            <a href="{{ route('staff.mahasiswa.index') }}"
               class="{{ request()->routeIs('staff.mahasiswa.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>
                <span>Data Mahasiswa</span>
            </a>

            <a href="{{ route('staff.portfolio.index') }}"
               class="{{ request()->routeIs('staff.portfolio.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </span>
                <span>Data Portfolio</span>
            </a>

            <a href="{{ route('staff.lomba.index') }}"
               class="{{ request()->routeIs('staff.lomba.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M8 21h8"/>
                        <path d="M12 17v4"/>
                        <path d="M7 4h10v5a5 5 0 0 1-10 0V4z"/>
                        <path d="M7 6H3v2a4 4 0 0 0 4 4"/>
                        <path d="M17 6h4v2a4 4 0 0 1-4 4"/>
                        <path d="M9 2h6"/>
                    </svg>
                </span>
                <span>Data Lomba</span>
            </a>

            <a href="{{ route('staff.kriteria.index') }}"
               class="{{ request()->routeIs('staff.kriteria.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="12" r="3"/>
                        <path d="M19.4 15a1.7 1.7 0 0 0 .34 1.88l.06.06-1.42 1.42-.06-.06a1.7 1.7 0 0 0-1.88-.34 1.7 1.7 0 0 0-1.03 1.56V21h-2v-.09a1.7 1.7 0 0 0-1.03-1.56 1.7 1.7 0 0 0-1.88.34l-.06.06-1.42-1.42.06-.06A1.7 1.7 0 0 0 9.4 15a1.7 1.7 0 0 0-1.56-1.03H7v-2h.84A1.7 1.7 0 0 0 9.4 11a1.7 1.7 0 0 0-.34-1.88L9 9.06l1.42-1.42.06.06A1.7 1.7 0 0 0 12.36 8.7 1.7 1.7 0 0 0 13.4 7.14V7h2v.14a1.7 1.7 0 0 0 1.03 1.56 1.7 1.7 0 0 0 1.88-.34l.06-.06 1.42 1.42-.06.06A1.7 1.7 0 0 0 19.4 11c.22.63.81 1.03 1.48 1.03H21v2h-.12A1.7 1.7 0 0 0 19.4 15z"/>
                    </svg>
                </span>
                <span>Kriteria</span>
            </a>

            <a href="{{ route('staff.rekomendasi.index') }}"
               class="{{ request()->routeIs('staff.rekomendasi.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M12 3l2.2 4.45 4.92.72-3.56 3.47.84 4.9L12 14.2l-4.4 2.34.84-4.9-3.56-3.47 4.92-.72L12 3z"/>
                    </svg>
                </span>
                <span>Rekomendasi</span>
            </a>

            <a href="{{ route('staff.pendaftaran.index') }}"
               class="{{ request()->routeIs('staff.pendaftaran.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="4" y="3" width="16" height="18" rx="2"/>
                        <path d="M8 7h8"/>
                        <path d="M8 11h8"/>
                        <path d="M8 15h5"/>
                        <path d="M8 18h3"/>
                    </svg>
                </span>
                <span>Pendaftaran</span>
            </a>

            <a href="{{ route('notifications.index') }}"
               class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">
                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                </span>
                <span>Notifikasi</span>

                @if($unreadNotifications > 0)
                    <span class="sidebar-notification-count">
                        {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                    </span>
                @endif
            </a>

        </nav>

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

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

@endif


{{-- =====================================================
     SIDEBAR DOSEN
===================================================== --}}

{{-- =====================================================
     SIDEBAR DOSEN
===================================================== --}}

@if($role === 'dosen')

    <aside id="dosenSidebar" class="sidebar-staff dosen-sidebar">

        <div class="sidebar-header">

            <a href="{{ route('dosen.dashboard') }}" class="sidebar-brand">

                <div class="sidebar-logo">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="1.8">
                        <path d="M3 9l9-5 9 5-9 5-9-5z"/>
                        <path d="M7 11.2V16c2.8 2.3 7.2 2.3 10 0v-4.8"/>
                        <path d="M21 10v5"/>
                    </svg>
                </div>

                <div class="sidebar-brand-text">
                    <strong>SISTEM REKOMENDASI</strong>
                    <span>Panel Dosen</span>
                </div>

            </a>

            <button type="button" id="closeSidebarBtn" class="close-btn">×</button>

        </div>

        <nav class="sidebar-nav">

            <div class="sidebar-section-title">Menu Dosen</div>

            {{-- Dashboard --}}
            <a href="{{ route('dosen.dashboard') }}"
               class="{{ request()->routeIs('dosen.dashboard') ? 'active' : '' }}">

                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="3" y="3" width="7" height="7" rx="1"/>
                        <rect x="14" y="3" width="7" height="7" rx="1"/>
                        <rect x="3" y="14" width="7" height="7" rx="1"/>
                        <rect x="14" y="14" width="7" height="7" rx="1"/>
                    </svg>
                </span>

                <span>Dashboard</span>
            </a>

            {{-- Data Mahasiswa --}}
            <a href="{{ route('dosen.mahasiswa.index') }}"
               class="{{ request()->routeIs('dosen.mahasiswa.*') ? 'active' : '' }}">

                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M16 21v-2a4 4 0 0 0-4-4H6a4 4 0 0 0-4 4v2"/>
                        <circle cx="9" cy="7" r="4"/>
                        <path d="M22 21v-2a4 4 0 0 0-3-3.87"/>
                        <path d="M16 3.13a4 4 0 0 1 0 7.75"/>
                    </svg>
                </span>

                <span>Data Mahasiswa</span>
            </a>

            {{-- Portfolio Mahasiswa --}}
            <a href="{{ route('dosen.portfolio.index') }}"
               class="{{ request()->routeIs('dosen.portfolio.*') ? 'active' : '' }}">

                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <rect x="2" y="7" width="20" height="14" rx="2"/>
                        <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
                    </svg>
                </span>

                <span>Portfolio Mahasiswa</span>
            </a>

            {{-- Penilaian Mahasiswa --}}
            @if(Route::has('dosen.penilaian.index'))
                <a href="{{ route('dosen.penilaian.index') }}"
                   class="{{ request()->routeIs('dosen.penilaian.*') ? 'active' : '' }}">

                    <span class="menu-icon">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                            <path d="M9 11l3 3L22 4"/>
                            <path d="M21 12v7a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11"/>
                        </svg>
                    </span>

                    <span>Penilaian Mahasiswa</span>
                </a>
            @endif

            {{-- Notifikasi --}}
            <a href="{{ route('notifications.index') }}"
               class="{{ request()->routeIs('notifications.*') ? 'active' : '' }}">

                <span class="menu-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                </span>

                <span>Notifikasi</span>

                @if($unreadNotifications > 0)
                    <span class="sidebar-notification-count">
                        {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                    </span>
                @endif

            </a>

        </nav>

        {{-- Profil dan Logout --}}
        <div class="sidebar-profile">

            <div class="sidebar-profile-inner">

                <div class="sidebar-profile-icon">
                    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                        <circle cx="12" cy="8" r="4"/>
                        <path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/>
                    </svg>
                </div>

                <div class="sidebar-profile-info">
                    <strong>Dosen</strong>
                    <span>Dosen Pembimbing</span>
                </div>

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

    <div id="sidebarOverlay" class="sidebar-overlay"></div>

@endif


{{-- =====================================================
     NAVBAR MAHASISWA DAN DOSEN
     NAVBAR MAHASISWA TETAP SAMA
===================================================== --}}

@if($role !== 'staff' && !request()->is('login') && !request()->routeIs('login'))

<header class="navbar">

    <div class="nav-inner">

        {{-- TOMBOL SIDEBAR KHUSUS DOSEN --}}

        @if($role === 'dosen')
            <button type="button" id="toggleSidebarBtn" class="btn-toggle-sidebar">
                ☰
            </button>
        @endif

        {{-- BRAND --}}

        <a class="brand"
           href="{{ $role === 'mahasiswa' ? route('mahasiswa.dashboard') : ($role === 'dosen' ? route('dosen.dashboard') : route('home')) }}">

            <span class="logo">
                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     stroke-linecap="round" stroke-linejoin="round"
                     aria-hidden="true">
                    <path d="M2 9l10-5 10 5-10 5L2 9z"/>
                    <path d="M6 11v5c4 3 8 3 12 0v-5"/>
                    <path d="M22 9v6"/>
                </svg>
            </span>

            <span>
                Sistem<br>
                <b>Rekomendasi Mahasiswa</b>
            </span>

        </a>

        {{-- NAVIGASI MAHASISWA --}}

        @if($role === 'mahasiswa')

        <nav>

            <a href="{{ route('mahasiswa.dashboard') }}"
               class="{{ request()->routeIs('mahasiswa.dashboard') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M3 10.5L12 3l9 7.5"/>
                    <path d="M5 9v11h14V9"/>
                    <path d="M9 20v-7h6v7"/>
                </svg>
                Beranda
            </a>

            <a href="{{ route('mahasiswa.profil.show') }}"
               class="{{ request()->routeIs('mahasiswa.profil.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="8" r="4"/>
                    <path d="M4 21c0-4 3.5-7 8-7s8 3 8 7"/>
                </svg>
                Profil Mahasiswa
            </a>

            <a href="{{ route('mahasiswa.portfolio.index') }}"
               class="{{ request()->routeIs('mahasiswa.portfolio.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="7" width="18" height="14" rx="2"/>
                    <path d="M8 7V5a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"/>
                </svg>
                Portofolio
            </a>

            <a href="{{ route('mahasiswa.lomba.index') }}"
               class="{{ request()->routeIs('mahasiswa.lomba.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M8 21h8M12 17v4"/>
                    <path d="M7 4h10v5a5 5 0 0 1-10 0V4z"/>
                    <path d="M7 6H3v2a4 4 0 0 0 4 4M17 6h4v2a4 4 0 0 1-4 4"/>
                </svg>
                Data Lomba
            </a>

            <a href="{{ route('mahasiswa.rekomendasi') }}"
               class="{{ request()->routeIs('mahasiswa.rekomendasi') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M12 3l2.7 5.5 6.1.9-4.4 4.3 1 6.1-5.4-2.9-5.4 2.9 1-6.1-4.4-4.3 6.1-.9L12 3z"/>
                </svg>
                Rekomendasi
            </a>

            <a href="{{ route('mahasiswa.pendaftaran.index') }}"
               class="{{ request()->routeIs('mahasiswa.pendaftaran.*') ? 'active' : '' }}">
                <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="4" y="3" width="16" height="18" rx="2"/>
                    <path d="M8 8h8M8 12h8M8 16h5"/>
                </svg>
                Pendaftaran
            </a>

        </nav>

        @endif

        {{-- AREA PENGGUNA --}}

        @if($role)

        <div class="user-area">

            @if($role === 'mahasiswa' || $role === 'dosen')

            <a href="{{ route('notifications.index') }}"
               class="nav-notification"
               title="Notifikasi"
               aria-label="Notifikasi">

                <svg viewBox="0 0 24 24" fill="none"
                     stroke="currentColor" stroke-width="1.8"
                     aria-hidden="true">
                    <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                    <path d="M10 21h4"/>
                </svg>

                @if($unreadNotifications > 0)
                    <span class="notification-count">
                        {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                    </span>
                @endif

            </a>

            @endif

            <span class="user-name">

                @if($role === 'mahasiswa')
                    {{ $mahasiswa?->nama_lengkap ?? 'Mahasiswa' }}
                @elseif($role === 'dosen')
                    Dosen
                @else
                    Staff Admin
                @endif

            </span>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="nav-logout">
                    <svg viewBox="0 0 24 24" fill="none"
                         stroke="currentColor" stroke-width="2"
                         aria-hidden="true">
                        <path d="M10 17l5-5-5-5"/>
                        <path d="M15 12H3"/>
                        <path d="M12 3h7a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-7"/>
                    </svg>
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

@if(!request()->is('login') && !request()->routeIs('login') && View::exists('layouts.footer'))

    @include('layouts.footer')

@endif


{{-- =====================================================
     SCRIPT SIDEBAR STAFF DAN DOSEN
===================================================== --}}

<script>
document.addEventListener('DOMContentLoaded', function () {

    const toggleBtn = document.getElementById('toggleSidebarBtn');
    const closeBtn = document.getElementById('closeSidebarBtn');

    const sidebar =
        document.getElementById('staffSidebar') ||
        document.getElementById('dosenSidebar');

    const overlay = document.getElementById('sidebarOverlay');

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
        toggleBtn.addEventListener('click', openSidebar);
    }

    if (closeBtn) {
        closeBtn.addEventListener('click', closeSidebar);
    }

    if (overlay) {
        overlay.addEventListener('click', closeSidebar);
    }

    document.addEventListener('keydown', function (event) {

        if (event.key === 'Escape') {
            closeSidebar();
        }

    });

});
</script>

</body>
</html>
