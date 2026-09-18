<?php
namespace App\Http\Controllers;
use App\Models\Kriteria;
use App\Models\Lomba;
use Illuminate\Http\Request;

class KriteriaController extends Controller
{
    public function index(Request $request){
        $lomba=Lomba::find($request->lomba_id) ?? Lomba::latest()->first();
        $kriterias=$lomba ? $lomba->kriterias()->get() : collect();
        $lombas=Lomba::latest()->get();
        return view('staff.kriteria.index',compact('lomba','kriterias','lombas'));
    }
    public function store(Request $request){
        $data=$request->validate(['lomba_id'=>'required|exists:lombas,id','kode'=>'required','nama'=>'required','bobot'=>'required|numeric|min:0','jenis'=>'required|in:benefit,cost','nilai_minimum'=>'nullable|numeric|min:0','deskripsi'=>'nullable']);
        Kriteria::create($data); return back()->with('success','Kriteria berhasil ditambahkan.');
    }
    public function update(Request $request,Kriteria $kriteria){
        $data=$request->validate(['kode'=>'required','nama'=>'required','bobot'=>'required|numeric|min:0','jenis'=>'required|in:benefit,cost','nilai_minimum'=>'nullable|numeric|min:0','deskripsi'=>'nullable']);
        $kriteria->update($data); return back()->with('success','Kriteria diperbarui.');
    }
    public function destroy(Kriteria $kriteria){ $kriteria->delete(); return back()->with('success','Kriteria dihapus.'); }
}
