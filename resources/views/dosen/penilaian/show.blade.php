
@extends('layouts.app')

@section('title', 'Hasil Penilaian Mahasiswa')

@section('content')
<div class="container result-container">

    {{-- HEADER --}}
    <div class="page-heading">
        <div>
            <h1>Hasil Penilaian Mahasiswa</h1>
            <p>Detail hasil evaluasi akademik mahasiswa.</p>
        </div>

        <a href="{{ route('dosen.penilaian.index') }}" class="btn-back">
            Kembali
        </a>
    </div>

    {{-- IDENTITAS MAHASISWA --}}
    <div class="result-card">
        <div class="card-heading">
            <h3>Identitas Mahasiswa</h3>
            <p>Informasi mahasiswa yang telah dinilai.</p>
        </div>

        <div class="student-info">
            <div>
                <span>Nama Lengkap</span>
                <strong>{{ $penilaian->mahasiswa->nama_lengkap ?? '-' }}</strong>
            </div>

            <div>
                <span>NIM</span>
                <strong>{{ $penilaian->mahasiswa->nim ?? '-' }}</strong>
            </div>

            <div>
                <span>Program Studi</span>
                <strong>{{ $penilaian->mahasiswa->prodi ?? '-' }}</strong>
            </div>

            <div>
                <span>Semester</span>
                <strong>{{ $penilaian->mahasiswa->semester ?? '-' }}</strong>
            </div>

            <div>
                <span>IPK</span>
                <strong>{{ $penilaian->mahasiswa->ipk ?? '-' }}</strong>
            </div>

            <div>
                <span>IPS</span>
                <strong>{{ $penilaian->mahasiswa->ips ?? '-' }}</strong>
            </div>
        </div>
    </div>

    {{-- RINGKASAN NILAI --}}
    <div class="result-card">
        <div class="card-heading">
            <h3>Ringkasan Hasil Penilaian</h3>
            <p>Rekapitulasi nilai berdasarkan hasil evaluasi dosen.</p>
        </div>

        <div class="score-grid">
            <div class="score-box">
                <span>Nilai Angka</span>
                <strong>{{ number_format($penilaian->nilai_angka, 2) }}</strong>
                <small>Bobot 50%</small>
            </div>

            <div class="score-box">
                <span>Nilai Kriteria</span>
                <strong>{{ number_format($penilaian->nilai_kriteria, 2) }}</strong>
                <small>Bobot 50%</small>
            </div>

            <div class="score-box score-final">
                <span>Nilai Akhir</span>
                <strong>{{ number_format($penilaian->nilai_akhir, 2) }}</strong>
                <small>Hasil Penilaian</small>
            </div>
        </div>

        <div class="formula-info">
            <strong>Rumus Perhitungan</strong>
            <p>
                Nilai Akhir = (Nilai Angka × 50%) +
                (Nilai Kriteria × 50%)
            </p>
        </div>
    </div>

    {{-- DETAIL KRITERIA --}}
    <div class="result-card">
        <div class="card-heading">
            <h3>Rincian Aspek Penilaian</h3>
            <p>Nilai setiap aspek beserta bobot yang digunakan.</p>
        </div>

        <div class="criteria-table-wrapper">
            <table class="criteria-table">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Aspek Penilaian</th>
                        <th>Bobot</th>
                        <th>Nilai</th>
                        <th>Nilai Terbobot</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                        $criteria = [
                            ['label' => 'Prestasi Akademik', 'field' => 'prestasi_akademik', 'weight' => 25],
                            ['label' => 'Kedisiplinan', 'field' => 'kedisiplinan', 'weight' => 15],
                            ['label' => 'Keaktifan', 'field' => 'keaktifan', 'weight' => 15],
                            ['label' => 'Tanggung Jawab', 'field' => 'tanggung_jawab', 'weight' => 15],
                            ['label' => 'Perkembangan Akademik', 'field' => 'perkembangan_akademik', 'weight' => 15],
                            ['label' => 'Konsultasi Akademik', 'field' => 'konsultasi_akademik', 'weight' => 10],
                            ['label' => 'Sikap dan Etika', 'field' => 'sikap_etika', 'weight' => 5],
                        ];
                    @endphp

                    @foreach ($criteria as $index => $criterion)
                        @php
                            $nilai = (float) $penilaian->{$criterion['field']};
                            $terbobot = $nilai * ($criterion['weight'] / 100);
                        @endphp

                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td class="criteria-name">{{ $criterion['label'] }}</td>
                            <td>{{ $criterion['weight'] }}%</td>
                            <td>{{ number_format($nilai, 2) }}</td>
                            <td>{{ number_format($terbobot, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot>
                    <tr>
                        <td colspan="2">Total</td>
                        <td>100%</td>
                        <td>-</td>
                        <td>{{ number_format($penilaian->nilai_kriteria, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

    {{-- CATATAN DOSEN --}}
    <div class="result-card">
        <div class="card-heading">
            <h3>Catatan Evaluasi Dosen</h3>
            <p>Masukan dan keterangan tambahan mengenai mahasiswa.</p>
        </div>

        <div class="notes-content">
            @if ($penilaian->catatan)
                {{ $penilaian->catatan }}
            @else
                <span class="empty-notes">Tidak ada catatan evaluasi.</span>
            @endif
        </div>
    </div>

    {{-- WAKTU PENILAIAN --}}
    <div class="result-card date-card">
        <div>
            <span>Tanggal Penilaian</span>
            <strong>
                {{ $penilaian->created_at
                    ? $penilaian->created_at->format('d/m/Y H:i')
                    : '-' }}
            </strong>
        </div>
    </div>

</div>

<style>
.result-container {
    max-width: 1100px;
    margin: 0 auto;
    padding-bottom: 35px;
    color: #243247;
}

.page-heading {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 15px;
    margin-bottom: 25px;
}

.page-heading h1 {
    font-size: 25px;
    font-weight: 700;
    color: #1e3a5f;
    margin: 0 0 7px;
}

.page-heading p,
.card-heading p {
    margin: 0;
    color: #718096;
    font-size: 13px;
}

.btn-back {
    padding: 10px 17px;
    border: 1px solid #dbe3ed;
    border-radius: 7px;
    text-decoration: none;
    color: #1e3a5f;
    font-size: 13px;
    font-weight: 600;
    background: white;
    white-space: nowrap;
}

.result-card {
    background: #fff;
    border: 1px solid #e5eaf0;
    border-radius: 11px;
    padding: 23px;
    margin-bottom: 20px;
    box-shadow: 0 3px 12px rgba(30, 58, 95, 0.04);
}

.card-heading {
    margin-bottom: 22px;
}

.card-heading h3 {
    font-size: 17px;
    font-weight: 700;
    color: #1e3a5f;
    margin: 0 0 6px;
}

.student-info {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 20px;
}

.student-info div,
.date-card div {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.student-info span,
.date-card span {
    color: #8491a3;
    font-size: 12px;
}

.student-info strong,
.date-card strong {
    color: #29384d;
    font-size: 14px;
    font-weight: 600;
}

.score-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 14px;
}

.score-box {
    display: flex;
    flex-direction: column;
    gap: 9px;
    padding: 19px;
    border: 1px solid #e5eaf0;
    border-radius: 9px;
    background: #f9fbfd;
}

.score-box span {
    color: #718096;
    font-size: 12px;
}

.score-box strong {
    color: #1e3a5f;
    font-size: 27px;
    font-weight: 700;
}

.score-box small {
    color: #8491a3;
    font-size: 11px;
}

.score-final {
    background: #1e3a5f;
    border-color: #1e3a5f;
}

.score-final span,
.score-final strong,
.score-final small {
    color: white;
}

.formula-info {
    margin-top: 17px;
    padding: 14px 16px;
    border-radius: 8px;
    background: #f3f7fb;
}

.formula-info strong {
    color: #1e3a5f;
    font-size: 12px;
}

.formula-info p {
    margin: 7px 0 0;
    color: #52647a;
    font-size: 12px;
}

.criteria-table-wrapper {
    width: 100%;
    overflow-x: auto;
}

.criteria-table {
    width: 100%;
    border-collapse: collapse;
    min-width: 600px;
}

.criteria-table th {
    padding: 13px 14px;
    background: #f3f6fa;
    color: #52647a;
    font-size: 12px;
    font-weight: 700;
    text-align: left;
    white-space: nowrap;
}

.criteria-table td {
    padding: 14px;
    border-bottom: 1px solid #edf0f4;
    color: #52647a;
    font-size: 13px;
}

.criteria-table tbody tr:last-child td {
    border-bottom: none;
}

.criteria-table .criteria-name {
    color: #29384d;
    font-weight: 600;
}

.criteria-table tfoot td {
    background: #f3f7fb;
    color: #1e3a5f;
    font-weight: 700;
    border-top: 1px solid #e5eaf0;
}

.notes-content {
    padding: 15px;
    border-radius: 8px;
    background: #f9fbfd;
    border: 1px solid #e8edf3;
    color: #52647a;
    font-size: 13px;
    line-height: 1.7;
    white-space: pre-line;
    overflow-wrap: anywhere;
}

.empty-notes {
    color: #9aa5b3;
    font-style: italic;
}

.date-card {
    background: #f9fbfd;
}

@media (max-width: 768px) {
    .result-container {
        padding: 0 12px 25px;
    }

    .page-heading {
        align-items: flex-start;
    }

    .page-heading h1 {
        font-size: 21px;
    }

    .result-card {
        padding: 17px;
    }

    .student-info {
        grid-template-columns: repeat(2, 1fr);
        gap: 17px;
    }

    .score-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection
