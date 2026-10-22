@extends('layouts.app')

@section('title', 'Kriteria Lomba')

@section('content')

<div class="container">

    {{-- Judul --}}
    <div class="page-title">
        <h1>Kriteria Lomba</h1>

        <p>
            Tentukan kriteria, bobot, dan atribut yang digunakan
            dalam perhitungan AHP + SAW.
        </p>
    </div>


    {{-- PILIH LOMBA --}}
    <div class="card" style="padding: 20px; margin-bottom: 16px;">

        <form
            method="GET"
            action="{{ route('staff.kriteria.index') }}"
        >

            <div
                style="
                    display:flex;
                    gap:10px;
                    align-items:center;
                "
            >

                <select
                    name="lomba_id"
                    style="flex:1;"
                    required
                >

                    <option value="">
                        Pilih Lomba
                    </option>

                    @foreach($lombas as $item)

                        <option
                            value="{{ $item->id }}"
                            @selected(
                                $lomba &&
                                $lomba->id == $item->id
                            )
                        >
                            {{ $item->nama }}
                        </option>

                    @endforeach

                </select>


                <button
                    type="submit"
                    class="btn"
                >
                    Tampilkan
                </button>

            </div>

        </form>

    </div>


    @if($lomba)

        {{-- INFORMASI LOMBA --}}
        <div
            class="card"
            style="
                padding:20px;
                margin-bottom:16px;
                border-left:4px solid #075eb8;
            "
        >

            <h3 style="margin-bottom:6px;">
                Kriteria untuk:
                <strong>{{ $lomba->nama }}</strong>
            </h3>

            <p style="margin:0; color:#64748b;">
                Tambahkan kriteria khusus untuk lomba
                yang sedang dipilih.
            </p>

        </div>


        {{-- FORM TAMBAH KRITERIA --}}
        <div class="card form-card">

            <h3>
                Tambah Kriteria untuk
                {{ $lomba->nama }}
            </h3>

            <form
                method="POST"
                action="{{ route('staff.kriteria.store') }}"
            >

                @csrf

                {{-- ID LOMBA OTOMATIS --}}
                <input
                    type="hidden"
                    name="lomba_id"
                    value="{{ $lomba->id }}"
                >


                <div class="grid-2">

                    {{-- KODE --}}
                    <div class="field">

                        <label for="kode">
                            Kode
                        </label>

                        <input
                            type="text"
                            id="kode"
                            name="kode"
                            placeholder="C1"
                            required
                        >

                    </div>


                    {{-- NAMA --}}
                    <div class="field">

                        <label for="nama">
                            Nama Kriteria
                        </label>

                        <input
                            type="text"
                            id="nama"
                            name="nama"
                            placeholder="IPK"
                            required
                        >

                    </div>


                    {{-- BOBOT --}}
                    <div class="field">

                        <label for="bobot">
                            Bobot AHP Awal
                        </label>

                        <input
                            type="number"
                            id="bobot"
                            name="bobot"
                            step="0.01"
                            min="0"
                            placeholder="0.25"
                            required
                        >

                    </div>


                    {{-- JENIS --}}
                    <div class="field">

                        <label for="jenis">
                            Jenis
                        </label>

                        <select
                            id="jenis"
                            name="jenis"
                            required
                        >

                            <option value="benefit">
                                Benefit
                            </option>

                            <option value="cost">
                                Cost
                            </option>

                        </select>

                    </div>


                    {{-- NILAI MINIMUM --}}
                    <div class="field">

                        <label for="nilai_minimum">
                            Nilai Minimum
                        </label>

                        <input
                            type="number"
                            id="nilai_minimum"
                            name="nilai_minimum"
                            step="0.01"
                            min="0"
                            value="0"
                        >

                    </div>

                </div>


                {{-- DESKRIPSI --}}
                <div class="field">

                    <label for="deskripsi">
                        Deskripsi
                    </label>

                    <textarea
                        id="deskripsi"
                        name="deskripsi"
                        rows="4"
                        placeholder="Jelaskan kriteria..."
                    ></textarea>

                </div>


                <button
                    type="submit"
                    class="btn"
                >
                    + Simpan Kriteria
                </button>

            </form>

        </div>


        {{-- DAFTAR KRITERIA --}}
        <div
            class="table-card card"
            style="margin-top:16px;"
        >

            <div
                style="
                    padding:20px 20px 0;
                "
            >

                <h3>
                    Daftar Kriteria
                    {{ $lomba->nama }}
                </h3>

                <p
                    style="
                        color:#64748b;
                        margin-top:4px;
                    "
                >
                    Kriteria berikut hanya digunakan
                    untuk lomba ini.
                </p>

            </div>


            <table class="table">

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
                                {{ $kriteria->kode }}
                            </td>


                            <td>

                                <b>
                                    {{ $kriteria->nama }}
                                </b>

                                @if($kriteria->deskripsi)

                                    <br>

                                    <small>
                                        {{ $kriteria->deskripsi }}
                                    </small>

                                @endif

                            </td>


                            <td>
                                {{ $kriteria->bobot }}
                            </td>


                            <td>

                                @if($kriteria->jenis === 'benefit')

                                    <span>
                                        Benefit
                                    </span>

                                @else

                                    <span>
                                        Cost
                                    </span>

                                @endif

                            </td>


                            <td>
                                {{ $kriteria->nilai_minimum }}
                            </td>


                            <td>

                                <form
                                    method="POST"
                                    action="{{ route(
                                        'staff.kriteria.destroy',
                                        $kriteria
                                    ) }}"
                                >

                                    @csrf

                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="btn small danger"
                                        data-confirm="Hapus kriteria ini?"
                                    >
                                        Hapus
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="6"
                                class="empty"
                            >
                                Belum ada kriteria untuk
                                {{ $lomba->nama }}.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    @else

        <div class="card empty">

            Belum ada data lomba.
            Silakan tambahkan lomba terlebih dahulu.

        </div>

    @endif

</div>

@endsection