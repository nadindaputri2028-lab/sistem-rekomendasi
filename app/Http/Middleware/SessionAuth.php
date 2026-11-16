<?php

namespace App\Http\Middleware;

use App\Models\User;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SessionAuth
{
    public function handle(
        Request $request,
        Closure $next
    ): Response {

        // Ambil ID user dari session
        $userId = session('user_id');

        // Jika belum login
        if (!$userId) {
            return redirect()
                ->route('login')
                ->with('error', 'Silakan login terlebih dahulu.');
        }

        // Cari user berdasarkan ID
        $user = User::find($userId);

        // Jika akun tidak ditemukan
        if (!$user) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route('login')
                ->with('error', 'Akun tidak ditemukan. Silakan login kembali.');
        }

        // Normalisasi role admin menjadi staff
        $role = $user->role === 'admin'
            ? 'staff'
            : $user->role;

        // Sinkronkan session dengan database
        session([
            'user_id' => $user->id,
            'role' => $role,
        ]);

        return $next($request);
    }
}
