<?php

namespace App\Http\Controllers;

use App\Models\Mahasiswa;
use App\Models\User;
use App\Models\Portfolio;
use App\Models\Lomba;
use App\Models\Pendaftaran;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Dashboard Staff
    |--------------------------------------------------------------------------
    */

    public function dashboard()
    {
        // Total data mahasiswa
        $totalMahasiswa = Mahasiswa::count();

        // Total portfolio
        $totalPortfolio = Portfolio::count();

        // Total lomba
        $totalLomba = Lomba::count();

        // Total pendaftaran
        $totalPendaftaran = Pendaftaran::count();

        // Data pendaftaran terbaru
        $terbaru = Pendaftaran::with([
            'mahasiswa',
            'lomba'
        ])
            ->latest()
            ->take(5)
            ->get();

        /*
        |--------------------------------------------------------------------------
        | Portfolio Mahasiswa
        |--------------------------------------------------------------------------
        |
        | Mengambil portfolio terbaru beserta data mahasiswa.
        | Staff hanya melihat data, tidak mengedit portfolio dari dashboard.
        |
        */

        $portfolios = Portfolio::with('mahasiswa')
            ->latest()
            ->take(5)
            ->get();

        // Notifikasi staff
        $notifications = Notification::where(
            'user_id',
            session('user_id')
        )
            ->latest()
            ->take(5)
            ->get();

        // Jumlah notifikasi yang belum dibaca
        $unreadNotifications = Notification::where(
            'user_id',
            session('user_id')
        )
            ->where('is_read', false)
            ->count();

        return view(
            'staff.dashboard',
            compact(
                'totalMahasiswa',
                'totalPortfolio',
                'totalLomba',
                'totalPendaftaran',
                'terbaru',
                'portfolios',
                'notifications',
                'unreadNotifications'
            )
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Data Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function index(Request $request)
    {
        $mahasiswas = Mahasiswa::when(
            $request->q,
            fn($q) =>
            $q->where(
                'nama_lengkap',
                'like',
                '%' . $request->q . '%'
            )
            ->orWhere(
                'nim',
                'like',
                '%' . $request->q . '%'
            )
        )
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'staff.mahasiswa.index',
            compact('mahasiswas')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Tambah Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function create()
    {
        return view('staff.mahasiswa.create');
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nim' => 'required|unique:mahasiswas,nim',
            'prodi' => 'required',
            'semester' => 'required|integer|min:1|max:14',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'nullable',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'ips' => 'nullable|numeric|min:0|max:4',
            'prestasi' => 'nullable',
            'keahlian' => 'nullable',
            'minat' => 'nullable',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Membuat akun user mahasiswa
        $user = User::create([
            'name' => $data['nama_lengkap'],
            'email' => $data['email'],
            'password' => Hash::make('password'),
            'role' => 'mahasiswa',
        ]);

        $data['user_id'] = $user->id;

        // Upload foto mahasiswa
        if ($request->hasFile('foto')) {
            $data['foto'] = $request
                ->file('foto')
                ->store('mahasiswa', 'public');
        }

        // Membuat data mahasiswa
        Mahasiswa::create($data);

        return redirect()
            ->route('staff.mahasiswa.index')
            ->with(
                'success',
                'Mahasiswa berhasil ditambahkan. Password awal: password'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Detail Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function show(Mahasiswa $mahasiswa)
    {
        return view(
            'staff.mahasiswa.show',
            compact('mahasiswa')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Edit Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function edit(Mahasiswa $mahasiswa)
    {
        return view(
            'staff.mahasiswa.edit',
            compact('mahasiswa')
        );
    }


    /*
    |--------------------------------------------------------------------------
    | Update Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function update(
        Request $request,
        Mahasiswa $mahasiswa
    ) {
        $data = $request->validate([
            'nama_lengkap' => 'required',
            'nim' => 'required|unique:mahasiswas,nim,' . $mahasiswa->id,
            'prodi' => 'required',
            'semester' => 'required|integer|min:1|max:14',
            'email' => 'required|email|unique:users,email,' . ($mahasiswa->user_id ?? 'NULL'),
            'no_hp' => 'nullable',
            'ipk' => 'nullable|numeric|min:0|max:4',
            'ips' => 'nullable|numeric|min:0|max:4',
            'prestasi' => 'nullable',
            'keahlian' => 'nullable',
            'minat' => 'nullable',
            'foto' => 'nullable|image|max:2048',
        ]);

        // Jika ada foto baru
        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($mahasiswa->foto) {
                Storage::disk('public')
                    ->delete($mahasiswa->foto);
            }

            // Simpan foto baru
            $data['foto'] = $request
                ->file('foto')
                ->store('mahasiswa', 'public');
        }

        // Update data mahasiswa
        $mahasiswa->update($data);

        // Update data user
        $mahasiswa->user?->update([
            'name' => $data['nama_lengkap'],
            'email' => $data['email'],
        ]);

        return redirect()
            ->route('staff.mahasiswa.index')
            ->with(
                'success',
                'Data mahasiswa diperbarui.'
            );
    }


    /*
    |--------------------------------------------------------------------------
    | Hapus Mahasiswa
    |--------------------------------------------------------------------------
    */

    public function destroy(Mahasiswa $mahasiswa)
    {
        // Hapus foto mahasiswa
        if ($mahasiswa->foto) {
            Storage::disk('public')
                ->delete($mahasiswa->foto);
        }

        // Hapus user
        $mahasiswa->user?->delete();

        // Hapus mahasiswa
        $mahasiswa->delete();

        return back()->with(
            'success',
            'Mahasiswa dihapus.'
        );
    }
}