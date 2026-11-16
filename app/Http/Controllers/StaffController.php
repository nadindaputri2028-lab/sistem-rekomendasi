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
        $query = Mahasiswa::query();

        // Pencarian berdasarkan Nama atau NIM
        if ($request->filled('q')) {

            $keyword = $request->q;

            $query->where(function ($sub) use ($keyword) {
                $sub->where('nama_lengkap', 'like', '%' . $keyword . '%')
                    ->orWhere('nim', 'like', '%' . $keyword . '%');
            });
        }

        // Filter status aktif / non-aktif
        if ($request->filled('status')) {
            $query->where('is_active', $request->status === 'aktif');
        }

        // Filter program studi - default ke Teknologi Informasi
        if ($request->filled('prodi')) {
            $query->where('prodi', $request->prodi);
        } else {
            // Default filter ke Teknologi Informasi
            $query->where('prodi', 'Teknologi Informasi');
        }

        // Filter semester
        if ($request->filled('semester')) {
            $query->where('semester', $request->semester);
        }

       $mahasiswas = $query
        ->orderBy('nama_lengkap', 'asc')
        ->orderBy('nim', 'asc')
        ->paginate(10)
        ->withQueryString();

        // Opsi dropdown prodi - hanya Teknologi Informasi
        $prodis = ['Teknologi Informasi'];

        // Opsi dropdown semester 1-8
        $semesters = range(1, 8);

        return view(
            'staff.mahasiswa.index',
            compact('mahasiswas', 'prodis', 'semesters')
        );
    }

    /**
     * Mengaktifkan / menonaktifkan mahasiswa.
     */
    public function toggleActive(Mahasiswa $mahasiswa)
    {
        $mahasiswa->update([
            'is_active' => !$mahasiswa->is_active,
        ]);

        $status = $mahasiswa->is_active
            ? 'diaktifkan'
            : 'dinonaktifkan';

        return back()->with(
            'success',
            "Mahasiswa {$mahasiswa->nama_lengkap} berhasil {$status}."
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
        $mahasiswa->load('portfolios');

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