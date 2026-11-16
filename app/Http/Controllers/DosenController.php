<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\Portfolio;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class DosenController extends Controller
{
    // Dashboard dosen
    public function dashboard()
    {
        $totalMahasiswa = Mahasiswa::count();
        $totalPortfolio = Portfolio::count();
        $totalLomba = Lomba::count();
        $totalPendaftaran = Pendaftaran::count();

        return view('dosen.dashboard', compact(
            'totalMahasiswa',
            'totalPortfolio',
            'totalLomba',
            'totalPendaftaran'
        ));
    }

    // Menampilkan daftar mahasiswa
    public function mahasiswa(Request $request)
    {
        $search = $request->input('search');

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

        return view('dosen.mahasiswa.index', compact(
            'mahasiswa',
            'search'
        ));
    }

    // Menampilkan detail mahasiswa beserta portfolio
    public function mahasiswaDetail($id)
    {
        $mahasiswa = Mahasiswa::with('portfolios')
            ->findOrFail($id);

        return view('dosen.mahasiswa.show', compact('mahasiswa'));
    }
}