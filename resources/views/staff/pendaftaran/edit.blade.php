@extends('layouts.app')

@section('title', 'Edit Status Pendaftaran')

@section('content')
<div class="container">
    <!-- Header Halaman dengan Tombol Kembali di Pojok Kanan -->
    <div class="page-header d-flex justify-content-between align-items-center mb-4" style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px;">
        <div class="page-title">
            <h1 style="font-size: 24px; font-weight: bold; margin-bottom: 4px;">Edit Status Pendaftaran</h1>
            <p style="color: #6c757d; margin: 0;">Perbarui status seleksi dan berikan catatan untuk mahasiswa.</p>
        </div>
        <a href="{{ route('staff.pendaftaran.index') }}" class="btn" style="background-color: #0d6efd; color: white; text-decoration: none; padding: 8px 16px; border-radius: 6px; font-weight: 500;">
            &larr; Kembali
        </a>
    </div>

    <!-- Card Form Utama -->
    <div class="card p-4" style="background: #ffffff; border-radius: 12px; border: 1px solid #eef2f6; padding: 32px; box-shadow: 0 2px 4px rgba(0,0,0,0.02);">
        <form method="POST" action="{{ route('staff.pendaftaran.status', $pendaftaran) }}">
            @csrf
            @method('PATCH')

            <!-- Baris 1: Informasi Mahasiswa & Lomba (2 Kolom) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #212529;">Nama Mahasiswa</label>
                    <input type="text" class="form-control" value="{{ $pendaftaran->mahasiswa->nama_lengkap }} ({{ $pendaftaran->mahasiswa->nim }})" disabled style="width: 100%; padding: 10px 14px; border: 1px solid #e9ecef; border-radius: 8px; background-color: #f8f9fa; color: #495057;">
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #212529;">Nama Lomba</label>
                    <input type="text" class="form-control" value="{{ $pendaftaran->lomba->nama }}" disabled style="width: 100%; padding: 10px 14px; border: 1px solid #e9ecef; border-radius: 8px; background-color: #f8f9fa; color: #495057;">
                </div>
            </div>

            <!-- Baris 2: Selection Status & Tanggal Daftar (2 Kolom) -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px; margin-bottom: 24px;">
                <div class="form-group">
                    <label for="status" style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #212529;">Status Pendaftaran</label>
                    <select name="status" id="status" class="form-select" required style="width: 100%; padding: 10px 14px; border: 1px solid #ced4da; border-radius: 8px; background-color: #ffffff;">
                        <option value="Menunggu" @selected($pendaftaran->status === 'Menunggu')>Menunggu</option>
                        <option value="Diproses" @selected($pendaftaran->status === 'Diproses')>Diproses</option>
                        <option value="Diterima" @selected($pendaftaran->status === 'Diterima')>Diterima</option>
                        <option value="Ditolak" @selected($pendaftaran->status === 'Ditolak')>Ditolak</option>
                    </select>
                </div>

                <div class="form-group">
                    <label style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #212529;">Tanggal Pendaftaran</label>
                    <input type="text" class="form-control" value="{{ $pendaftaran->tanggal_daftar->format('d M Y') }}" disabled style="width: 100%; padding: 10px 14px; border: 1px solid #e9ecef; border-radius: 8px; background-color: #f8f9fa; color: #495057;">
                </div>
            </div>

            <!-- Baris 3: Catatan (Full Width) -->
            <div class="form-group" style="margin-bottom: 28px;">
                <label for="catatan" style="display: block; font-weight: 600; font-size: 14px; margin-bottom: 8px; color: #212529;">Catatan untuk Mahasiswa</label>
                <textarea name="catatan" id="catatan" class="form-control" rows="4" style="width: 100%; padding: 12px 14px; border: 1px solid #ced4da; border-radius: 8px; resize: vertical;" placeholder="Berikan alasan atau catatan tambahan untuk mahasiswa...">{{ old('catatan', $pendaftaran->catatan) }}</textarea>
            </div>

            <!-- Tombol Simpan Perubahan -->
            <div style="display: flex; justify-content: flex-end;">
                <button type="submit" class="btn" style="background-color: #0d6efd; color: white; border: none; padding: 10px 24px; border-radius: 8px; font-weight: 600; cursor: pointer;">
                    Simpan Perubahan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection