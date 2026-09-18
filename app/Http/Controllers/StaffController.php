<?php
namespace App\Http\Controllers;
use App\Models\Mahasiswa;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class StaffController extends Controller
{
    public function dashboard(){
        $totalMahasiswa=Mahasiswa::count(); $totalPortfolio=\App\Models\Portfolio::count(); $totalLomba=\App\Models\Lomba::count(); $totalPendaftaran=\App\Models\Pendaftaran::count();
        $terbaru=\App\Models\Pendaftaran::with(['mahasiswa','lomba'])->latest()->take(5)->get();
        return view('staff.dashboard',compact('totalMahasiswa','totalPortfolio','totalLomba','totalPendaftaran','terbaru'));
    }
    public function index(Request $request){
        $mahasiswas=Mahasiswa::when($request->q,fn($q)=>$q->where('nama_lengkap','like','%'.$request->q.'%')->orWhere('nim','like','%'.$request->q.'%'))->latest()->paginate(10)->withQueryString();
        return view('staff.mahasiswa.index',compact('mahasiswas'));
    }
    public function create(){ return view('staff.mahasiswa.create'); }
    public function store(Request $request){
        $data=$request->validate(['nama_lengkap'=>'required','nim'=>'required|unique:mahasiswas,nim','prodi'=>'required','semester'=>'required|integer|min:1|max:14','email'=>'required|email|unique:users,email','no_hp'=>'nullable','ipk'=>'nullable|numeric|min:0|max:4','ips'=>'nullable|numeric|min:0|max:4','prestasi'=>'nullable','keahlian'=>'nullable','minat'=>'nullable','foto'=>'nullable|image|max:2048']);
        $user=User::create(['name'=>$data['nama_lengkap'],'email'=>$data['email'],'password'=>Hash::make('password'),'role'=>'mahasiswa']);
        $data['user_id']=$user->id;
        if($request->hasFile('foto')) $data['foto']=$request->file('foto')->store('mahasiswa','public');
        Mahasiswa::create($data);
        return redirect()->route('staff.mahasiswa.index')->with('success','Mahasiswa berhasil ditambahkan. Password awal: password');
    }
    public function show(Mahasiswa $mahasiswa){ return view('staff.mahasiswa.show',compact('mahasiswa')); }
    public function edit(Mahasiswa $mahasiswa){ return view('staff.mahasiswa.edit',compact('mahasiswa')); }
    public function update(Request $request,Mahasiswa $mahasiswa){
        $data=$request->validate(['nama_lengkap'=>'required','nim'=>'required|unique:mahasiswas,nim,'.$mahasiswa->id,'prodi'=>'required','semester'=>'required|integer|min:1|max:14','email'=>'required|email|unique:users,email,'.($mahasiswa->user_id ?? 'NULL'),'no_hp'=>'nullable','ipk'=>'nullable|numeric|min:0|max:4','ips'=>'nullable|numeric|min:0|max:4','prestasi'=>'nullable','keahlian'=>'nullable','minat'=>'nullable','foto'=>'nullable|image|max:2048']);
        if($request->hasFile('foto')){ if($mahasiswa->foto) Storage::disk('public')->delete($mahasiswa->foto); $data['foto']=$request->file('foto')->store('mahasiswa','public'); }
        $mahasiswa->update($data); $mahasiswa->user?->update(['name'=>$data['nama_lengkap'],'email'=>$data['email']]);
        return redirect()->route('staff.mahasiswa.index')->with('success','Data mahasiswa diperbarui.');
    }
    public function destroy(Mahasiswa $mahasiswa){
        if($mahasiswa->foto) Storage::disk('public')->delete($mahasiswa->foto);
        $mahasiswa->user?->delete(); $mahasiswa->delete(); return back()->with('success','Mahasiswa dihapus.');
    }
}
