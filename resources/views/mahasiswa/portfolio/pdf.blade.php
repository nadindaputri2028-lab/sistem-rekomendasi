<!doctype html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Portofolio {{ $m->nama_lengkap }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            color: #172033;
            margin: 24px;
        }

        h2 {
            text-align: center;
            margin-bottom: 4px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 20px;
        }

        .identitas {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .identitas td {
            padding: 4px 6px;
            vertical-align: top;
        }

        .identitas td.label {
            width: 140px;
            font-weight: bold;
        }

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th,
        table.data td {
            border: 1px solid #aaa;
            padding: 7px;
            text-align: left;
            vertical-align: top;
        }

        table.data th {
            background: #f1f5f9;
        }

        button {
            padding: 8px 14px;
            margin-bottom: 12px;
            cursor: pointer;
        }

        @media print {
            button {
                display: none;
            }

            body {
                margin: 0;
            }
        }
    </style>
</head>
<body>
    <button onclick="window.print()">Cetak / Simpan PDF</button>

    <h2>Portofolio Mahasiswa</h2>
    <div class="subtitle">Sistem Rekomendasi Lomba Mahasiswa</div>

    <table class="identitas">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $m->nama_lengkap }}</td>
        </tr>
        <tr>
            <td class="label">NIM</td>
            <td>: {{ $m->nim }}</td>
        </tr>
        <tr>
            <td class="label">Program Studi</td>
            <td>: {{ $m->prodi }}</td>
        </tr>
        <tr>
            <td class="label">Semester</td>
            <td>: {{ $m->semester }}</td>
        </tr>
        <tr>
            <td class="label">IPK / IPS</td>
            <td>: {{ number_format($m->ipk ?? 0, 2) }} / {{ number_format($m->ips ?? 0, 2) }}</td>
        </tr>
        <tr>
            <td class="label">Email</td>
            <td>: {{ $m->email }}</td>
        </tr>
        <tr>
            <td class="label">No. HP</td>
            <td>: {{ $m->no_hp ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label">Prestasi</td>
            <td>: {{ $m->prestasi ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Keahlian</td>
            <td>: {{ $m->keahlian ?: '-' }}</td>
        </tr>
        <tr>
            <td class="label">Minat</td>
            <td>: {{ $m->minat ?: '-' }}</td>
        </tr>
    </table>

    <h3>Daftar Pengalaman / Kegiatan</h3>

    <table class="data">
        <thead>
            <tr>
                <th style="width: 28px;">No</th>
                <th>Nama Kegiatan</th>
                <th>Posisi</th>
                <th>Organisasi</th>
                <th>Periode</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($portfolios as $i => $p)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $p->nama_kegiatan }}</td>
                    <td>{{ $p->posisi ?? '-' }}</td>
                    <td>{{ $p->organisasi ?? '-' }}</td>
                    <td>
                        {{ $p->periode_mulai?->format('M Y') ?? '-' }}
                        -
                        {{ $p->periode_selesai?->format('M Y') ?? 'Sekarang' }}
                    </td>
                    <td>{{ $p->deskripsi ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" style="text-align: center;">
                        Belum ada data portofolio.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 24px; color: #94a3b8; font-size: 10px;">
        Dicetak pada {{ now()->format('d M Y H:i') }}
    </p>
</body>
</html>
