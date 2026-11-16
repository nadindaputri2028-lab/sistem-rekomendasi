<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function pilihan()
    {
        return view('auth.pilihan-login');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGIN SATU PORTAL: MAHASISWA, STAFF, DOSEN
    |--------------------------------------------------------------------------
    */

    public function login(Request $request)
    {
        $data = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $loginInput = $data['username'];

        // Cari akun berdasarkan email.
        $user = User::where('email', $loginInput)->first();

        // Jika belum ditemukan, cari berdasarkan NIM mahasiswa.
        if (!$user) {
            $mahasiswa = Mahasiswa::where('nim', $loginInput)
                ->orWhere('email', $loginInput)
                ->first();

            $user = $mahasiswa?->user;
        }

        // Periksa password.
        if (
            !$user ||
            !$user->password ||
            !Hash::check($data['password'], $user->password)
        ) {
            return back()
                ->withInput($request->only('username'))
                ->with('error', 'Email/NIM atau password salah.');
        }

        // Pastikan role dikenali.
        if (!in_array($user->role, [
            'mahasiswa',
            'staff',
            'admin',
            'dosen'
        ])) {
            return back()
                ->with('error', 'Role akun tidak dikenali.');
        }

        // Regenerasi session.
        $request->session()->regenerate();

        // Admin tetap menggunakan dashboard staff.
        $role = $user->role === 'admin'
            ? 'staff'
            : $user->role;

        session([
            'user_id' => $user->id,
            'role' => $role,
        ]);

        // Arahkan sesuai role.
        if ($role === 'mahasiswa') {
            return redirect()->route('mahasiswa.dashboard');
        }

        if ($role === 'dosen') {
            return redirect()->route('dosen.dashboard');
        }

        return redirect()->route('staff.dashboard');
    }

    /*
    |--------------------------------------------------------------------------
    | LOGOUT
    |--------------------------------------------------------------------------
    */

    public function logout(Request $request)
    {
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'Anda telah logout.');
    }
}
