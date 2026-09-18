<?php
namespace App\Http\Controllers;
use App\Models\User;
use App\Models\Mahasiswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function pilihan(){ return view('auth.pilihan-login'); }
    public function mahasiswaForm(){ return view('auth.login-mahasiswa'); }
    public function staffForm(){ return view('auth.login-staff'); }

    public function mahasiswaLogin(Request $request){
        $data = $request->validate(['login'=>'required','password'=>'required']);
        $user = User::where('email',$data['login'])->where('role','mahasiswa')->first();
        if (!$user) {
            $m = Mahasiswa::where('nim',$data['login'])->orWhere('email',$data['login'])->first();
            $user = $m?->user;
        }
        if (!$user || !Hash::check($data['password'],$user->password)) {
            return back()->withInput()->with('error','NIM/email atau password salah.');
        }
        session(['user_id'=>$user->id,'role'=>$user->role]);
        return redirect()->route('mahasiswa.dashboard');
    }

    public function staffLogin(Request $request){
        $data = $request->validate(['login'=>'required','password'=>'required']);
        $user = User::whereIn('role',['staff','admin'])->where('email',$data['login'])->first();
        if (!$user || !Hash::check($data['password'],$user->password)) {
            return back()->withInput()->with('error','Username/email atau password salah.');
        }
        session(['user_id'=>$user->id,'role'=>'staff']);
        return redirect()->route('staff.dashboard');
    }

    public function logout(Request $request){
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success','Anda telah logout.');
    }
}
