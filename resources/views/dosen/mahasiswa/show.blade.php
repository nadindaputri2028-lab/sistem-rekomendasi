
@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container">

    <div class="page-title">
        <h1>Detail Mahasiswa</h1>
        <p>Informasi profil akademik dan portfolio mahasiswa.</p>
    </div>

    {{-- PROFIL MAHASISWA --}}
    <div class="card" style="padding:25px; margin-bottom:20px;">

        <div style="display:flex; align-items:center; gap:22px; flex-wrap:wrap;">

            @if($mahasiswa->foto)
                <img
                    src="{{ asset('storage/' . $mahasiswa->foto) }}"
                    alt="Foto Mahasiswa"
                    style="width:115px;height:115px;object-fit:cover;border-radius:50%;border:4px solid #eaf1fb;"
                >
            @else
                <div style="width:115px;height:115px;border-radius:50%;background:#eaf1fb;display:flex;align-items:center;justify-content:center;font-size:40px;color:#1e3a5f;font-weight:bold;">
                    {{ strtoupper(substr($mahasiswa->nama_lengkap, 0, 1)) }}
                </div>
            @endif

            <div>
                <h2 style="margin:0 0 8px;color:#1e3a5f;">
                    {{ $mahasiswa->nama_lengkap }}
                </h2>

                <p style="margin:4px 0;color:#64748b;">
                    NIM: {{ $mahasiswa->nim }}
                </p>

                <p style="margin:4px 0;color:#64748b;">
                    {{ $mahasiswa->prodi ?? '-' }}
                </p>

                <span style="display:inline-block;margin-top:8px;padding:5px 12px;background:#eaf1fb;color:#1e3a5f;border-radius:20px;font-size:12px;font-weight:600;">
                    Semester {{ $mahasiswa->semester ?? '-' }}
                </span>
            </div>

        </div>
    </div>

    {{-- INFORMASI AKADEMIK --}}
    <div class="card" style="margin-bottom:20px;">

        <h3 style="color:#1e3a5f;margin-bottom:20px;">
            Informasi Mahasiswa
        </h3>

        <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:15px;">

            @foreach([
                'Nama Lengkap' => $mahasiswa->nama_lengkap,
                'NIM' => $mahasiswa->nim,
                'Program Studi' => $mahasiswa->prodi,
                'Semester' => $mahasiswa->semester,
                'Email' => $mahasiswa->email,
                'Nomor HP' => $mahasiswa->no_hp,
                'IPK' => $mahasiswa->ipk,
                'IPS' => $mahasiswa->ips,
            ] as $label => $value)

                <div style="padding:15px;background:#f8fafc;border:1px solid #e5e7eb;border-radius:9px;">
                    <small style="color:#64748b;">{{ $label }}</small>
                    <div style="font-weight:600;color:#1e293b;margin-top:6px;overflow-wrap:anywhere;">
                        {{ $value ?? '-' }}
                    </div>
                </div>

            @endforeach

        </div>

        <div style="margin-top:20px;">
            <h4>Prestasi</h4>
            <p>{{ $mahasiswa->prestasi ?: '-' }}</p>

            <h4>Keahlian</h4>
            <p>{{ $mahasiswa->keahlian ?: '-' }}</p>

            <h4>Minat</h4>
            <p>{{ $mahasiswa->minat ?: '-' }}</p>
        </div>

    </div>

    {{-- PORTFOLIO --}}
    <div class="card">

        <h3 style="color:#1e3a5f;">Portfolio Mahasiswa</h3>
        <p style="color:#64748b;">
            Daftar kegiatan, pengalaman, dan bukti portfolio mahasiswa.
        </p>

        @forelse($mahasiswa->portfolios as $p)

            <div style="border:1px solid #e5e7eb;border-radius:10px;padding:20px;margin-top:16px;">

                <h4 style="color:#1e3a5f;margin-top:0;">
                    {{ $p->nama_kegiatan }}
                </h4>

                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:12px;">

                    <div>
                        <small style="color:#64748b;">Posisi</small>
                        <p>{{ $p->posisi ?? '-' }}</p>
                    </div>

                    <div>
                        <small style="color:#64748b;">Organisasi</small>
                        <p>{{ $p->organisasi ?? '-' }}</p>
                    </div>

                    <div>
                        <small style="color:#64748b;">Periode</small>
                        <p>
                            {{ $p->periode_mulai?->format('d M Y') ?? '-' }}
                            -
                            {{ $p->periode_selesai?->format('d M Y') ?? '-' }}
                        </p>
                    </div>

                </div>

                <div>
                    <strong>Deskripsi</strong>
                    <p>{{ $p->deskripsi ?: '-' }}</p>
                </div>

                @if($p->bukti)

                    @php
                        $extension = strtolower(pathinfo($p->bukti, PATHINFO_EXTENSION));
                    @endphp

                    <div style="margin-top:15px;">
                        <strong>Bukti Portfolio</strong>

                        @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                            <div style="margin-top:10px;">
                                <a href="{{ route('dosen.portfolio.bukti.preview', $p) }}" target="_blank">
                                    <img
                                        src="{{ route('dosen.portfolio.bukti.preview', $p) }}"
                                        alt="Bukti Portfolio"
                                        style="max-width:100%;max-height:300px;object-fit:contain;border-radius:8px;border:1px solid #e5e7eb;"
                                    >
                                </a>
                            </div>

                        @elseif($extension === 'pdf')
                            <iframe
                                src="{{ route('dosen.portfolio.bukti.preview', $p) }}"
                                width="100%"
                                height="400"
                                style="margin-top:10px;border:1px solid #e5e7eb;border-radius:8px;"
                            ></iframe>
                        @endif

                        <div style="display:flex;gap:10px;flex-wrap:wrap;margin-top:12px;">

                            <a href="{{ route('dosen.portfolio.bukti.preview', $p) }}"
                               target="_blank"
                               class="btn btn-primary">
                                Lihat Bukti
                            </a>

                            <a href="{{ route('dosen.portfolio.bukti.download', $p) }}"
                               class="btn">
                                Download Bukti
                            </a>

                        </div>
                    </div>

                @else
                    <p style="color:#94a3b8;margin-top:12px;">
                        Belum ada bukti portfolio.
                    </p>
                @endif

            </div>

        @empty

            <div style="text-align:center;padding:30px;color:#64748b;">
                Belum ada portfolio mahasiswa.
            </div>

        @endforelse

    </div>

    <div style="margin-top:20px;">
        <a href="{{ route('dosen.mahasiswa.index') }}" class="btn">
            Kembali ke Data Mahasiswa
        </a>
    </div>

</div>
@endsection
