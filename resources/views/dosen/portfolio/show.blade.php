
@extends('layouts.app')

@section('title', 'Detail Portfolio')

@section('content')
<div class="container">

    <div class="page-title">
        <h1>Detail Portfolio</h1>
        <p>Informasi kegiatan dan bukti portfolio mahasiswa.</p>
    </div>

    <div class="card">

        <h3>Informasi Mahasiswa</h3>

        <table class="table">
            <tr>
                <th>Nama Mahasiswa</th>
                <td>{{ $portfolio->mahasiswa->nama_lengkap ?? '-' }}</td>
            </tr>

            <tr>
                <th>NIM</th>
                <td>{{ $portfolio->mahasiswa->nim ?? '-' }}</td>
            </tr>

            <tr>
                <th>Program Studi</th>
                <td>{{ $portfolio->mahasiswa->prodi ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <h3>Informasi Portfolio</h3>

        <table class="table">
            <tr>
                <th>Nama Kegiatan</th>
                <td>{{ $portfolio->nama_kegiatan }}</td>
            </tr>

            <tr>
                <th>Posisi</th>
                <td>{{ $portfolio->posisi ?? '-' }}</td>
            </tr>

            <tr>
                <th>Organisasi</th>
                <td>{{ $portfolio->organisasi ?? '-' }}</td>
            </tr>

            <tr>
                <th>Periode Mulai</th>
                <td>
                    {{ $portfolio->periode_mulai ? $portfolio->periode_mulai->format('d M Y') : '-' }}
                </td>
            </tr>

            <tr>
                <th>Periode Selesai</th>
                <td>
                    {{ $portfolio->periode_selesai ? $portfolio->periode_selesai->format('d M Y') : '-' }}
                </td>
            </tr>

            <tr>
                <th>Deskripsi</th>
                <td>{{ $portfolio->deskripsi ?? '-' }}</td>
            </tr>
        </table>

        <hr>

        <h3>Bukti Portfolio</h3>

        @if($portfolio->bukti)

            @php
                $extension = strtolower(pathinfo(
                    $portfolio->bukti,
                    PATHINFO_EXTENSION
                ));

                $previewUrl = route(
                    'dosen.portfolio.preview',
                    $portfolio->id
                );
            @endphp

            @if(in_array($extension, ['jpg', 'jpeg', 'png', 'webp']))
                <div style="margin-top: 15px;">
                    <a href="{{ $previewUrl }}" target="_blank">
                        <img
                            src="{{ $previewUrl }}"
                            alt="Bukti Portfolio"
                            style="max-width: 100%; max-height: 400px; border-radius: 8px;"
                        >
                    </a>
                </div>

            @elseif($extension === 'pdf')
                <div style="margin-top: 15px;">
                    <iframe
                        src="{{ $previewUrl }}"
                        width="100%"
                        height="500"
                        style="border: 1px solid #ddd; border-radius: 8px;">
                    </iframe>
                </div>
            @else
                <p>File bukti tersedia. Gunakan tombol di bawah untuk membukanya.</p>
            @endif

            <div style="display: flex; gap: 10px; flex-wrap: wrap; margin-top: 15px;">

                <a href="{{ $previewUrl }}"
                   target="_blank"
                   class="btn btn-primary">
                    Lihat Bukti
                </a>

                <a href="{{ route('dosen.portfolio.download', $portfolio->id) }}"
                   class="btn">
                    Download Bukti
                </a>

            </div>

        @else
            <p style="color: #777;">
                Belum ada bukti portfolio yang diunggah.
            </p>
        @endif

    </div>

    <div style="margin-top: 20px;">
        <a href="{{ route('dosen.portfolio.index') }}" class="btn">
            Kembali ke Portfolio
        </a>
    </div>

</div>
@endsection