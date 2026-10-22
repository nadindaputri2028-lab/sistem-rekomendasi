<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi
     * milik user yang sedang login.
     */
    public function index()
    {
        $notifications = Notification::where(
            'user_id',
            session('user_id')
        )
            ->latest()
            ->paginate(10);

        return view(
            'notifications.index',
            compact('notifications')
        );
    }

    /**
     * Membuka notifikasi.
     *
     * Notifikasi otomatis ditandai sebagai
     * sudah dibaca kemudian diarahkan ke
     * halaman tujuan notifikasi.
     */
    public function open(Notification $notification)
    {
        // Pastikan notifikasi milik user yang sedang login
        if ($notification->user_id != session('user_id')) {
            abort(403);
        }

        // Tandai sudah dibaca
        $notification->update([
            'is_read' => true,
        ]);

        // Jika notifikasi memiliki URL tujuan
        if ($notification->url) {
            return redirect($notification->url);
        }

        // Jika tidak memiliki URL
        return redirect()->route('notifications.index');
    }

    /**
     * Menandai satu notifikasi
     * sebagai sudah dibaca.
     */
    public function read(Notification $notification)
    {
        // Pastikan notifikasi milik user yang sedang login
        if ($notification->user_id != session('user_id')) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        return back();
    }

    /**
     * Menandai semua notifikasi
     * sebagai sudah dibaca.
     */
    public function readAll()
    {
        Notification::where(
            'user_id',
            session('user_id')
        )->update([
            'is_read' => true,
        ]);

        return back()->with(
            'success',
            'Semua notifikasi telah dibaca.'
        );
    }
}