<?php
namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\Mahasiswa;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    /**
     * Halaman rekomendasi untuk staff.
     */
    public function index()
    {
        $lombas = Lomba::latest()->get();

        return view(
            'staff.rekomendasi.index',
            compact('lombas')
        );
    }

    /**
     * Menjalankan perhitungan AHP + SAW.
     */
    public function calculate(Request $request, RekomendasiService $service)
    {
        $request->validate([
            'lomba_id' => 'required|exists:lombas,id',
        ]);

        $lomba = Lomba::findOrFail($request->lomba_id);

        $service->calculate($lomba);

        return redirect()
            ->route('staff.rekomendasi.show', $lomba)
            ->with('success', 'Perhitungan AHP + SAW berhasil dilakukan.');
    }

    /**
     * Detail hasil rekomendasi per lomba (staff).
     */
    public function show(Lomba $lomba)
    {
        $results = $lomba->rekomendasis()
            ->with('mahasiswa')
            ->orderBy('ranking')
            ->get();

        $criteria = $lomba->kriterias;

        return view(
            'staff.rekomendasi.show',
            compact('lomba', 'results', 'criteria')
        );
    }

    /**
     * Rekomendasi lomba untuk mahasiswa,
     * dilengkapi persentase kecocokan (match score)
     * dan pengingat deadline.
     */
    public function forStudent(RekomendasiService $service)
    {
        $m = Mahasiswa::where('user_id', session('user_id'))
            ->firstOrFail();

        $lombas = Lomba::where('status', 'Aktif')
            ->whereDate('deadline', '>=', now())
            ->with('kriterias')
            ->latest()
            ->get();

        // Hitung persentase kecocokan tiap lomba untuk mahasiswa ini
        $lombas = $lombas->map(function ($l) use ($m, $service) {

            $match = $service->matchScore($m, $l);

            $l->match_score = $match['score'];
            $l->eligible = $match['eligible'];
            $l->match_detail = $match['details'];

            return $l;
        })
            ->sortByDesc('match_score')
            ->values();

        return view(
            'mahasiswa.rekomendasi.index',
            compact('lombas', 'm')
        );
    }

    /**
     * Cetak / Export hasil rekomendasi ke PDF.
     */
    public function pdf(Lomba $lomba)
    {
        $results = $lomba->rekomendasis()
            ->with('mahasiswa')
            ->orderBy('ranking')
            ->get();

        return view(
            'staff.rekomendasi.pdf',
            compact('lomba', 'results')
        );
    }
}
