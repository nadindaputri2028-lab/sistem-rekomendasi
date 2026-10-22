<?php

namespace App\Http\Controllers;

use App\Models\Kriteria;
use App\Models\Lomba;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    /**
     * Menampilkan halaman kriteria berdasarkan lomba yang dipilih.
     */
    public function index(Request $request)
    {
        // Ambil semua lomba untuk dropdown
        $lombas = Lomba::latest()->get();

        // Jika user memilih lomba
        if ($request->filled('lomba_id')) {
            $lomba = Lomba::findOrFail($request->lomba_id);
        } else {
            // Jika belum memilih, gunakan lomba terbaru
            $lomba = $lombas->first();
        }

        // Ambil kriteria HANYA milik lomba yang dipilih
        $kriterias = $lomba
            ? $lomba->kriterias()
                ->orderBy('id')
                ->get()
            : collect();

        return view(
            'staff.kriteria.index',
            compact(
                'lomba',
                'kriterias',
                'lombas'
            )
        );
    }

    /**
     * Menambahkan kriteria ke lomba tertentu.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'lomba_id' => [
                'required',
                'exists:lombas,id',
            ],

            'kode' => [
                'required',
                'string',
                'max:10',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'bobot' => [
                'required',
                'numeric',
                'min:0',
            ],

            'jenis' => [
                'required',
                'in:benefit,cost',
            ],

            'nilai_minimum' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        Kriteria::create($data);

        return redirect()
            ->route(
                'staff.kriteria.index',
                ['lomba_id' => $data['lomba_id']]
            )
            ->with(
                'success',
                'Kriteria berhasil ditambahkan.'
            );
    }

    /**
     * Memperbarui kriteria.
     */
    public function update(Request $request, Kriteria $kriteria)
    {
        $data = $request->validate([
            'kode' => [
                'required',
                'string',
                'max:10',
            ],

            'nama' => [
                'required',
                'string',
                'max:255',
            ],

            'bobot' => [
                'required',
                'numeric',
                'min:0',
            ],

            'jenis' => [
                'required',
                'in:benefit,cost',
            ],

            'nilai_minimum' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'deskripsi' => [
                'nullable',
                'string',
            ],
        ]);

        $kriteria->update($data);

        return redirect()
            ->route(
                'staff.kriteria.index',
                ['lomba_id' => $kriteria->lomba_id]
            )
            ->with(
                'success',
                'Kriteria berhasil diperbarui.'
            );
    }

    /**
     * Menghapus satu kriteria.
     */
    public function destroy(Kriteria $kriteria)
    {
        $lombaId = $kriteria->lomba_id;

        $kriteria->delete();

        return redirect()
            ->route(
                'staff.kriteria.index',
                ['lomba_id' => $lombaId]
            )
            ->with(
                'success',
                'Kriteria berhasil dihapus.'
            );
    }
}