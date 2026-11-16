
@extends('layouts.app')

@section('title', 'Kriteria Lomba')

@section('content')

<div class="container staff-kriteria-page">

    {{-- BOX JUDUL --}}
    <div class="kriteria-heading">
        <div>
            <span class="kriteria-heading-label">MANAJEMEN DATA</span>
            <h1>Kriteria Lomba</h1>
            <p>
                Tentukan kriteria, bobot, dan atribut yang digunakan
                dalam perhitungan AHP + SAW.
            </p>
        </div>
    </div>

    {{-- PILIH LOMBA --}}
    <div class="kriteria-card kriteria-selection">

        <div class="kriteria-card-heading">
            <h3>Pilih Lomba</h3>
            <p>Pilih kompetisi untuk mengelola kriteria penilaian.</p>
        </div>

        <form method="GET" action="{{ route('staff.kriteria.index') }}">

            <div class="kriteria-select-form">

                <select
                    name="lomba_id"
                    class="kriteria-select"
                    required
                >
                    <option value="">Pilih Lomba</option>

                    @foreach($lombas as $item)
                        <option
                            value="{{ $item->id }}"
                            @selected($lomba && $lomba->id == $item->id)
                        >
                            {{ $item->nama }}
                        </option>
                    @endforeach

                </select>

                <button type="submit" class="kriteria-primary-btn">
                    Tampilkan
                </button>

            </div>

        </form>

    </div>

    @if($lomba)

        {{-- INFORMASI LOMBA --}}
        <div class="kriteria-info-card">

            <div class="kriteria-info-icon">L</div>

            <div>
                <span class="kriteria-info-label">LOMBA TERPILIH</span>
                <h3>{{ $lomba->nama }}</h3>
                <p>
                    Tambahkan dan kelola kriteria khusus untuk lomba ini.
                </p>
            </div>

        </div>

        {{-- FORM TAMBAH KRITERIA --}}
        <div class="kriteria-card kriteria-form-card">

            <div class="kriteria-card-heading">
                <h3>Tambah Kriteria</h3>
                <p>
                    Masukkan informasi kriteria yang akan digunakan
                    dalam proses penilaian lomba.
                </p>
            </div>

            <form
                method="POST"
                action="{{ route('staff.kriteria.store') }}"
            >

                @csrf

                <input
                    type="hidden"
                    name="lomba_id"
                    value="{{ $lomba->id }}"
                >

                <div class="kriteria-grid">

                    <div class="kriteria-field">
                        <label for="kode">Kode Kriteria</label>
                        <input
                            type="text"
                            id="kode"
                            name="kode"
                            placeholder="Contoh: C1"
                            value="{{ old('kode') }}"
                            required
                        >
                    </div>

                    <div class="kriteria-field">
                        <label for="nama">Nama Kriteria</label>
                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="Contoh: IPK"
                            value="{{ old('nama') }}"
                            required
                        >
                    </div>

                    <div class="kriteria-field">
                        <label for="bobot">Bobot AHP Awal</label>
                        <input
                            type="number"
                            id="bobot"
                            name="bobot"
                            step="0.01"
                            min="0"
                            placeholder="Contoh: 0.25"
                            value="{{ old('bobot') }}"
                            required
                        >
                    </div>

                    <div class="kriteria-field">
                        <label for="jenis">Jenis Atribut</label>
                        <select id="jenis" name="jenis" required>
                            <option value="benefit" @selected(old('jenis', 'benefit') === 'benefit')>
                                Benefit
                            </option>
                            <option value="cost" @selected(old('jenis') === 'cost')>
                                Cost
                            </option>
                        </select>
                    </div>

                    <div class="kriteria-field">
                        <label for="nilai_minimum">Nilai Minimum</label>
                        <input
                            type="number"
                            id="nilai_minimum"
                            name="nilai_minimum"
                            step="0.01"
                            min="0"
                            value="{{ old('nilai_minimum', 0) }}"
                        >
                    </div>

                </div>

                <div class="kriteria-field kriteria-description">
                    <label for="deskripsi">Deskripsi</label>
                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        placeholder="Jelaskan kriteria..."
                    >{{ old('deskripsi') }}</textarea>
                </div>

                <button type="submit" class="kriteria-primary-btn">
                    + Simpan Kriteria
                </button>

            </form>

        </div>

        {{-- DAFTAR KRITERIA --}}
        <div class="kriteria-card kriteria-table-card">

            <div class="kriteria-table-header">
                <div>
                    <h3>Daftar Kriteria</h3>
                    <p>
                        Kriteria yang digunakan untuk lomba
                        {{ $lomba->nama }}.
                    </p>
                </div>

                <span class="kriteria-count">
                    {{ $kriterias->count() }} Kriteria
                </span>
            </div>

            <div class="kriteria-table-wrapper">

                <table class="kriteria-table">

                    <thead>
                        <tr>
                            <th>KODE</th>
                            <th>KRITERIA</th>
                            <th>BOBOT</th>
                            <th>JENIS</th>
                            <th>MINIMUM</th>
                            <th>AKSI</th>
                        </tr>
                    </thead>

                    <tbody>

                        @forelse($kriterias as $kriteria)

                            <tr>

                                <td>
                                    <span class="kriteria-code">
                                        {{ $kriteria->kode }}
                                    </span>
                                </td>

                                <td>
                                    <div class="kriteria-name">
                                        <strong>{{ $kriteria->nama }}</strong>

                                        @if($kriteria->deskripsi)
                                            <small>{{ $kriteria->deskripsi }}</small>
                                        @endif
                                    </div>
                                </td>

                                <td>
                                    <strong class="kriteria-weight">
                                        {{ $kriteria->bobot }}
                                    </strong>
                                </td>

                                <td>
                                    @if($kriteria->jenis === 'benefit')
                                        <span class="kriteria-type benefit">
                                            Benefit
                                        </span>
                                    @else
                                        <span class="kriteria-type cost">
                                            Cost
                                        </span>
                                    @endif
                                </td>

                                <td>
                                    {{ $kriteria->nilai_minimum }}
                                </td>

                                <td>
                                    <div class="kriteria-actions">

                                        <button
                                            type="button"
                                            class="kriteria-action detail js-detail-kriteria"
                                            data-id="{{ $kriteria->id }}"
                                            data-kode="{{ $kriteria->kode }}"
                                            data-nama="{{ $kriteria->nama }}"
                                            data-bobot="{{ $kriteria->bobot }}"
                                            data-jenis="{{ $kriteria->jenis }}"
                                            data-minimum="{{ $kriteria->nilai_minimum }}"
                                            data-deskripsi="{{ $kriteria->deskripsi }}"
                                        >
                                            Detail
                                        </button>

                                        <button
                                            type="button"
                                            class="kriteria-action edit js-edit-kriteria"
                                            data-id="{{ $kriteria->id }}"
                                            data-kode="{{ $kriteria->kode }}"
                                            data-nama="{{ $kriteria->nama }}"
                                            data-bobot="{{ $kriteria->bobot }}"
                                            data-jenis="{{ $kriteria->jenis }}"
                                            data-minimum="{{ $kriteria->nilai_minimum }}"
                                            data-deskripsi="{{ $kriteria->deskripsi }}"
                                        >
                                            Edit
                                        </button>

                                        <form
                                            method="POST"
                                            action="{{ route('staff.kriteria.destroy', $kriteria) }}"
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="kriteria-action delete"
                                                data-confirm="Hapus kriteria ini?"
                                            >
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="6">
                                    <div class="kriteria-empty">
                                        <div class="empty-icon">!</div>
                                        <strong>Belum Ada Kriteria</strong>
                                        <p>
                                            Belum ada kriteria untuk lomba
                                            {{ $lomba->nama }}.
                                        </p>
                                    </div>
                                </td>
                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    @else

        <div class="kriteria-empty-card">
            <div class="empty-icon">!</div>
            <strong>Belum Ada Lomba Dipilih</strong>
            <p>
                Silakan pilih lomba terlebih dahulu untuk mengelola kriteria.
            </p>
        </div>

    @endif

</div>


{{-- MODAL DETAIL KRITERIA --}}
<div id="modalDetailKriteria" class="kriteria-modal-overlay">

    <div class="kriteria-modal-box">

        <div class="kriteria-modal-head">
            <div>
                <span class="modal-label">INFORMASI KRITERIA</span>
                <h3>Detail Kriteria</h3>
            </div>

            <button
                type="button"
                class="kriteria-modal-close"
                id="kriteriaDetailModalClose"
            >
                &times;
            </button>
        </div>

        <div class="kriteria-detail-content">

            <div class="detail-row">
                <strong>Kode</strong>
                <span id="detail_kode"></span>
            </div>

            <div class="detail-row">
                <strong>Nama Kriteria</strong>
                <span id="detail_nama"></span>
            </div>

            <div class="detail-row">
                <strong>Bobot AHP</strong>
                <span id="detail_bobot"></span>
            </div>

            <div class="detail-row">
                <strong>Jenis</strong>
                <span id="detail_jenis"></span>
            </div>

            <div class="detail-row">
                <strong>Nilai Minimum</strong>
                <span id="detail_minimum"></span>
            </div>

            <div class="detail-row">
                <strong>Deskripsi</strong>
                <p id="detail_deskripsi"></p>
            </div>

        </div>

    </div>

</div>


{{-- MODAL EDIT KRITERIA --}}
<div id="modalEditKriteria" class="kriteria-modal-overlay">

    <div class="kriteria-modal-box">

        <div class="kriteria-modal-head">
            <div>
                <span class="modal-label">PENGELOLAAN DATA</span>
                <h3>Edit Kriteria</h3>
            </div>

            <button
                type="button"
                class="kriteria-modal-close"
                id="kriteriaModalClose"
            >
                &times;
            </button>
        </div>

        <form
            method="POST"
            id="formEditKriteria"
            action=""
        >
            @csrf
            @method('PUT')

            <div class="kriteria-grid">

                <div class="kriteria-field">
                    <label for="edit_kode">Kode</label>
                    <input
                        type="text"
                        id="edit_kode"
                        name="kode"
                        maxlength="10"
                        required
                    >
                </div>

                <div class="kriteria-field">
                    <label for="edit_nama">Nama Kriteria</label>
                    <input
                        type="text"
                        id="edit_nama"
                        name="nama"
                        required
                    >
                </div>

                <div class="kriteria-field">
                    <label for="edit_bobot">Bobot AHP</label>
                    <input
                        type="number"
                        id="edit_bobot"
                        name="bobot"
                        step="0.01"
                        min="0"
                        required
                    >
                </div>

                <div class="kriteria-field">
                    <label for="edit_jenis">Jenis</label>
                    <select id="edit_jenis" name="jenis" required>
                        <option value="benefit">Benefit</option>
                        <option value="cost">Cost</option>
                    </select>
                </div>

                <div class="kriteria-field">
                    <label for="edit_nilai_minimum">Nilai Minimum</label>
                    <input
                        type="number"
                        id="edit_nilai_minimum"
                        name="nilai_minimum"
                        step="0.01"
                        min="0"
                    >
                </div>

            </div>

            <div class="kriteria-field kriteria-description">
                <label for="edit_deskripsi">Deskripsi</label>
                <textarea
                    id="edit_deskripsi"
                    name="deskripsi"
                    rows="3"
                ></textarea>
            </div>

            <button type="submit" class="kriteria-primary-btn">
                Simpan Perubahan
            </button>

        </form>

    </div>

</div>


<style>

    /* HALAMAN UTAMA */
    .staff-kriteria-page {
        padding-top: 32px;
        padding-bottom: 40px;
        color: #1e293b;
    }

    /* BOX JUDUL */
    .kriteria-heading {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 26px 30px;
        margin-bottom: 24px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
    }

    .kriteria-heading-label,
    .kriteria-info-label,
    .modal-label {
        display: inline-block;
        color: #2563eb;
        background: #eff6ff;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 1px;
        padding: 6px 10px;
        border-radius: 5px;
        margin-bottom: 10px;
    }

    .kriteria-heading h1 {
        font-size: 25px;
        font-weight: 750;
        color: #1e3a5f;
        margin: 0 0 7px;
    }

    .kriteria-heading p {
        color: #64748b;
        font-size: 13px;
        margin: 0;
    }

    /* BOX UMUM */
    .kriteria-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        padding: 22px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .kriteria-card-heading {
        margin-bottom: 18px;
    }

    .kriteria-card-heading h3,
    .kriteria-table-header h3 {
        color: #1e3a5f;
        font-size: 16px;
        font-weight: 700;
        margin: 0 0 5px;
    }

    .kriteria-card-heading p,
    .kriteria-table-header p {
        color: #94a3b8;
        font-size: 12px;
        margin: 0;
    }

    /* PILIH LOMBA */
    .kriteria-select-form {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .kriteria-select {
        flex: 1;
        height: 42px;
        padding: 0 12px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #ffffff;
        color: #475569;
        font-size: 12px;
        outline: none;
    }

    .kriteria-select:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    /* INFORMASI LOMBA */
    .kriteria-info-card {
        display: flex;
        align-items: center;
        gap: 15px;
        background: #ffffff;
        border: 1px solid #dbeafe;
        border-left: 4px solid #2563eb;
        border-radius: 12px;
        padding: 20px 23px;
        margin-bottom: 22px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.03);
    }

    .kriteria-info-icon {
        width: 43px;
        height: 43px;
        flex-shrink: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 10px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 17px;
        font-weight: 700;
    }

    .kriteria-info-label {
        margin-bottom: 5px;
    }

    .kriteria-info-card h3 {
        color: #1e3a5f;
        font-size: 16px;
        margin: 0 0 5px;
    }

    .kriteria-info-card p {
        color: #64748b;
        font-size: 12px;
        margin: 0;
    }

    /* FORM */
    .kriteria-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 16px;
    }

    .kriteria-field {
        display: flex;
        flex-direction: column;
        gap: 7px;
        margin-bottom: 16px;
    }

    .kriteria-field label {
        color: #475569;
        font-size: 12px;
        font-weight: 650;
    }

    .kriteria-field input,
    .kriteria-field select,
    .kriteria-field textarea {
        width: 100%;
        box-sizing: border-box;
        padding: 10px 12px;
        border: 1px solid #dbe3ed;
        border-radius: 8px;
        background: #ffffff;
        color: #334155;
        font-family: inherit;
        font-size: 12px;
        outline: none;
        transition: 0.2s;
    }

    .kriteria-field input,
    .kriteria-field select {
        height: 41px;
    }

    .kriteria-field textarea {
        resize: vertical;
        line-height: 1.6;
    }

    .kriteria-field input:focus,
    .kriteria-field select:focus,
    .kriteria-field textarea:focus {
        border-color: #3b82f6;
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.10);
    }

    .kriteria-description {
        margin-top: 2px;
    }

    /* TOMBOL */
    .kriteria-primary-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 40px;
        padding: 0 17px;
        border: 1px solid #2563eb;
        border-radius: 8px;
        background: #2563eb;
        color: #ffffff;
        font-size: 12px;
        font-weight: 650;
        text-decoration: none;
        cursor: pointer;
        transition: 0.2s;
    }

    .kriteria-primary-btn:hover {
        background: #1d4ed8;
        border-color: #1d4ed8;
    }

    /* TABEL */
    .kriteria-table-card {
        padding: 0;
        overflow: hidden;
    }

    .kriteria-table-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: 15px;
        padding: 21px 23px;
        border-bottom: 1px solid #edf1f5;
    }

    .kriteria-count {
        padding: 7px 11px;
        border-radius: 20px;
        background: #eff6ff;
        color: #2563eb;
        font-size: 11px;
        font-weight: 700;
        white-space: nowrap;
    }

    .kriteria-table-wrapper {
        width: 100%;
        overflow-x: auto;
    }

    .kriteria-table {
        width: 100%;
        min-width: 850px;
        border-collapse: collapse;
        text-align: left;
    }

    .kriteria-table thead {
        background: #f8fafc;
    }

    .kriteria-table th {
        padding: 15px 17px;
        color: #64748b;
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.5px;
        border-bottom: 1px solid #e2e8f0;
        white-space: nowrap;
    }

    .kriteria-table td {
        padding: 15px 17px;
        color: #475569;
        font-size: 12px;
        border-bottom: 1px solid #f1f5f9;
        vertical-align: middle;
    }

    .kriteria-table tbody tr {
        transition: background 0.2s;
    }

    .kriteria-table tbody tr:hover {
        background: #f8fbff;
    }

    .kriteria-table tbody tr:last-child td {
        border-bottom: none;
    }

    .kriteria-code {
        display: inline-block;
        padding: 5px 9px;
        border-radius: 6px;
        background: #eff6ff;
        color: #2563eb;
        font-weight: 700;
    }

    .kriteria-name {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 140px;
    }

    .kriteria-name strong {
        color: #334155;
        font-size: 12px;
    }

    .kriteria-name small {
        color: #94a3b8;
        font-size: 11px;
        max-width: 220px;
        line-height: 1.5;
    }

    .kriteria-weight {
        color: #1e3a5f;
    }

    .kriteria-type {
        display: inline-block;
        padding: 6px 10px;
        border-radius: 20px;
        font-size: 10px;
        font-weight: 650;
    }

    .kriteria-type.benefit {
        background: #ecfdf5;
        color: #047857;
    }

    .kriteria-type.cost {
        background: #fef2f2;
        color: #dc2626;
    }

    /* AKSI */
    .kriteria-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 5px;
        min-width: 180px;
    }

    .kriteria-actions form {
        margin: 0;
    }

    .kriteria-action {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        min-height: 29px;
        padding: 5px 9px;
        border: 1px solid transparent;
        border-radius: 6px;
        font-size: 10px;
        font-weight: 650;
        cursor: pointer;
        white-space: nowrap;
        transition: 0.2s;
    }

    .kriteria-action.detail {
        background: #eff6ff;
        border-color: #dbeafe;
        color: #2563eb;
    }

    .kriteria-action.detail:hover {
        background: #dbeafe;
    }

    .kriteria-action.edit {
        background: #f1f5f9;
        border-color: #e2e8f0;
        color: #475569;
    }

    .kriteria-action.edit:hover {
        background: #e2e8f0;
    }

    .kriteria-action.delete {
        background: #fef2f2;
        border-color: #fecaca;
        color: #dc2626;
    }

    .kriteria-action.delete:hover {
        background: #fee2e2;
    }

    /* DATA KOSONG */
    .kriteria-empty,
    .kriteria-empty-card {
        padding: 45px 15px;
        text-align: center;
    }

    .kriteria-empty-card {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 13px;
        box-shadow: 0 3px 12px rgba(15, 23, 42, 0.035);
    }

    .empty-icon {
        width: 38px;
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 12px;
        border-radius: 50%;
        background: #eff6ff;
        color: #2563eb;
        font-size: 17px;
        font-weight: 700;
    }

    .kriteria-empty strong,
    .kriteria-empty-card strong {
        color: #334155;
        font-size: 13px;
    }

    .kriteria-empty p,
    .kriteria-empty-card p {
        color: #94a3b8;
        font-size: 12px;
        margin: 6px 0 0;
    }

    /* MODAL */
    .kriteria-modal-overlay {
        display: none;
        position: fixed;
        inset: 0;
        background: rgba(15, 41, 66, 0.55);
        z-index: 10000;
        align-items: center;
        justify-content: center;
        padding: 20px;
    }

    .kriteria-modal-overlay.open {
        display: flex;
    }

    .kriteria-modal-box {
        background: #ffffff;
        width: 100%;
        max-width: 620px;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 22px;
        box-shadow: 0 20px 45px rgba(0, 0, 0, 0.20);
        max-height: 90vh;
        overflow-y: auto;
    }

    .kriteria-modal-head {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 20px;
    }

    .kriteria-modal-head h3 {
        color: #1e3a5f;
        font-size: 17px;
        margin: 0;
    }

    .kriteria-modal-head .modal-label {
        margin-bottom: 6px;
    }

    .kriteria-modal-close {
        width: 32px;
        height: 32px;
        border: none;
        border-radius: 7px;
        background: #f1f5f9;
        font-size: 24px;
        line-height: 1;
        cursor: pointer;
        color: #64748b;
    }

    .kriteria-modal-close:hover {
        background: #e2e8f0;
        color: #1e3a5f;
    }

    .kriteria-detail-content {
        padding: 5px 0;
    }

    .detail-row {
        margin-bottom: 14px;
        padding-bottom: 12px;
        border-bottom: 1px solid #f1f5f9;
    }

    .detail-row:last-child {
        border-bottom: none;
    }

    .detail-row strong {
        display: block;
        color: #64748b;
        font-size: 11px;
        margin-bottom: 5px;
    }

    .detail-row span,
    .detail-row p {
        color: #334155;
        font-size: 13px;
    }

    .detail-row p {
        margin: 0;
        line-height: 1.6;
        overflow-wrap: anywhere;
    }

    /* RESPONSIVE */
    @media (max-width: 900px) {
        .staff-kriteria-page {
            padding-top: 24px;
        }
    }

    @media (max-width: 600px) {
        .staff-kriteria-page {
            padding-top: 18px;
        }

        .kriteria-heading {
            padding: 21px;
        }

        .kriteria-heading h1 {
            font-size: 21px;
        }

        .kriteria-card {
            padding: 17px;
        }

        .kriteria-grid {
            grid-template-columns: 1fr;
            gap: 0;
        }

        .kriteria-select-form {
            flex-direction: column;
            align-items: stretch;
        }

        .kriteria-select,
        .kriteria-select-form .kriteria-primary-btn {
            width: 100%;
        }

        .kriteria-table-header {
            padding: 17px;
        }

        .kriteria-info-card {
            padding: 17px;
        }

        .kriteria-modal-box {
            padding: 18px;
        }
    }

</style>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // MODAL EDIT
    const editModal = document.getElementById('modalEditKriteria');
    const editForm = document.getElementById('formEditKriteria');
    const editCloseBtn = document.getElementById('kriteriaModalClose');

    const baseUrl = @json(url('staff/kriteria'));

    function openEditModal(data) {

        editForm.action = baseUrl + '/' + data.id;

        document.getElementById('edit_kode').value = data.kode || '';
        document.getElementById('edit_nama').value = data.nama || '';
        document.getElementById('edit_bobot').value = data.bobot ?? 0;
        document.getElementById('edit_jenis').value = data.jenis || 'benefit';
        document.getElementById('edit_nilai_minimum').value = data.minimum ?? 0;
        document.getElementById('edit_deskripsi').value = data.deskripsi || '';

        editModal.classList.add('open');
    }

    function closeEditModal() {
        editModal.classList.remove('open');
    }

    // MODAL DETAIL
    const detailModal = document.getElementById('modalDetailKriteria');
    const detailCloseBtn = document.getElementById('kriteriaDetailModalClose');

    function openDetailModal(data) {

        document.getElementById('detail_kode').textContent = data.kode || '-';
        document.getElementById('detail_nama').textContent = data.nama || '-';
        document.getElementById('detail_bobot').textContent = data.bobot ?? '0';
        document.getElementById('detail_jenis').textContent = data.jenis || '-';
        document.getElementById('detail_minimum').textContent = data.minimum ?? '0';
        document.getElementById('detail_deskripsi').textContent = data.deskripsi || '-';

        detailModal.classList.add('open');
    }

    // TOMBOL EDIT
    document.querySelectorAll('.js-edit-kriteria').forEach(function (btn) {

        btn.addEventListener('click', function () {

            openEditModal({
                id: btn.dataset.id,
                kode: btn.dataset.kode,
                nama: btn.dataset.nama,
                bobot: btn.dataset.bobot,
                jenis: btn.dataset.jenis,
                minimum: btn.dataset.minimum,
                deskripsi: btn.dataset.deskripsi
            });

        });

    });

    // TOMBOL DETAIL
    document.querySelectorAll('.js-detail-kriteria').forEach(function (btn) {

        btn.addEventListener('click', function () {

            openDetailModal({
                kode: btn.dataset.kode,
                nama: btn.dataset.nama,
                bobot: btn.dataset.bobot,
                jenis: btn.dataset.jenis,
                minimum: btn.dataset.minimum,
                deskripsi: btn.dataset.deskripsi
            });

        });

    });

    // TUTUP MODAL EDIT
    if (editCloseBtn) {
        editCloseBtn.addEventListener('click', closeEditModal);
    }

    if (editModal) {
        editModal.addEventListener('click', function (event) {
            if (event.target === editModal) {
                closeEditModal();
            }
        });
    }

    // TUTUP MODAL DETAIL
    if (detailCloseBtn) {
        detailCloseBtn.addEventListener('click', function () {
            detailModal.classList.remove('open');
        });
    }

    if (detailModal) {
        detailModal.addEventListener('click', function (event) {
            if (event.target === detailModal) {
                detailModal.classList.remove('open');
            }
        });
    }

    // TUTUP DENGAN ESCAPE
    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeEditModal();
            detailModal.classList.remove('open');
        }
    });

});
</script>

@endsection
