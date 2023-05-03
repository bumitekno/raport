<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Alert;
use App\Helpers\Helper;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function login()
    {
        session()->put('title', 'Login');
        return view('content.auth.v_login');
    }

    public function verify_login(Request $request)
    {
        $this->validate($request, [
            'username' => 'required',
            'password' => 'required'
        ]);
        // dd($request);

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
}
