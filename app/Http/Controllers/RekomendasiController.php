<?php
namespace App\Http\Controllers;
use App\Models\Lomba;
use App\Services\RekomendasiService;
use Illuminate\Http\Request;

class RekomendasiController extends Controller
{
    public function index(){ $lombas=Lomba::latest()->get(); return view('staff.rekomendasi.index',compact('lombas')); }
    public function calculate(Request $request,RekomendasiService $service){
        $request->validate(['lomba_id'=>'required|exists:lombas,id']);
        $lomba=Lomba::findOrFail($request->lomba_id);
        $result=$service->calculate($lomba);
        return redirect()->route('staff.rekomendasi.show',$lomba)->with('success','Perhitungan AHP + SAW berhasil dilakukan.');
    }
    public function show(Lomba $lomba){
        $results=$lomba->rekomendasis()->with('mahasiswa')->orderBy('ranking')->get();
        $criteria=$lomba->kriterias;
        return view('staff.rekomendasi.show',compact('lomba','results','criteria'));
    }
    public function forStudent(){
        $m=\App\Models\Mahasiswa::where('user_id',session('user_id'))->firstOrFail();
        $lombas=Lomba::where('status','Aktif')->whereDate('deadline','>=',now())->with('kriterias')->latest()->get();
        return view('mahasiswa.rekomendasi.index',compact('lombas','m'));
    }
    public function pdf(Lomba $lomba){
        $results=$lomba->rekomendasis()->with('mahasiswa')->orderBy('ranking')->get();
        return view('staff.rekomendasi.pdf',compact('lomba','results'));
    }
}
