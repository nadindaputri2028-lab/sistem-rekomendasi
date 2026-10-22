<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Mengarahkan pengguna ke halaman Login Google.
     */
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
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

            // Cari user berdasarkan email Google
            $user = User::where('email', $googleUser->getEmail())->first();

            // Jika email belum terdaftar
            if (!$user) {
                return redirect('/login')->with(
                    'error',
                    'Email Google belum terdaftar di sistem.'
                );
            }

            // Simpan data Google ke user
            $user->update([
                'google_id' => $googleUser->getId(),
                'google_token' => $googleUser->token,
                'google_refresh_token' => $googleUser->refreshToken,
            ]);

            // Buat session login sesuai sistem yang sudah digunakan
            session([
                'user_id' => $user->id,
                'role' => $user->role,
            ]);

            // Regenerate session untuk keamanan
            $request->session()->regenerate();

            // Arahkan berdasarkan role
            if ($user->role === 'mahasiswa') {
                return redirect()->route('mahasiswa.dashboard');
            }

            if ($user->role === 'staff') {
                return redirect()->route('staff.dashboard');
            }

            // Jika role tidak dikenali
            session()->flush();

            return redirect('/login')->with(
                'error',
                'Role akun tidak dikenali.'
            );

        } catch (\Exception $e) {
            return redirect('/login')->with(
                'error',
                'Login dengan Google gagal. Silakan coba lagi.'
            );
        }
    }
}