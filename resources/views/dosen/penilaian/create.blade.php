
@extends('layouts.app')

@section('title', 'Form Penilaian Mahasiswa')

@section('content')
<div class="container penilaian-container">

    <div class="page-heading">
        <div>
            <h1>Form Penilaian Mahasiswa</h1>
            <p>Berikan penilaian akademik berdasarkan hasil evaluasi mahasiswa.</p>
        </div>

        <a href="{{ route('dosen.penilaian.index') }}" class="btn-back">
            Kembali
        </a>
    </div>

    {{-- IDENTITAS MAHASISWA --}}
    <div class="assessment-card">
        <div class="card-heading">
            <h3>Identitas Mahasiswa</h3>
            <p>Informasi mahasiswa yang akan dinilai.</p>
        </div>

        <div class="student-info">
            <div>
                <span>Nama Lengkap</span>
                <strong>{{ $mahasiswa->nama_lengkap }}</strong>
            </div>

            <div>
                <span>NIM</span>
                <strong>{{ $mahasiswa->nim }}</strong>
            </div>

            <div>
                <span>Program Studi</span>
                <strong>{{ $mahasiswa->prodi }}</strong>
            </div>

            <div>
                <span>Semester</span>
                <strong>{{ $mahasiswa->semester }}</strong>
            </div>

            <div>
                <span>IPK</span>
                <strong>{{ $mahasiswa->ipk ?? '-' }}</strong>
            </div>

            <div>
                <span>IPS</span>
                <strong>{{ $mahasiswa->ips ?? '-' }}</strong>
            </div>
        </div>
    </div>

    <form action="{{ route('dosen.penilaian.store', $mahasiswa->id) }}"
          method="POST">
        @csrf

        {{-- NILAI ANGKA --}}
        <div class="assessment-card">
            <div class="card-heading">
                <h3>Penilaian Angka</h3>
                <p>Masukkan nilai akademik mahasiswa secara keseluruhan.</p>
            </div>

            <div class="form-group">
                <label for="nilai_angka">
                    Nilai Angka <span>*</span>
                </label>

                <input type="number"
                       id="nilai_angka"
                       name="nilai_angka"
                       min="0"
                       max="100"
                       step="0.01"
                       value="{{ old('nilai_angka') }}"
                       placeholder="Masukkan nilai 0 - 100"
                       required>

                @error('nilai_angka')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
        </div>

        {{-- ASPEK PENILAIAN --}}
        <div class="assessment-card">
            <div class="card-heading">
                <h3>Aspek Penilaian Akademik</h3>
                <p>Berikan skor pada setiap aspek dengan rentang 0 sampai 100.</p>
            </div>

            <div class="criteria-list">

                @php
                    $criteria = [
                        [
                            'name' => 'prestasi_akademik',
                            'label' => 'Prestasi Akademik',
                            'weight' => 25,
                            'description' => 'Pencapaian nilai dan prestasi akademik mahasiswa.'
                        ],
                        [
                            'name' => 'kedisiplinan',
                            'label' => 'Kedisiplinan',
                            'weight' => 15,
                            'description' => 'Kedisiplinan dalam mengikuti kegiatan perkuliahan.'
                        ],
                        [
                            'name' => 'keaktifan',
                            'label' => 'Keaktifan',
                            'weight' => 15,
                            'description' => 'Keaktifan dalam perkuliahan dan kegiatan akademik.'
                        ],
                        [
                            'name' => 'tanggung_jawab',
                            'label' => 'Tanggung Jawab',
                            'weight' => 15,
                            'description' => 'Tanggung jawab terhadap tugas dan kewajiban akademik.'
                        ],
                        [
                            'name' => 'perkembangan_akademik',
                            'label' => 'Perkembangan Akademik',
                            'weight' => 15,
                            'description' => 'Perkembangan kemampuan dan hasil belajar mahasiswa.'
                        ],
                        [
                            'name' => 'konsultasi_akademik',
                            'label' => 'Konsultasi Akademik',
                            'weight' => 10,
                            'description' => 'Keterlibatan mahasiswa dalam konsultasi akademik.'
                        ],
                        [
                            'name' => 'sikap_etika',
                            'label' => 'Sikap dan Etika',
                            'weight' => 5,
                            'description' => 'Sikap, sopan santun, dan etika selama perkuliahan.'
                        ],
                    ];
                @endphp

                @foreach ($criteria as $index => $criterion)
                    <div class="criteria-item">
                        <div class="criteria-description">
                            <div class="criteria-number">{{ $index + 1 }}</div>

                            <div>
                                <label for="{{ $criterion['name'] }}">
                                    {{ $criterion['label'] }}
                                </label>

                                <p>{{ $criterion['description'] }}</p>
                                <small>Bobot {{ $criterion['weight'] }}%</small>
                            </div>
                        </div>

                        <div class="criteria-input">
                            <input type="number"
                                   id="{{ $criterion['name'] }}"
                                   name="{{ $criterion['name'] }}"
                                   class="criteria-score"
                                   data-weight="{{ $criterion['weight'] }}"
                                   min="0"
                                   max="100"
                                   step="0.01"
                                   value="{{ old($criterion['name']) }}"
                                   placeholder="0 - 100"
                                   required>

                            @error($criterion['name'])
                                <small class="error-message">{{ $message }}</small>
                            @enderror
                        </div>
                    </div>
                @endforeach

            </div>

            <div class="weight-info">
                <span>Total Bobot Penilaian</span>
                <strong>100%</strong>
            </div>
        </div>

        {{-- HASIL PENILAIAN --}}
        <div class="assessment-card result-card">
            <div class="card-heading">
                <h3>Hasil Perhitungan</h3>
                <p>Nilai akan diperbarui otomatis berdasarkan skor yang dimasukkan.</p>
            </div>

            <div class="result-grid">
                <div class="result-item">
                    <span>Nilai Angka</span>
                    <strong id="previewAngka">0.00</strong>
                </div>

                <div class="result-item">
                    <span>Nilai Kriteria</span>
                    <strong id="previewKriteria">0.00</strong>
                </div>

                <div class="result-item final-result">
                    <span>Nilai Akhir</span>
                    <strong id="previewAkhir">0.00</strong>
                </div>
            </div>

            <p class="calculation-note">
                Nilai akhir dihitung dari 50% nilai angka dan 50% nilai kriteria.
            </p>
        </div>

        {{-- CATATAN --}}
        <div class="assessment-card">
            <div class="card-heading">
                <h3>Catatan Evaluasi</h3>
                <p>Tambahkan catatan atau masukan untuk mahasiswa (opsional).</p>
            </div>

            <div class="form-group">
                <label for="catatan">Catatan Dosen</label>

                <textarea id="catatan"
                          name="catatan"
                          rows="4"
                          maxlength="2000"
                          placeholder="Tuliskan catatan evaluasi mahasiswa...">{{ old('catatan') }}</textarea>

                @error('catatan')
                    <small class="error-message">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('dosen.penilaian.index') }}" class="btn-cancel">
                Batal
            </a>

            <button type="submit" class="btn-submit">
                Simpan Penilaian
            </button>
        </div>

    </form>
</div>

<style>
.penilaian-container {
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
    margin: 0 0 7px;
    color: #1e3a5f;
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
}

.assessment-card {
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

.student-info div {
    display: flex;
    flex-direction: column;
    gap: 6px;
}

.student-info span {
    color: #8491a3;
    font-size: 12px;
}

.student-info strong {
    color: #29384d;
    font-size: 14px;
    font-weight: 600;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.form-group label,
.criteria-description label {
    font-size: 13px;
    font-weight: 600;
    color: #34445a;
}

.form-group label span {
    color: #dc4545;
}

.form-group input,
.criteria-input input,
.form-group textarea {
    width: 100%;
    box-sizing: border-box;
    border: 1px solid #dce3eb;
    border-radius: 7px;
    padding: 11px 13px;
    font-family: inherit;
    font-size: 13px;
    color: #34445a;
    background: #fff;
    outline: none;
    transition: border-color .2s, box-shadow .2s;
}

.form-group input:focus,
.criteria-input input:focus,
.form-group textarea:focus {
    border-color: #376da8;
    box-shadow: 0 0 0 3px rgba(55, 109, 168, .1);
}

.criteria-list {
    display: flex;
    flex-direction: column;
}

.criteria-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 25px;
    padding: 17px 0;
    border-bottom: 1px solid #edf0f4;
}

.criteria-item:first-child {
    padding-top: 0;
}

.criteria-item:last-child {
    border-bottom: none;
}

.criteria-description {
    display: flex;
    align-items: flex-start;
    gap: 13px;
    flex: 1;
}

.criteria-number {
    width: 30px;
    height: 30px;
    flex-shrink: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    border-radius: 7px;
    background: #edf3fa;
    color: #1e3a5f;
    font-size: 13px;
    font-weight: 700;
}

.criteria-description label {
    display: block;
    margin-bottom: 5px;
}

.criteria-description p {
    color: #8491a3;
    font-size: 12px;
    margin: 0 0 6px;
}

.criteria-description small {
    color: #376da8;
    font-size: 11px;
    font-weight: 600;
}

.criteria-input {
    width: 155px;
    flex-shrink: 0;
}

.weight-info {
    display: flex;
    justify-content: space-between;
    background: #f3f7fb;
    padding: 13px 15px;
    border-radius: 7px;
    color: #34445a;
    font-size: 13px;
    margin-top: 15px;
}

.weight-info strong {
    color: #1e3a5f;
}

.result-card {
    background: #f9fbfd;
}

.result-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 13px;
}

.result-item {
    background: #fff;
    border: 1px solid #e5eaf0;
    border-radius: 8px;
    padding: 17px;
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.result-item span {
    color: #8491a3;
    font-size: 12px;
}

.result-item strong {
    font-size: 23px;
    color: #1e3a5f;
}

.final-result {
    background: #1e3a5f;
    border-color: #1e3a5f;
}

.final-result span,
.final-result strong {
    color: white;
}

.calculation-note {
    color: #8491a3;
    font-size: 11px;
    margin: 13px 0 0;
}

.form-group textarea {
    resize: vertical;
    min-height: 110px;
}

.form-actions {
    display: flex;
    justify-content: flex-end;
    gap: 10px;
    margin-top: 25px;
}

.btn-cancel,
.btn-submit {
    padding: 11px 20px;
    border-radius: 7px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    cursor: pointer;
}

.btn-cancel {
    color: #536277;
    background: white;
    border: 1px solid #dce3eb;
}

.btn-submit {
    color: white;
    background: #1e3a5f;
    border: 1px solid #1e3a5f;
}

.btn-submit:hover {
    background: #294f7d;
}

.error-message {
    display: block;
    color: #dc4545;
    font-size: 11px;
    margin-top: 5px;
}

@media (max-width: 768px) {
    .penilaian-container {
        padding: 0 12px 25px;
    }

    .page-heading {
        align-items: flex-start;
    }

    .page-heading h1 {
        font-size: 21px;
    }

    .student-info {
        grid-template-columns: repeat(2, 1fr);
        gap: 17px;
    }

    .assessment-card {
        padding: 17px;
    }

    .criteria-item {
        align-items: flex-start;
        flex-direction: column;
        gap: 12px;
    }

    .criteria-input {
        width: 100%;
        padding-left: 43px;
    }

    .result-grid {
        grid-template-columns: 1fr;
    }

    .form-actions {
        flex-direction: column-reverse;
    }

    .btn-cancel,
    .btn-submit {
        text-align: center;
        width: 100%;
        box-sizing: border-box;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const nilaiAngka = document.getElementById('nilai_angka');
    const kriteriaInputs = document.querySelectorAll('.criteria-score');

    const previewAngka = document.getElementById('previewAngka');
    const previewKriteria = document.getElementById('previewKriteria');
    const previewAkhir = document.getElementById('previewAkhir');

    function hitungNilai() {
        let angka = parseFloat(nilaiAngka.value) || 0;
        let totalKriteria = 0;

        kriteriaInputs.forEach(function (input) {
            let nilai = parseFloat(input.value) || 0;
            let bobot = parseFloat(input.dataset.weight) || 0;

            totalKriteria += nilai * (bobot / 100);
        });

        let nilaiAkhir = (angka * 0.50) + (totalKriteria * 0.50);

        previewAngka.textContent = angka.toFixed(2);
        previewKriteria.textContent = totalKriteria.toFixed(2);
        previewAkhir.textContent = nilaiAkhir.toFixed(2);
    }

    nilaiAngka.addEventListener('input', hitungNilai);

    kriteriaInputs.forEach(function (input) {
        input.addEventListener('input', hitungNilai);
    });

    hitungNilai();
});
</script>
@endsection
