<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman Login Google.
     */
    public function redirectToGoogle()
    {
        try {
            return Socialite::driver('google')
                ->stateless()
                ->with([
                    'prompt' => 'select_account',
                    'hd' => 'mhs.politala.ac.id',
                ])
                ->redirect();

        } catch (\Exception $e) {
            return redirect()->route('login')->with(
                'error',
                'Gagal mengakses Google Login: ' . $e->getMessage()
            );
        }
    }

    /**
     * Menangani callback dari Google.
     */
    public function handleGoogleCallback(Request $request)
    {
        try {
            $googleUser = Socialite::driver('google')
                ->stateless()
                ->user();

            // Ambil email Google
            $email = strtolower($googleUser->getEmail() ?? '');

            // Pastikan menggunakan email mahasiswa Politala
            if (!str_ends_with($email, '@mhs.politala.ac.id')) {
                return redirect()->route('login')->with(
                    'error',
                    'Gunakan akun Google mahasiswa Politala.'
                );
            }

            // Cari akun berdasarkan email login
            $user = User::where('email', $email)->first();

            // Jika akun tidak ditemukan
            if (!$user) {
                return redirect()->route('login')->with(
                    'error',
                    'Email Google belum terdaftar di sistem.'
                );
            }

            // Pastikan akun memiliki role yang sesuai
            if (!in_array($user->role, ['mahasiswa', 'staff'])) {
                return redirect()->route('login')->with(
                    'error',
                    'Role akun tidak dikenali.'
                );
            }

            // Pastikan data mahasiswa terhubung
            if ($user->role === 'mahasiswa' && !$user->mahasiswa) {
                return redirect()->route('login')->with(
                    'error',
                    'Data mahasiswa belum terhubung dengan akun.'
                );
            }

            // Login menggunakan akun yang ditemukan
            Auth::login($user, true);

            // Perbarui session
            $request->session()->regenerate();

            session([
                'user_id' => $user->id,
                'role' => $user->role,
            ]);

            // Arahkan berdasarkan role
            if ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }

            if ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

        } catch (\Exception $e) {
            return redirect()->route('login')->with(
                'error',
                'Login dengan Google gagal: ' . $e->getMessage()
            );
        }
    }
}
