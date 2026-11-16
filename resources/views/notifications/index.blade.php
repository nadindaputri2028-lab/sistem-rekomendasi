
@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="container notification-page">

    {{-- HEADER HALAMAN --}}
    <div class="notification-page-header">
        <div>
            <h1>Notifikasi</h1>
            <p>
                Informasi terbaru mengenai lomba,
                pendaftaran, dan rekomendasi mahasiswa.
            </p>
        </div>
    </div>

    {{-- PESAN SUKSES --}}
    @if(session('success'))
        <div class="notification-alert">
            {{ session('success') }}
        </div>
    @endif

    {{-- CARD NOTIFIKASI --}}
    <div class="notification-card">

        {{-- HEADER CARD --}}
        <div class="notification-header">

            <div>
                <h3>Semua Notifikasi</h3>

                <span class="notification-count">
                    {{ $notifications->total() }} notifikasi
                </span>
            </div>

            @if($notifications->total() > 0)

                <div class="notification-header-actions">

                    {{-- TANDAI SEMUA DIBACA --}}
                    <form
                        method="POST"
                        action="{{ route('notifications.readAll') }}"
                    >
                        @csrf

                        <button type="submit" class="btn-read-all">
                            Tandai Semua Dibaca
                        </button>
                    </form>

                    {{-- HAPUS SEMUA --}}
                    <form
                        method="POST"
                        action="{{ route('notifications.destroyAll') }}"
                        onsubmit="return confirm('Apakah Anda yakin ingin menghapus SEMUA notifikasi? Data yang dihapus tidak dapat dikembalikan.')"
                    >
                        @csrf
                        @method('DELETE')

                        <button type="submit" class="btn-delete-all">
                            Hapus Semua
                        </button>
                    </form>

                </div>

            @endif

        </div>

        {{-- DAFTAR NOTIFIKASI --}}
        @forelse($notifications as $notification)

            <div class="notification-item {{ $notification->is_read ? '' : 'unread' }}">

                <div class="notification-content">

                    {{-- INFORMASI NOTIFIKASI --}}
                    <div class="notification-info">

                        @if($notification->url)

                            <a
                                href="{{ route('notifications.open', ['notification' => $notification->id]) }}"
                                class="notification-link"
                            >
                                <h4>{{ $notification->title }}</h4>
                                <p>{{ $notification->message }}</p>
                            </a>

                        @else

                            <h4>{{ $notification->title }}</h4>
                            <p>{{ $notification->message }}</p>

                        @endif

                        <span class="notification-date">
                            {{ $notification->created_at->diffForHumans() }}
                        </span>

                    </div>

                    {{-- TOMBOL AKSI --}}
                    <div class="notification-actions">

                        @if(!$notification->is_read && !$notification->url)

                            <form
                                method="POST"
                                action="{{ route('notifications.read', ['notification' => $notification->id]) }}"
                            >
                                @csrf

                                <button type="submit" class="btn-read">
                                    Tandai Dibaca
                                </button>
                            </form>

                        @endif

                        {{-- HAPUS SATU NOTIFIKASI --}}
                        <form
                            method="POST"
                            action="{{ route('notifications.destroy', ['notification' => $notification->id]) }}"
                            onsubmit="return confirm('Apakah Anda yakin ingin menghapus notifikasi ini?')"
                        >
                            @csrf
                            @method('DELETE')

                            <button type="submit" class="btn-delete">
                                Hapus
                            </button>
                        </form>

                        @if(!$notification->is_read)
                            <span class="badge-new">Baru</span>
                        @endif

                    </div>

                </div>

            </div>

        @empty

            {{-- NOTIFIKASI KOSONG --}}
            <div class="empty-notification">

                <div class="empty-icon">
                    <svg
                        viewBox="0 0 24 24"
                        fill="none"
                        stroke="currentColor"
                        stroke-width="1.8"
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        aria-hidden="true"
                    >
                        <path d="M18 8a6 6 0 0 0-12 0c0 7-3 7-3 9h18c0-2-3-2-3-9"/>
                        <path d="M10 21h4"/>
                    </svg>
                </div>

                <h3>Belum Ada Notifikasi</h3>

                <p>
                    Notifikasi baru akan muncul di sini.
                </p>

            </div>

        @endforelse

        {{-- PAGINATION --}}
        @if($notifications->hasPages())

            <div class="notification-pagination">
                {{ $notifications->links('layouts.pagination') }}
            </div>

        @endif

    </div>

</div>

<style>

/* HALAMAN */
.notification-page {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER HALAMAN */
.notification-page .notification-page-header {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 25px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.notification-page .notification-page-header h1 {
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 8px;
}

.notification-page .notification-page-header p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
}

/* PESAN SUKSES */
.notification-page .notification-alert {
    background: #f0fdf4;
    border: 1px solid #bbf7d0;
    color: #15803d;
    padding: 13px 18px;
    border-radius: 9px;
    margin-bottom: 18px;
    font-size: 13px;
}

/* CARD */
.notification-page .notification-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    overflow: hidden;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

/* HEADER CARD */
.notification-page .notification-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    padding: 20px 24px;
    border-bottom: 1px solid #e2e8f0;
}

.notification-page .notification-header h3 {
    color: #1e3a5f;
    font-size: 17px;
    font-weight: 700;
    margin: 0;
}

.notification-page .notification-count {
    display: inline-block;
    margin-top: 5px;
    color: #64748b;
    font-size: 12px;
}

/* TOMBOL HEADER */
.notification-page .notification-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    flex-wrap: wrap;
}

.notification-page .notification-header-actions form {
    margin: 0;
}

/* BUTTON */
.notification-page .btn-read-all,
.notification-page .btn-read,
.notification-page .btn-delete,
.notification-page .btn-delete-all {
    border: none;
    color: #ffffff;
    border-radius: 8px;
    padding: 9px 14px;
    font-size: 12px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
    white-space: nowrap;
}

/* TANDAI DIBACA */
.notification-page .btn-read-all,
.notification-page .btn-read {
    background: #1e3a5f;
}

.notification-page .btn-read-all:hover,
.notification-page .btn-read:hover {
    background: #274b78;
}

/* HAPUS */
.notification-page .btn-delete,
.notification-page .btn-delete-all {
    background: #dc2626;
}

.notification-page .btn-delete:hover,
.notification-page .btn-delete-all:hover {
    background: #b91c1c;
}

/* ITEM NOTIFIKASI */
.notification-page .notification-item {
    display: block;
    width: 100%;
    box-sizing: border-box;
    padding: 20px 24px;
    border-bottom: 1px solid #edf1f5;
    color: inherit;
    transition: background 0.2s;
}

.notification-page .notification-item:last-child {
    border-bottom: none;
}

.notification-page .notification-item:hover {
    background: #f8fafc;
}

/* NOTIFIKASI BELUM DIBACA */
.notification-page .notification-item.unread {
    background: #f0f7ff;
    border-left: 3px solid #2563eb;
}

.notification-page .notification-item.unread:hover {
    background: #e8f2ff;
}

/* KONTEN */
.notification-page .notification-content {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    gap: 18px;
}

.notification-page .notification-info {
    flex: 1;
    min-width: 0;
}

.notification-page .notification-info h4 {
    color: #1e3a5f;
    font-size: 14px;
    font-weight: 700;
    margin: 0 0 8px;
}

.notification-page .notification-info p {
    color: #475569;
    font-size: 13px;
    line-height: 1.6;
    margin: 0 0 9px;
    overflow-wrap: anywhere;
}

/* LINK NOTIFIKASI */
.notification-page .notification-link {
    text-decoration: none;
    color: inherit;
}

.notification-page .notification-link:hover h4 {
    color: #2563eb;
}

.notification-page .notification-date {
    color: #94a3b8;
    font-size: 11px;
}

/* AKSI NOTIFIKASI */
.notification-page .notification-actions {
    display: flex;
    align-items: center;
    gap: 8px;
    flex-wrap: wrap;
}

.notification-page .notification-actions form {
    margin: 0;
}

/* BADGE BARU */
.notification-page .badge-new {
    flex-shrink: 0;
    background: #dbeafe;
    color: #1d4ed8;
    padding: 6px 12px;
    border-radius: 20px;
    font-size: 11px;
    font-weight: 700;
}

/* EMPTY STATE */
.notification-page .empty-notification {
    padding: 55px 20px;
    text-align: center;
    color: #64748b;
}

.notification-page .empty-icon {
    width: 60px;
    height: 60px;
    margin: 0 auto 15px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: #eff6ff;
    color: #2563eb;
}

.notification-page .empty-icon svg {
    width: 27px !important;
    height: 27px !important;
    max-width: 27px !important;
    max-height: 27px !important;
}

.notification-page .empty-notification h3 {
    color: #1e3a5f;
    font-size: 16px;
    font-weight: 700;
    margin: 0 0 7px;
}

.notification-page .empty-notification p {
    font-size: 13px;
    margin: 0;
}

/* PAGINATION */
.notification-page .notification-pagination {
    padding: 18px 24px;
    border-top: 1px solid #e2e8f0;
    overflow-x: auto;
}

.notification-page .notification-pagination svg {
    width: 16px !important;
    height: 16px !important;
    max-width: 16px !important;
    max-height: 16px !important;
    display: inline-block !important;
    vertical-align: middle;
}

.notification-page .notification-pagination nav {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 10px;
}

.notification-page .notification-pagination nav a,
.notification-page .notification-pagination nav span {
    font-size: 13px;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .notification-page {
        padding-top: 20px;
    }

    .notification-page .notification-page-header {
        padding: 20px;
    }

    .notification-page .notification-page-header h1 {
        font-size: 21px;
    }

    .notification-page .notification-header {
        padding: 16px;
        align-items: flex-start;
    }

    .notification-page .notification-item {
        padding: 17px 16px;
    }

    .notification-page .notification-pagination {
        padding: 15px;
    }
}

@media (max-width: 600px) {
    .notification-page .notification-header {
        flex-direction: column;
    }

    .notification-page .notification-content {
        gap: 10px;
    }

    .notification-page .notification-header-actions {
        width: 100%;
        flex-direction: column;
        align-items: stretch;
    }

    .notification-page .notification-header-actions form,
    .notification-page .notification-header-actions button {
        width: 100%;
    }

    .notification-page .btn-read-all,
    .notification-page .btn-delete-all {
        font-size: 11px;
        padding: 8px 10px;
    }
}

@media (max-width: 480px) {
    .notification-page .notification-page-header {
        padding: 16px;
    }

    .notification-page .notification-content {
        flex-direction: column;
    }

    .notification-page .notification-actions {
        width: 100%;
    }

    .notification-page .badge-new {
        align-self: flex-start;
    }
}

</style>

@endsection
