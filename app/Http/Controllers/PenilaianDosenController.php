<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\PenilaianDosen;
use Illuminate\Http\Request;

class PenilaianDosenController extends Controller
{
    // Daftar mahasiswa dan statistik penilaian.
    public function index(Request $request)
    {
        $dosenId = session('user_id');
        $search = $request->input('search');

        // Total seluruh mahasiswa.
        $totalMahasiswa = Mahasiswa::count();

        // Total mahasiswa yang sudah dinilai oleh dosen ini.
        $totalDinilai = PenilaianDosen::where('dosen_id', $dosenId)
            ->distinct('mahasiswa_id')
            ->count('mahasiswa_id');

        // Total mahasiswa yang belum dinilai.
        $totalBelumDinilai = max(0, $totalMahasiswa - $totalDinilai);

        // Mengambil daftar mahasiswa.
        $mahasiswa = Mahasiswa::query()
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('nama_lengkap', 'like', "%{$search}%")
                        ->orWhere('nim', 'like', "%{$search}%");
                });
            })
            ->orderBy('nama_lengkap')
            ->paginate(10)
            ->withQueryString();

        // Mengambil riwayat penilaian dosen untuk mahasiswa di halaman ini.
        $riwayat = PenilaianDosen::where('dosen_id', $dosenId)
            ->whereIn('mahasiswa_id', $mahasiswa->pluck('id'))
            ->latest()
            ->get()
            ->groupBy('mahasiswa_id');

        // Memasang penilaian terbaru pada masing-masing mahasiswa.
        foreach ($mahasiswa as $item) {
            $item->setRelation(
                'penilaian',
                $riwayat->get($item->id)?->first()
            );
        }

        return view('dosen.penilaian.index', compact(
            'mahasiswa',
            'riwayat',
            'search',
            'totalMahasiswa',
            'totalDinilai',
            'totalBelumDinilai'
        ));
    }

    // Menampilkan form penilaian.
    public function create(Mahasiswa $mahasiswa)
    {
        return view('dosen.penilaian.create', compact('mahasiswa'));
    }

    // Menyimpan hasil penilaian.
    public function store(Request $request, Mahasiswa $mahasiswa)
    {
        $validated = $request->validate([
            'nilai_angka' => 'required|numeric|min:0|max:100',

            'prestasi_akademik' => 'required|numeric|min:0|max:100',
            'kedisiplinan' => 'required|numeric|min:0|max:100',
            'keaktifan' => 'required|numeric|min:0|max:100',
            'tanggung_jawab' => 'required|numeric|min:0|max:100',
            'perkembangan_akademik' => 'required|numeric|min:0|max:100',
            'konsultasi_akademik' => 'required|numeric|min:0|max:100',
            'sikap_etika' => 'required|numeric|min:0|max:100',

            'catatan' => 'nullable|string|max:2000',
        ]);

        // Menghitung nilai berdasarkan bobot tujuh kriteria.
        $nilaiKriteria =
            ($validated['prestasi_akademik'] * 0.25) +
            ($validated['kedisiplinan'] * 0.15) +
            ($validated['keaktifan'] * 0.15) +
            ($validated['tanggung_jawab'] * 0.15) +
            ($validated['perkembangan_akademik'] * 0.15) +
            ($validated['konsultasi_akademik'] * 0.10) +
            ($validated['sikap_etika'] * 0.05);

        // Gabungan nilai angka dan nilai kriteria.
        $nilaiAkhir =
            ($validated['nilai_angka'] * 0.50) +
            ($nilaiKriteria * 0.50);

        $penilaian = PenilaianDosen::create([
            'mahasiswa_id' => $mahasiswa->id,
            'dosen_id' => session('user_id'),

            'nilai_angka' => $validated['nilai_angka'],

            'prestasi_akademik' => $validated['prestasi_akademik'],
            'kedisiplinan' => $validated['kedisiplinan'],
            'keaktifan' => $validated['keaktifan'],
            'tanggung_jawab' => $validated['tanggung_jawab'],
            'perkembangan_akademik' => $validated['perkembangan_akademik'],
            'konsultasi_akademik' => $validated['konsultasi_akademik'],
            'sikap_etika' => $validated['sikap_etika'],

            'nilai_kriteria' => round($nilaiKriteria, 2),
            'nilai_akhir' => round($nilaiAkhir, 2),

            'catatan' => $validated['catatan'] ?? null,
        ]);

        return redirect()
            ->route('dosen.penilaian.show', $penilaian->id)
            ->with('success', 'Penilaian mahasiswa berhasil disimpan.');
    }

    // Melihat detail hasil penilaian.
    public function show(PenilaianDosen $penilaian)
    {
        abort_unless(
            $penilaian->dosen_id == session('user_id'),
            403
        );

        $penilaian->load('mahasiswa');

        return view('dosen.penilaian.show', compact('penilaian'));
    }
}
