<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    private function mahasiswa()
    {
        return \App\Models\Mahasiswa::where(
            'user_id',
            session('user_id')
        )->firstOrFail();
    }

    public function index()
    {
        $m = $this->mahasiswa();

        $portfolios = $m->portfolios()
            ->latest()
            ->get();

        return view(
            'mahasiswa.portfolio.index',
            compact('portfolios')
        );
    }

    public function create()
    {
        return view('mahasiswa.portfolio.create');
    }

    public function store(Request $request)
    {
        $m = $this->mahasiswa();

        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'posisi' => 'nullable|string|max:255',
            'organisasi' => 'nullable|string|max:255',
            'periode_mulai' => 'nullable|date',
            'periode_selesai' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('bukti')) {
            $data['bukti'] = $request->file('bukti')
                ->store('portfolio', 'public');
        }

        $m->portfolios()->create($data);

        return redirect()
            ->route('mahasiswa.portfolio.index')
            ->with('success', 'Portfolio berhasil ditambahkan.');
    }

    public function edit(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa->user_id === session('user_id'),
            403
        );

        return view(
            'mahasiswa.portfolio.edit',
            compact('portfolio')
        );
    }

    public function update(
        Request $request,
        Portfolio $portfolio
    ) {
        abort_unless(
            $portfolio->mahasiswa->user_id === session('user_id'),
            403
        );

        $data = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'posisi' => 'nullable|string|max:255',
            'organisasi' => 'nullable|string|max:255',
            'periode_mulai' => 'nullable|date',
            'periode_selesai' => 'nullable|date',
            'deskripsi' => 'nullable|string',
            'bukti' => 'nullable|file|max:4096',
        ]);

        if ($request->hasFile('bukti')) {

            if (
                $portfolio->bukti &&
                Storage::disk('public')->exists($portfolio->bukti)
            ) {
                Storage::disk('public')->delete($portfolio->bukti);
            }

            $data['bukti'] = $request->file('bukti')
                ->store('portfolio', 'public');
        }

        $portfolio->update($data);

        return redirect()
            ->route('mahasiswa.portfolio.index')
            ->with('success', 'Portfolio berhasil diperbarui.');
    }

    public function destroy(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa->user_id === session('user_id'),
            403
        );

        if (
            $portfolio->bukti &&
            Storage::disk('public')->exists($portfolio->bukti)
        ) {
            Storage::disk('public')->delete($portfolio->bukti);
        }

        $portfolio->delete();

        return redirect()
            ->route('mahasiswa.portfolio.index')
            ->with('success', 'Portfolio berhasil dihapus.');
    }

    /*
    |--------------------------------------------------------------------------
    | STAFF
    |--------------------------------------------------------------------------
    */

    public function staffIndex()
    {
        $portfolios = Portfolio::with('mahasiswa')
            ->latest()
            ->get();

        return view(
            'staff.portfolio.index',
            compact('portfolios')
        );
    }

    public function staffShow(Portfolio $portfolio)
    {
        $portfolio->load('mahasiswa');

        return view(
            'staff.portfolio.show',
            compact('portfolio')
        );
    }

    public function viewBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        $path = $disk->path($portfolio->bukti);

        return response()->download($path);
    }

    public function previewBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        $path = $disk->path($portfolio->bukti);

        return response()->file($path);
    }
}