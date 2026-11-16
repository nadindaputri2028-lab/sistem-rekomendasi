
@extends('layouts.app')

@section('title', 'Detail Mahasiswa')

@section('content')
<div class="container">

    <div class="page-title">
        <h1>Detail Mahasiswa</h1>
        <p>Informasi lengkap profil dan portfolio mahasiswa.</p>
    </div>

    {{-- PROFIL --}}
    <div class="card" style="padding:25px;margin-bottom:20px;">

        <div style="display:flex;align-items:center;gap:22px;flex-wrap:wrap;">

            @if($mahasiswa->foto)
                <img
                    src="{{ asset('storage/' . $mahasiswa->foto) }}"
                    alt="Foto Mahasiswa"
                    style="width:115px;height:115px;object-fit:cover;border-radius:50%;border:4px solid #eaf1fb;"
                >
            @else
                <div style="width:115px;height:115px;border-radius:50%;background:#eaf1fb;display:flex;align-items:center;justify-content:center;font-size:40px;font-weight:bold;color:#1e3a5f;">
                    {{ strtoupper(substr($mahasiswa->nama_lengkap, 0, 1)) }}
                </div>
            @endif

            <div style="flex:1;">
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

            <a href="{{ route('staff.mahasiswa.edit', $mahasiswa) }}"
               class="btn btn-primary">
                Edit Profil
            </a>

        </div>
    </div>

    {{-- INFORMASI --}}
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

        <div style="display:flex;justify-content:space-between;align-items:center;gap:15px;flex-wrap:wrap;margin-bottom:15px;">

            <div>
                <h3 style="color:#1e3a5f;margin:0;">
                    Portfolio Mahasiswa
                </h3>
                <p style="color:#64748b;margin-top:6px;">
                    Riwayat kegiatan dan pengalaman mahasiswa.
                </p>
            </div>

            <a
                class="btn btn-primary"
                target="_blank"
                href="{{ route('staff.mahasiswa.portfolio.pdf', $mahasiswa) }}"
            >
                Cetak Portfolio PDF
            </a>

        </div>

        <div style="overflow-x:auto;">

            <table class="table">
                <thead>
                    <tr>
                        <th>KEGIATAN</th>
                        <th>POSISI</th>
                        <th>ORGANISASI</th>
                        <th>PERIODE</th>
                        <th>BUKTI</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($mahasiswa->portfolios as $p)

                        <tr>
                            <td>
                                <strong>{{ $p->nama_kegiatan }}</strong>
                                <br>
                                <small style="color:#64748b;">
                                    {{ $p->deskripsi }}
                                </small>
                            </td>

                            <td>{{ $p->posisi ?? '-' }}</td>

                            <td>{{ $p->organisasi ?? '-' }}</td>

                            <td>
                                {{ $p->periode_mulai?->format('M Y') ?? '-' }}
                                -
                                {{ $p->periode_selesai?->format('M Y') ?? 'Sekarang' }}
                            </td>

                            <td>
                                @if($p->bukti)

                                    <div style="display:flex;gap:7px;flex-wrap:wrap;">

                                        <a href="{{ route('staff.portfolio.bukti.preview', $p) }}"
                                           target="_blank"
                                           class="btn small outline">
                                            Lihat
                                        </a>

                                        <a href="{{ route('staff.portfolio.bukti', $p) }}"
                                           class="btn small">
                                            Download
                                        </a>

                                    </div>

                                @else
                                    <span style="color:#94a3b8;">Tidak tersedia</span>
                                @endif
                            </td>
                        </tr>

                    @empty

                        <tr>
                            <td colspan="5" style="text-align:center;padding:25px;color:#64748b;">
                                Mahasiswa belum memiliki portfolio.
                            </td>
                        </tr>

                    @endforelse

                </tbody>
            </table>

        </div>

    </div>

    <div style="margin-top:20px;">
        <a href="{{ route('staff.mahasiswa.index') }}" class="btn">
            Kembali ke Data Mahasiswa
        </a>
    </div>

</div>
@endsection
