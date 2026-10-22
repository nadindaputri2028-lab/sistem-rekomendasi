<?php

namespace App\Http\Controllers;

use App\Models\Lomba;
use App\Models\User;
use App\Models\Notification;
use Illuminate\Http\Request;

class LombaController extends Controller
{
    public function index(Request $request)
    {
        $q = $request->get('q');
        $kategori = $request->get('kategori');
        $tingkat = $request->get('tingkat');

        $query = Lomba::query()
            ->when(
                $q,
                fn($x) => $x->where(
                    'nama',
                    'like',
                    "%$q%"
                )
            )
            ->when(
                $kategori,
                fn($x) => $x->where(
                    'kategori',
                    $kategori
                )
            )
            ->when(
                $tingkat,
                fn($x) => $x->where(
                    'tingkat',
                    $tingkat
                )
            )
            ->latest();

        $lombas = $query
            ->paginate(10)
            ->withQueryString();

        if (session('role') === 'staff') {
            return view(
                'staff.lomba.index',
                compact('lombas')
            );
        }

        return view(
            'mahasiswa.lomba.index',
            compact(
                'lombas',
                'q',
                'kategori',
                'tingkat'
            )
        );
    }

    public function show(Lomba $lomba)
    {
        $lomba->load('kriterias');

        return view(
            'mahasiswa.lomba.show',
            compact('lomba')
        );
    }

    public function create()
    {
        return view('staff.lomba.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'subkategori' => 'nullable',
            'penyelenggara' => 'required',
            'tingkat' => 'nullable',
            'tanggal_pelaksanaan' => 'nullable|date',
            'deadline' => 'required|date',
            'lokasi' => 'nullable',
            'deskripsi' => 'nullable',
            'persyaratan' => 'nullable',
            'benefit' => 'nullable',
            'panduan' => 'nullable|url',
            'status' => 'required',
        ]);

        // Simpan lomba
        $lomba = Lomba::create($data);

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Lomba Baru
        |--------------------------------------------------------------------------
        */

        $mahasiswaUsers = User::where(
            'role',
            'mahasiswa'
        )->get();

        foreach ($mahasiswaUsers as $user) {

            Notification::create([
                'user_id' => $user->id,

                'title' => 'Lomba Baru Tersedia',

                'message' =>
                    'Lomba "' .
                    $lomba->nama .
                    '" telah ditambahkan ke sistem. Silakan cek detail lomba dan persyaratannya.',

                'type' => 'lomba_baru',

                'is_read' => false,

                'url' => route(
                    'mahasiswa.lomba.show',
                    $lomba
                ),
            ]);
        }

        return redirect()
            ->route('staff.lomba.index')
            ->with(
                'success',
                'Data lomba berhasil ditambahkan.'
            );
    }

    public function edit(Lomba $lomba)
    {
        return view(
            'staff.lomba.edit',
            compact('lomba')
        );
    }

    public function update(
        Request $request,
        Lomba $lomba
    ) {
        $data = $request->validate([
            'nama' => 'required',
            'kategori' => 'required',
            'subkategori' => 'nullable',
            'penyelenggara' => 'required',
            'tingkat' => 'nullable',
            'tanggal_pelaksanaan' => 'nullable|date',
            'deadline' => 'required|date',
            'lokasi' => 'nullable',
            'deskripsi' => 'nullable',
            'persyaratan' => 'nullable',
            'benefit' => 'nullable',
            'panduan' => 'nullable|url',
            'status' => 'required',
        ]);

        // Update data lomba
        $lomba->update($data);

        /*
        |--------------------------------------------------------------------------
        | Notifikasi Pembaruan Lomba
        |--------------------------------------------------------------------------
        */

        $mahasiswaUsers = User::where(
            'role',
            'mahasiswa'
        )->get();

        foreach ($mahasiswaUsers as $user) {

            Notification::create([
                'user_id' => $user->id,

                'title' => 'Pembaruan Data Lomba',

                'message' =>
                    'Data lomba "' .
                    $lomba->nama .
                    '" telah diperbarui oleh staff.',

                'type' => 'lomba_update',

                'is_read' => false,

                'url' => route(
                    'mahasiswa.lomba.show',
                    $lomba
                ),
            ]);
        }

        return redirect()
            ->route('staff.lomba.index')
            ->with(
                'success',
                'Data lomba diperbarui.'
            );
    }

    public function destroy(Lomba $lomba)
    {
        $lomba->delete();

        return back()->with(
            'success',
            'Lomba dihapus.'
        );
    }
}