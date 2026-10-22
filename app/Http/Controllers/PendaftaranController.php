<?php

namespace App\Http\Controllers;

use App\Models\Pendaftaran;
use App\Models\Lomba;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Menampilkan pendaftaran milik mahasiswa
     */
    public function index()
    {
        $m = \App\Models\Mahasiswa::where(
            'user_id',
            session('user_id')
        )->firstOrFail();

        $pendaftarans = $m->pendaftarans()
            ->with('lomba')
            ->latest()
            ->paginate(10);

        return view(
            'mahasiswa.pendaftaran.index',
            compact('pendaftarans')
        );
    }

    /**
     * Mahasiswa mendaftar lomba
     */
    public function store(
        Request $request,
        Lomba $lomba
    ) {
        $m = \App\Models\Mahasiswa::where(
            'user_id',
            session('user_id')
        )->firstOrFail();

        /*
        |--------------------------------------------------------------------------
        | Cek Deadline
        |--------------------------------------------------------------------------
        */

        if ($lomba->deadline->isPast()) {
            return back()->with(
                'error',
                'Pendaftaran lomba sudah ditutup.'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Simpan Pendaftaran
        |--------------------------------------------------------------------------
        */

        $pendaftaran = Pendaftaran::firstOrCreate(
            [
                'mahasiswa_id' => $m->id,
                'lomba_id' => $lomba->id,
            ],
            [
                'status' => 'Menunggu',
                'tanggal_daftar' => now(),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Jika Pendaftaran Baru
        |--------------------------------------------------------------------------
        */

        if ($pendaftaran->wasRecentlyCreated) {

            /*
            | Notifikasi untuk mahasiswa
            */

            Notification::create([
                'user_id' => session('user_id'),

                'title' => 'Pendaftaran Berhasil Dikirim',

                'message' =>
                    'Pendaftaran kamu untuk lomba "' .
                    $lomba->nama .
                    '" telah berhasil dikirim dan sedang menunggu proses.',

                'type' => 'pendaftaran',

                'is_read' => false,

                'url' => route(
                    'mahasiswa.pendaftaran.index'
                ),
            ]);

            /*
            | Notifikasi untuk staff/admin
            */

            $staffUsers = User::whereIn(
                'role',
                ['staff', 'admin']
            )->get();

            foreach ($staffUsers as $staff) {

                Notification::create([
                    'user_id' => $staff->id,

                    'title' => 'Pendaftaran Mahasiswa Baru',

                    'message' =>
                        $m->nama_lengkap .
                        ' telah mendaftar pada lomba "' .
                        $lomba->nama .
                        '". Silakan periksa data pendaftaran.',

                    'type' => 'pendaftaran_baru',

                    'is_read' => false,

                    'url' => route(
                        'staff.pendaftaran.index'
                    ),
                ]);
            }
        }

        return redirect()
            ->route('mahasiswa.pendaftaran.index')
            ->with(
                'success',
                'Pendaftaran berhasil dikirim.'
            );
    }

    /**
     * Staff melihat seluruh pendaftaran
     */
    public function staffIndex()
    {
        $pendaftarans = Pendaftaran::with([
            'mahasiswa',
            'lomba'
        ])
            ->latest()
            ->paginate(15);

        return view(
            'staff.pendaftaran.index',
            compact('pendaftarans')
        );
    }

    /**
     * Staff mengubah status pendaftaran
     */
    /**
 * Menampilkan halaman edit status pendaftaran untuk staff
 */
    public function edit(Pendaftaran $pendaftaran)
    {
        $pendaftaran->load(['mahasiswa', 'lomba']);

        return view('staff.pendaftaran.edit', compact('pendaftaran'));
    }
    public function updateStatus(
        Request $request,
        Pendaftaran $pendaftaran
    ) {
        $data = $request->validate([
            'status' => 'required|in:Menunggu,Diproses,Diterima,Ditolak',
            'catatan' => 'nullable',
        ]);

        /*
        |--------------------------------------------------------------------------
        | Simpan status lama
        |--------------------------------------------------------------------------
        |
        | Ini penting supaya notifikasi hanya dibuat
        | ketika status benar-benar berubah.
        |
        */

        $oldStatus = $pendaftaran->status;

        /*
        |--------------------------------------------------------------------------
        | Update data pendaftaran
        |--------------------------------------------------------------------------
        */

        $pendaftaran->update($data);

        /*
        |--------------------------------------------------------------------------
        | Ambil data mahasiswa dan lomba
        |--------------------------------------------------------------------------
        */

        $pendaftaran->load([
            'mahasiswa',
            'lomba'
        ]);

        /*
        |--------------------------------------------------------------------------
        | NOTIFIKASI MAHASISWA
        |--------------------------------------------------------------------------
        |
        | Hanya dibuat jika status berbeda dari sebelumnya.
        |
        */

        if ($oldStatus !== $pendaftaran->status) {

            $mahasiswa = $pendaftaran->mahasiswa;
            $lomba = $pendaftaran->lomba;

            $title = 'Status Pendaftaran Diperbarui';

            $message =
                'Status pendaftaran kamu untuk lomba "' .
                $lomba->nama .
                '" diperbarui menjadi ' .
                $pendaftaran->status .
                '.';

            $type = 'pendaftaran_update';

            /*
            |--------------------------------------------------------------------------
            | STATUS DITERIMA
            |--------------------------------------------------------------------------
            */

            if ($pendaftaran->status === 'Diterima') {

                $title = 'Pendaftaran Diterima';

                $message =
                    'Selamat! Pendaftaran kamu untuk lomba "' .
                    $lomba->nama .
                    '" telah diterima.';

                $type = 'pendaftaran_diterima';
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS DITOLAK
            |--------------------------------------------------------------------------
            */

            elseif ($pendaftaran->status === 'Ditolak') {

                $title = 'Pendaftaran Ditolak';

                $message =
                    'Pendaftaran kamu untuk lomba "' .
                    $lomba->nama .
                    '" ditolak.';

                /*
                | Tambahkan catatan staff jika ada
                */

                if (!empty($pendaftaran->catatan)) {

                    $message .=
                        ' Catatan: ' .
                        $pendaftaran->catatan;
                }

                $type = 'pendaftaran_ditolak';
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS DIPROSES
            |--------------------------------------------------------------------------
            */

            elseif ($pendaftaran->status === 'Diproses') {

                $title = 'Pendaftaran Sedang Diproses';

                $message =
                    'Pendaftaran kamu untuk lomba "' .
                    $lomba->nama .
                    '" sedang diproses oleh staff.';

                $type = 'pendaftaran_diproses';
            }

            /*
            |--------------------------------------------------------------------------
            | STATUS MENUNGGU
            |--------------------------------------------------------------------------
            */

            elseif ($pendaftaran->status === 'Menunggu') {

                $title = 'Status Pendaftaran Diperbarui';

                $message =
                    'Status pendaftaran kamu untuk lomba "' .
                    $lomba->nama .
                    '" diperbarui menjadi Menunggu.';

                $type = 'pendaftaran_update';
            }

            /*
            |--------------------------------------------------------------------------
            | Simpan notifikasi
            |--------------------------------------------------------------------------
            */

            Notification::create([
                'user_id' => $mahasiswa->user_id,

                'title' => $title,

                'message' => $message,

                'type' => $type,

                'is_read' => false,

                'url' => route(
                    'mahasiswa.pendaftaran.index'
                ),
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | Kembali ke halaman staff
        |--------------------------------------------------------------------------
        */

        return back()->with(
            'success',
            'Status pendaftaran diperbarui.'
        );
    }
}