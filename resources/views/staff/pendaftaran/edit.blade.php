@extends('layouts.app')

@section('title', 'Edit Status Pendaftaran')

@section('content')

<div class="container staff-edit-pendaftaran-page">

    {{-- HEADER --}}
    <div class="edit-pendaftaran-header">
        <div>
            <h1>Edit Status Pendaftaran</h1>
            <p>Perbarui status seleksi dan berikan catatan untuk mahasiswa.</p>
        </div>

        <a href="{{ route('staff.pendaftaran.index') }}"
           class="edit-pendaftaran-back">
            &larr; Kembali
        </a>
    </div>

    {{-- FORM EDIT --}}
    <div class="edit-pendaftaran-card">

        <div class="edit-pendaftaran-card-header">
            <h2>Informasi Pendaftaran</h2>
            <p>Periksa informasi pendaftaran sebelum memperbarui status.</p>
        </div>

        <form method="POST" action="{{ route('staff.pendaftaran.status', $pendaftaran) }}">
            @csrf
            @method('PATCH')

            {{-- INFORMASI MAHASISWA DAN LOMBA --}}
            <div class="edit-pendaftaran-grid">

                <div class="edit-pendaftaran-field">
                    <label>Nama Mahasiswa</label>
                    <input
                        type="text"
                        value="{{ $pendaftaran->mahasiswa->nama_lengkap }} ({{ $pendaftaran->mahasiswa->nim }})"
                        disabled
                    >
                </div>

                <div class="edit-pendaftaran-field">
                    <label>Nama Lomba</label>
                    <input
                        type="text"
                        value="{{ $pendaftaran->lomba->nama }}"
                        disabled
                    >
                </div>

            </div>

            {{-- STATUS DAN TANGGAL --}}
            <div class="edit-pendaftaran-grid">

                <div class="edit-pendaftaran-field">
                    <label for="status">Status Pendaftaran</label>

                    <select name="status" id="status" required>
                        <option value="Menunggu" @selected($pendaftaran->status === 'Menunggu')>
                            Menunggu
                        </option>

                        <option value="Diproses" @selected($pendaftaran->status === 'Diproses')>
                            Diproses
                        </option>

                        <option value="Diterima" @selected($pendaftaran->status === 'Diterima')>
                            Diterima
                        </option>

                        <option value="Ditolak" @selected($pendaftaran->status === 'Ditolak')>
                            Ditolak
                        </option>
                    </select>
                </div>

                <div class="edit-pendaftaran-field">
                    <label>Tanggal Pendaftaran</label>

                    <input
                        type="text"
                        value="{{ $pendaftaran->tanggal_daftar->format('d M Y') }}"
                        disabled
                    >
                </div>

            </div>

            {{-- CATATAN --}}
            <div class="edit-pendaftaran-field edit-pendaftaran-catatan">
                <label for="catatan">Catatan untuk Mahasiswa</label>

                <textarea
                    name="catatan"
                    id="catatan"
                    rows="4"
                    placeholder="Berikan alasan atau catatan tambahan untuk mahasiswa..."
                >{{ old('catatan', $pendaftaran->catatan) }}</textarea>
            </div>

            {{-- ACTION --}}
            <div class="edit-pendaftaran-actions">
                <button type="submit" class="edit-pendaftaran-save">
                    Simpan Perubahan
                </button>
            </div>

        </form>

    </div>

</div>

<style>
.staff-edit-pendaftaran-page {
    padding-top: 32px;
    padding-bottom: 40px;
    color: #1e293b;
}

/* HEADER */
.staff-edit-pendaftaran-page .edit-pendaftaran-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 20px;
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 24px 28px;
    margin-bottom: 25px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-edit-pendaftaran-page .edit-pendaftaran-header h1 {
    color: #1e3a5f;
    font-size: 25px;
    font-weight: 700;
    margin: 0 0 8px;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-header p {
    color: #64748b;
    font-size: 14px;
    line-height: 1.6;
    margin: 0;
}

/* BACK BUTTON */
.staff-edit-pendaftaran-page .edit-pendaftaran-back {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    padding: 10px 16px;
    border-radius: 8px;
    background: #1e3a5f;
    color: #ffffff;
    text-decoration: none;
    font-size: 13px;
    font-weight: 600;
    white-space: nowrap;
    transition: 0.2s;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-back:hover {
    background: #274b78;
}

/* CARD */
.staff-edit-pendaftaran-page .edit-pendaftaran-card {
    background: #ffffff;
    border: 1px solid #e2e8f0;
    border-radius: 14px;
    padding: 28px;
    box-shadow: 0 3px 12px rgba(15, 23, 42, 0.04);
}

.staff-edit-pendaftaran-page .edit-pendaftaran-card-header {
    padding-bottom: 18px;
    margin-bottom: 25px;
    border-bottom: 1px solid #e2e8f0;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-card-header h2 {
    color: #1e3a5f;
    font-size: 18px;
    font-weight: 700;
    margin: 0 0 7px;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-card-header p {
    color: #64748b;
    font-size: 13px;
    margin: 0;
}

/* GRID */
.staff-edit-pendaftaran-page .edit-pendaftaran-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 24px;
    margin-bottom: 24px;
}

/* FIELD */
.staff-edit-pendaftaran-page .edit-pendaftaran-field {
    display: flex;
    flex-direction: column;
    gap: 9px;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field label {
    color: #334155;
    font-size: 14px;
    font-weight: 600;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field input,
.staff-edit-pendaftaran-page .edit-pendaftaran-field select,
.staff-edit-pendaftaran-page .edit-pendaftaran-field textarea {
    width: 100%;
    padding: 11px 13px;
    border: 1px solid #cbd5e1;
    border-radius: 8px;
    background: #ffffff;
    color: #334155;
    font-size: 14px;
    font-family: inherit;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field input {
    min-height: 44px;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field input:disabled {
    background: #f1f5f9;
    color: #64748b;
    border-color: #e2e8f0;
    cursor: not-allowed;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field select:focus,
.staff-edit-pendaftaran-page .edit-pendaftaran-field textarea:focus {
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.12);
}

.staff-edit-pendaftaran-page .edit-pendaftaran-field textarea {
    resize: vertical;
    min-height: 110px;
    line-height: 1.6;
}

/* CATATAN */
.staff-edit-pendaftaran-page .edit-pendaftaran-catatan {
    margin-bottom: 28px;
}

/* ACTION */
.staff-edit-pendaftaran-page .edit-pendaftaran-actions {
    display: flex;
    justify-content: flex-end;
    padding-top: 20px;
    border-top: 1px solid #e2e8f0;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-save {
    padding: 11px 23px;
    border: none;
    border-radius: 8px;
    background: #1e3a5f;
    color: #ffffff;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: 0.2s;
}

.staff-edit-pendaftaran-page .edit-pendaftaran-save:hover {
    background: #274b78;
}

/* RESPONSIVE */
@media (max-width: 768px) {
    .staff-edit-pendaftaran-page {
        padding-top: 20px;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-header {
        align-items: flex-start;
        flex-direction: column;
        padding: 20px;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-header h1 {
        font-size: 21px;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-card {
        padding: 20px;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-grid {
        grid-template-columns: 1fr;
        gap: 20px;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-actions {
        justify-content: stretch;
    }

    .staff-edit-pendaftaran-page .edit-pendaftaran-save {
        width: 100%;
    }
}

@media (max-width: 480px) {
    .staff-edit-pendaftaran-page .edit-pendaftaran-header,
    .staff-edit-pendaftaran-page .edit-pendaftaran-card {
        padding: 16px;
    }
}
</style>

@endsection