<?php

namespace App\Http\Controllers;

use App\Models\Portfolio;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    private function mahasiswa()
    {
        return Mahasiswa::where(
            'user_id',
            session('user_id')
        )->firstOrFail();
    }

    // DAFTAR PORTFOLIO MAHASISWA
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

    // DETAIL PORTFOLIO MAHASISWA
    public function show(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
            403
        );

        $portfolio->load('mahasiswa');

        return view(
            'mahasiswa.portfolio.show',
            compact('portfolio')
        );
    }

    // PREVIEW BUKTI PORTFOLIO MAHASISWA
    public function previewBuktiMahasiswa(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
            403
        );

        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->file(
            $disk->path($portfolio->bukti)
        );
    }

    // DOWNLOAD BUKTI PORTFOLIO MAHASISWA
    public function downloadBuktiMahasiswa(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
            403
        );

        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->download(
            $disk->path($portfolio->bukti)
        );
    }

    // CETAK / EXPORT PORTFOLIO MAHASISWA KE PDF
    public function exportPdf()
    {
        $m = $this->mahasiswa();

        $portfolios = $m->portfolios()
            ->orderByDesc('periode_mulai')
            ->get();

        return view(
            'mahasiswa.portfolio.pdf',
            compact('m', 'portfolios')
        );
    }

    // CETAK / EXPORT PORTFOLIO MAHASISWA TERTENTU (STAFF)
    public function exportPdfStaff(Mahasiswa $mahasiswa)
    {
        $m = $mahasiswa;

        $portfolios = $mahasiswa->portfolios()
            ->orderByDesc('periode_mulai')
            ->get();

        return view(
            'mahasiswa.portfolio.pdf',
            compact('m', 'portfolios')
        );
    }

    // TAMBAH PORTFOLIO
    public function create()
    {
        return view('mahasiswa.portfolio.create');
    }

    // SIMPAN PORTFOLIO
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

    // EDIT PORTFOLIO
    public function edit(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
            403
        );

        return view(
            'mahasiswa.portfolio.edit',
            compact('portfolio')
        );
    }

    // UPDATE PORTFOLIO
    public function update(
        Request $request,
        Portfolio $portfolio
    ) {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
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

    // HAPUS PORTFOLIO
    public function destroy(Portfolio $portfolio)
    {
        abort_unless(
            $portfolio->mahasiswa &&
            $portfolio->mahasiswa->user_id == session('user_id'),
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


    // ==========================================
    // PORTFOLIO DOSEN
    // ==========================================

    // Menampilkan seluruh portfolio mahasiswa
    public function dosenIndex(Request $request)
    {
        $search = $request->input('search');

        $portfolios = Portfolio::with('mahasiswa')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {

                    $q->where('nama_kegiatan', 'like', "%{$search}%")
                      ->orWhereHas('mahasiswa', function ($m) use ($search) {
                          $m->where('nama_lengkap', 'like', "%{$search}%")
                            ->orWhere('nim', 'like', "%{$search}%");
                      });

                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view(
            'dosen.portfolio.index',
            compact('portfolios', 'search')
        );
    }

    // Menampilkan detail portfolio
    public function dosenShow(Portfolio $portfolio)
    {
        $portfolio->load('mahasiswa');

        return view(
            'dosen.portfolio.show',
            compact('portfolio')
        );
    }

    // Preview bukti portfolio Dosen
    public function dosenPreviewBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->file(
            $disk->path($portfolio->bukti)
        );
    }

    // Download bukti portfolio Dosen
    public function dosenDownloadBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->download(
            $disk->path($portfolio->bukti)
        );
    }

    // STAFF
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

    // DOWNLOAD BUKTI PORTFOLIO STAFF
    public function viewBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->download(
            $disk->path($portfolio->bukti)
        );
    }

    // PREVIEW BUKTI PORTFOLIO STAFF
    public function previewBukti(Portfolio $portfolio)
    {
        if (!$portfolio->bukti) {
            abort(404, 'File bukti tidak tersedia.');
        }

        $disk = Storage::disk('public');

        if (!$disk->exists($portfolio->bukti)) {
            abort(404, 'File bukti tidak ditemukan.');
        }

        return response()->file(
            $disk->path($portfolio->bukti)
        );
    }
}