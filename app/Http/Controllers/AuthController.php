<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Helpers\Helper;
use App\Models\Admin;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        //Cookie::forever('login', 'feri');
        //Cookie::forever('login1', 'feri1');
        setcookie("name", "value", time() + (86400 * 30));
        session()->put('title', 'Login');
        return view('content.auth.v_login');
    }

    public function verify_login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);

        if (Auth::guard('admin')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            Helper::alert('success', 'Selamat Datang !', 'Berhasil Login');
            session()->put('role', 'admin');
            return redirect()->intended('/dashboard');
        } else if (Auth::guard('teacher')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            // dd(Auth::guard('teacher')->user()->type);
            Helper::alert('success', 'Selamat Datang !', 'Berhasil Login');
            session()->put('role', 'teacher');
            session()->put('type-teacher', Auth::guard('teacher')->user()->type);
            session()->put('layout', 'teacher');
            return redirect()->route('teacher.dashboard');
        } else if (Auth::guard('user')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            session()->put('role', 'student');
            session()->put('id_student', Auth::guard('user')->user()->id);
            Helper::alert('success', 'Selamat Datang ' . Auth::guard('user')->user()->name . '!', 'Berhasil Login');
            return redirect()->route('user.dashboard');
        } else if (Auth::guard('parent')->attempt($this->check_credentials($request), $request->filled('remember'))) {
            session()->put('role', 'parent');
            session()->put('id_student', Auth::guard('parent')->user()->id_user);
            Helper::alert('success', 'Selamat Datang ' . Auth::guard('parent')->user()->name . '!', 'Berhasil Login');
            return redirect()->route('user.dashboard');
            // dd('login sebagai parent');
        }
        Helper::alert('error', 'Anda tidak mempunyai akses untuk login', '');
        return redirect()->back()->withInput($request->input());
    }

    protected function check_credentials(Request $request)
    {
        // dd($request);
        if (filter_var($request->get('username'), FILTER_VALIDATE_EMAIL)) {
            return ['email' => $request->get('username'), 'password' => $request->get('password'), 'status' => 1];
        }
        return ['phone' => $request->get('username'), 'password' => $request->get('password'), 'status' => 1];
    }

    public function logout()
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            Auth::guard('user')->logout();
        } elseif (Auth::guard('teacher')->check()) {
            Auth::guard('teacher')->logout();
        } elseif (Auth::guard('parent')->check()) {
            Auth::guard('parent')->logout();
        }
        Session::flush();
        Helper::alert('error', 'Anda sudah Logout', '');
        return redirect()->route('auth.login');
    }

    public function loginAsyn(Request $request){
       
        $credential = $request->credential;
        $role = 'admin';
        $email = 'brigitte.schuppe@example.com';

        if($role == 'admin'){
            $user = Admin::where('email', $email)->first();
            Auth::guard('admin')->login($user);
        }elseif($role == 'guru'){
            $user = Teacher::where('email', $email)->first();
            Auth::guard('teacher')->login($user);
        }else{
            $user = User::where('email', $email)->first();
            Auth::guard('user')->login($user);
        }

        return view('auth.callback-auth');

        // $encryptedData = "U2FsdGVkX18j48vxXfWFdZudi2XHsBDNeRCVbO4mhJ3uDPKhdpX5RAPGny4q30KT";

        // // Kunci enkripsi yang sama dengan yang digunakan di JavaScript
        // $secretKey = "KunciEnkripsiSaya";

        // // Dekripsi data
        // $decryptedData = openssl_decrypt($encryptedData, 'AES-256-CBC', $secretKey);
        // dd($decryptedData);
        
        dd($user);


    }
}
