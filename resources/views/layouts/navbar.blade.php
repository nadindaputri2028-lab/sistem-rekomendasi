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

{{-- ==========================================
     1. SIDEBAR KHUSUS STAFF (DILUAR HEADER)
   ========================================== --}}
@if($role === 'staff')
    <aside id="staffSidebar" class="sidebar-staff">
        <div class="sidebar-header">
            <span>Menu Staff</span>
            <button type="button" id="closeSidebarBtn" class="close-btn">&times;</button>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('staff.dashboard') }}">Dashboard</a>
            <a href="{{ route('staff.mahasiswa.index') }}">Data Mahasiswa</a>
            <a href="{{ route('staff.kriteria.index') }}">Kriteria</a>
            <a href="{{ route('staff.lomba.index') }}">Data Lomba</a>
            <a href="{{ route('staff.rekomendasi.index') }}">Rekomendasi</a>
            <a href="{{ route('staff.pendaftaran.index') }}">Pendaftaran</a>
        </nav>
    </aside>

    {{-- Overlay transparan untuk menutup sidebar saat area luar diklik --}}
    <div id="sidebarOverlay" class="sidebar-overlay"></div>
@endif


{{-- ==========================================
     2. HEADER / NAVBAR UTAMA
   ========================================== --}}
<header class="navbar">

    <div class="container nav-inner">

        <div style="display: flex; align-items: center; gap: 12px;">
            {{-- TOMBOL TOGGLE SIDEBAR (HANYA MUNCUL UNTUK STAFF) --}}
            @if($role === 'staff')
                <button type="button" id="toggleSidebarBtn" class="btn-toggle-sidebar" title="Buka Menu">
                    ☰
                </button>
            @endif

            {{-- LOGO --}}
            @if($role === 'staff')
                <a class="brand" href="{{ route('staff.dashboard') }}">
            @elseif($role === 'mahasiswa')
                <a class="brand" href="{{ route('mahasiswa.dashboard') }}">
            @else
                <a class="brand" href="{{ route('home') }}">
            @endif
                    <span class="logo">🎓</span>
                    <span>
                        Sistem<br>
                        <b>Rekomendasi<br>Mahasiswa</b>
                    </span>
                </a>
        </div>

        {{-- NAVIGASI ATAS (HANYA UNTUK MAHASISWA) --}}
        <nav>
            @if($role === 'mahasiswa')
                <a href="{{ route('mahasiswa.dashboard') }}">Beranda</a>
                <a href="{{ route('mahasiswa.profil.show') }}">Profil Mahasiswa</a>    
                <a href="{{ route('mahasiswa.portfolio.index') }}">Portfolio</a>
                <a href="{{ route('mahasiswa.lomba.index') }}">Data Lomba</a>
                <a href="{{ route('mahasiswa.rekomendasi') }}">Rekomendasi</a>
                <a href="{{ route('mahasiswa.pendaftaran.index') }}">Pendaftaran</a>
            @endif
        </nav>


        {{-- BAGIAN USER --}}
        @if($role)
            <div class="user-area">

                {{-- NOTIFIKASI --}}
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
                        font-size:21px;
                        border-radius:50%;
                    "
                    title="Notifikasi"
                >
                    🔔

                    @if($unreadNotifications > 0)
                        <span
                            style="
                                position:absolute;
                                top:-3px;
                                right:-3px;
                                min-width:18px;
                                height:18px;
                                padding:0 4px;
                                border-radius:999px;
                                background:#dc2626;
                                color:white;
                                font-size:10px;
                                font-weight:700;
                                display:flex;
                                align-items:center;
                                justify-content:center;
                                line-height:1;
                            "
                        >
                            {{ $unreadNotifications > 99 ? '99+' : $unreadNotifications }}
                        </span>
                    @endif
                </a>


                {{-- NAMA USER --}}
                <span class="user-name">
                    @if($role === 'mahasiswa')
                        {{ $mahasiswa?->nama_lengkap }}
                    @else
                        Staff Admin
                    @endif
                </span>


                {{-- LOGOUT --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn small">Logout</button>
                </form>

            </div>
        @endif

    </div>

</header>


{{-- ==========================================
     3. STYLES (CSS) & SCRIPT (JS)
   ========================================== --}}
<style>
    /* Tombol Hamburger */
    .btn-toggle-sidebar {
        background: none;
        border: none;
        font-size: 24px;
        cursor: pointer;
        padding: 4px 8px;
        border-radius: 4px;
    }
    .btn-toggle-sidebar:hover {
        background-color: rgba(0, 0, 0, 0.05);
    }

    /* Sidebar Panel Kiri */
    .sidebar-staff {
        position: fixed;
        top: 0;
        left: -280px; /* Sembunyi di luar layar kiri */
        width: 260px;
        height: 100vh;
        background-color: #ffffff;
        box-shadow: 4px 0 15px rgba(0, 0, 0, 0.1);
        z-index: 9999;
        transition: left 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .sidebar-staff.open {
        left: 0; /* Tampil saat ada class .open */
    }

    .sidebar-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 16px 20px;
        background-color: #0f2d2e;
        color: #ffffff;
        font-weight: bold;
    }

    .close-btn {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
    }

    .sidebar-nav {
        display: flex;
        flex-direction: column;
        padding: 15px 0;
    }

    .sidebar-nav a {
        padding: 12px 20px;
        color: #333;
        text-decoration: none;
        font-weight: 500;
        transition: background 0.2s;
    }

    .sidebar-nav a:hover {
        background-color: #f1f5f9;
        color: #0f2d2e;
    }

    /* Overlay latar belakang saat sidebar terbuka */
    .sidebar-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(0,0,0,0.4);
        z-index: 9998;
        display: none;
    }
    .sidebar-overlay.active {
        display: block;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleBtn = document.getElementById('toggleSidebarBtn');
        const closeBtn = document.getElementById('closeSidebarBtn');
        const sidebar = document.getElementById('staffSidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            if (sidebar && overlay) {
                sidebar.classList.add('open');
                overlay.classList.add('active');
            }
        }

        function closeSidebar() {
            if (sidebar && overlay) {
                sidebar.classList.remove('open');
                overlay.classList.remove('active');
            }
        }

        if (toggleBtn) toggleBtn.addEventListener('click', openSidebar);
        if (closeBtn) closeBtn.addEventListener('click', closeSidebar);
        if (overlay) overlay.addEventListener('click', closeSidebar);
    });
</script>