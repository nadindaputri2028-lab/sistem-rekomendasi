<?php
namespace App\Http\Controllers;
use App\Models\Portfolio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PortfolioController extends Controller
{
    private function mahasiswa(){ return \App\Models\Mahasiswa::where('user_id',session('user_id'))->firstOrFail(); }
    public function index(){ $m=$this->mahasiswa(); $portfolios=$m->portfolios()->latest()->get(); return view('mahasiswa.portfolio.index',compact('portfolios')); }
    public function create(){ return view('mahasiswa.portfolio.create'); }
    public function store(Request $request){
        $m=$this->mahasiswa();
        $data=$request->validate(['nama_kegiatan'=>'required','posisi'=>'nullable','organisasi'=>'nullable','periode_mulai'=>'nullable|date','periode_selesai'=>'nullable|date','deskripsi'=>'nullable','bukti'=>'nullable|file|max:4096']);
        if($request->hasFile('bukti')) $data['bukti']=$request->file('bukti')->store('portfolio','public');
        $m->portfolios()->create($data);
        return redirect()->route('mahasiswa.portfolio.index')->with('success','Portfolio berhasil ditambahkan.');
    }
    public function edit(Portfolio $portfolio){ abort_unless($portfolio->mahasiswa->user_id===session('user_id'),403); return view('mahasiswa.portfolio.edit',compact('portfolio')); }
    public function update(Request $request, Portfolio $portfolio){
        abort_unless($portfolio->mahasiswa->user_id===session('user_id'),403);
        $data=$request->validate(['nama_kegiatan'=>'required','posisi'=>'nullable','organisasi'=>'nullable','periode_mulai'=>'nullable|date','periode_selesai'=>'nullable|date','deskripsi'=>'nullable','bukti'=>'nullable|file|max:4096']);
        if($request->hasFile('bukti')){ if($portfolio->bukti) Storage::disk('public')->delete($portfolio->bukti); $data['bukti']=$request->file('bukti')->store('portfolio','public'); }
        $portfolio->update($data); return redirect()->route('mahasiswa.portfolio.index')->with('success','Portfolio diperbarui.');
    }
    public function destroy(Portfolio $portfolio){ abort_unless($portfolio->mahasiswa->user_id===session('user_id'),403); if($portfolio->bukti) Storage::disk('public')->delete($portfolio->bukti); $portfolio->delete(); return back()->with('success','Portfolio dihapus.'); }
}
