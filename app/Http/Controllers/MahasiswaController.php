<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MahasiswaController extends Controller
{
    private function current(): Mahasiswa 
    {
        return Mahasiswa::where('user_id', session('user_id'))
            ->with('portfolios')
            ->firstOrFail();
    }

    public function dashboard()
    {
        $m = $this->current();

        $lombas = \App\Models\Lomba::where('status', 'Aktif')
            ->whereDate('deadline', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        $pendaftaran = $m->pendaftarans()->count();

        $notifications = \App\Models\Notification::where('user_id', session('user_id'))
            ->latest()
            ->take(5)
            ->get();

        $unreadNotifications = \App\Models\Notification::where('user_id', session('user_id'))
            ->where('is_read', false)
            ->count();

        return view(
            'mahasiswa.dashboard',
            compact(
                'm',
                'lombas',
                'pendaftaran',
                'notifications',
                'unreadNotifications'
            )
        );
    }

    // 1. Menampilkan Halaman Detail Profil
    public function profil()
    { 
        $m = $this->current(); 
        return view('mahasiswa.profil', compact('m')); 
    }

    // 2. Menampilkan Halaman Form Edit Profil (Method Baru)
    public function editProfil()
    {
        $m = $this->current();
        return view('mahasiswa.edit-profil', compact('m'));
    }

    // 3. Memproses Pembaruan Data Profil
    public function updateProfil(Request $request)
    {
        $m = $this->current();

        $data = $request->validate([
            'nama_lengkap' => 'required|string|max:255',
            'nim'          => 'required|string|max:50|unique:mahasiswas,nim,' . $m->id,
            'prodi'        => 'required|string|max:255',
            'semester'     => 'required|integer|min:1|max:14',
            'email'        => 'required|email|max:255',
            'no_hp'        => 'nullable|string|max:30',
            'prestasi'     => 'nullable|string',
            'keahlian'     => 'nullable|string',
            'minat'        => 'nullable|string',
            'foto'         => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('foto')) {
            if ($m->foto) {
                Storage::disk('public')->delete($m->foto);
            }
            $data['foto'] = $request->file('foto')->store('mahasiswa', 'public');
        }

        $m->update($data);
       $m->user?->update([
    'name' => $m->nama_lengkap
]);

        // Redirect ke halaman detail profil setelah berhasil simpan
        return redirect()->route('mahasiswa.profil.show')
            ->with('success', 'Profil berhasil diperbarui.');
    }
}