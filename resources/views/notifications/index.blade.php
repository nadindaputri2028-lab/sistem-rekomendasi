@extends('layouts.app')

@section('title', 'Notifikasi')

@section('content')

<div class="container">

    <div class="page-title">
        <h1>Notifikasi</h1>

        <p>
            Informasi terbaru mengenai lomba,
            pendaftaran, dan rekomendasi mahasiswa.
        </p>
    </div>

    <div class="card">

        {{-- HEADER --}}
        <div style="
            display:flex;
            justify-content:space-between;
            align-items:center;
            padding:20px;
            border-bottom:1px solid #e5eaf0;
        ">

            <div>
                <h3 style="margin:0;">
                    Semua Notifikasi
                </h3>
            </div>

            @if($notifications->count() > 0)

                <form
                    method="POST"
                    action="{{ route('notifications.readAll') }}"
                >
                    @csrf

                    <button
                        type="submit"
                        class="btn small"
                    >
                        Tandai Semua Dibaca
                    </button>

                </form>

            @endif

        </div>


        {{-- DAFTAR NOTIFIKASI --}}
        @forelse($notifications as $notification)

            @if($notification->url)

                {{-- NOTIFIKASI YANG BISA DIKLIK --}}
                <a
                    href="{{ route('notifications.open', ['notification' => $notification->id]) }}"
                    style="
                        display:block;
                        width:100%;
                        box-sizing:border-box;
                        text-decoration:none;
                        color:inherit;
                        padding:20px;
                        border-bottom:1px solid #e5eaf0;
                        background:{{ $notification->is_read ? '#ffffff' : '#f0f7ff' }};
                        cursor:pointer;
                    "
                >

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:20px;
                    ">

                        <div style="flex:1;">

                            <h4 style="
                                margin:0 0 8px;
                                color:#172033;
                            ">
                                {{ $notification->title }}
                            </h4>

                            <p style="
                                margin:0 0 8px;
                                color:#475569;
                            ">
                                {{ $notification->message }}
                            </p>

                            <small style="
                                color:#64748b;
                            ">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>

                        </div>


                        {{-- LABEL BARU --}}
                        @if(!$notification->is_read)

                            <span style="
                                flex-shrink:0;
                                display:inline-flex;
                                align-items:center;
                                justify-content:center;
                                background:#075eb8;
                                color:#ffffff;
                                padding:6px 12px;
                                border-radius:20px;
                                font-size:12px;
                                font-weight:600;
                                white-space:nowrap;
                            ">
                                Baru
                            </span>

                        @endif

                    </div>

                </a>

            @else

                {{-- NOTIFIKASI TANPA URL --}}
                <div
                    style="
                        padding:20px;
                        border-bottom:1px solid #e5eaf0;
                        background:{{ $notification->is_read ? '#ffffff' : '#f0f7ff' }};
                    "
                >

                    <div style="
                        display:flex;
                        justify-content:space-between;
                        align-items:flex-start;
                        gap:20px;
                    ">

                        <div style="flex:1;">

                            <h4 style="
                                margin:0 0 8px;
                                color:#172033;
                            ">
                                {{ $notification->title }}
                            </h4>

                            <p style="
                                margin:0 0 8px;
                                color:#475569;
                            ">
                                {{ $notification->message }}
                            </p>

                            <small style="
                                color:#64748b;
                            ">
                                {{ $notification->created_at->diffForHumans() }}
                            </small>

                        </div>


                        @if(!$notification->is_read)

                            <form
                                method="POST"
                                action="{{ route(
                                    'notifications.read',
                                    ['notification' => $notification->id]
                                ) }}"
                            >
                                @csrf

                                <button
                                    type="submit"
                                    class="btn small"
                                >
                                    Tandai Dibaca
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @endif

        @empty

            <div style="
                padding:50px 20px;
                text-align:center;
                color:#64748b;
            ">

                <div style="
                    font-size:40px;
                    margin-bottom:10px;
                ">
                    🔔
                </div>

                <h3 style="
                    margin-bottom:5px;
                ">
                    Belum ada notifikasi
                </h3>

                <p style="
                    margin:0;
                ">
                    Notifikasi baru akan muncul di sini.
                </p>

            </div>

        @endforelse


        {{-- PAGINATION --}}
        @if($notifications->hasPages())

            <div style="
                padding:20px;
            ">
                {{ $notifications->links() }}
            </div>

        @endif

    </div>

</div>

@endsection