<?php
namespace App\Http\Controllers;
use App\Models\Pendaftaran;
use App\Models\Lomba;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    public function index(){
        $m=\App\Models\Mahasiswa::where('user_id',session('user_id'))->firstOrFail();
        $pendaftarans=$m->pendaftarans()->with('lomba')->latest()->paginate(10);
        return view('mahasiswa.pendaftaran.index',compact('pendaftarans'));
    }
    public function store(Request $request,Lomba $lomba){
        $m=\App\Models\Mahasiswa::where('user_id',session('user_id'))->firstOrFail();
        if($lomba->deadline->isPast()) return back()->with('error','Pendaftaran lomba sudah ditutup.');
        Pendaftaran::firstOrCreate(['mahasiswa_id'=>$m->id,'lomba_id'=>$lomba->id],['status'=>'Menunggu','tanggal_daftar'=>now()]);
        return redirect()->route('mahasiswa.pendaftaran.index')->with('success','Pendaftaran berhasil dikirim.');
    }
    public function staffIndex(){
        $pendaftarans=Pendaftaran::with(['mahasiswa','lomba'])->latest()->paginate(15);
        return view('staff.pendaftaran.index',compact('pendaftarans'));
    }
    public function updateStatus(Request $request,Pendaftaran $pendaftaran){
        $data=$request->validate(['status'=>'required|in:Menunggu,Diproses,Diterima,Ditolak','catatan'=>'nullable']);
        $pendaftaran->update($data); return back()->with('success','Status pendaftaran diperbarui.');
    }
}
