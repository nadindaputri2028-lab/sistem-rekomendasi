<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Menampilkan semua notifikasi milik user yang sedang login.
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
     * Membuka notifikasi dan otomatis menandainya sebagai sudah dibaca.
     */
    public function open(Notification $notification)
    {
        if ($notification->user_id != session('user_id')) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        if ($notification->url) {
            return redirect($notification->url);
        }

        return redirect()->route('notifications.index');
    }

    /**
     * Menandai satu notifikasi sebagai sudah dibaca.
     */
    public function read(Notification $notification)
    {
        if ($notification->user_id != session('user_id')) {
            abort(403);
        }

        $notification->update([
            'is_read' => true,
        ]);

        return back();
    }

    /**
     * Menandai semua notifikasi sebagai sudah dibaca.
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

    /**
     * Menghapus satu notifikasi.
     */
    public function destroy(Notification $notification)
    {
        if ($notification->user_id != session('user_id')) {
            abort(403);
        }

        $notification->delete();

        return back()->with(
            'success',
            'Notifikasi berhasil dihapus.'
        );
    }

    /**
     * Menghapus semua notifikasi milik user yang sedang login.
     */
    public function destroyAll()
    {
        Notification::where(
            'user_id',
            session('user_id')
        )->delete();

        return redirect()
            ->route('notifications.index')
            ->with(
                'success',
                'Semua notifikasi berhasil dihapus.'
            );
    }
}
