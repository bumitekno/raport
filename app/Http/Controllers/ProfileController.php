<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index()
    {
        switch (session('role')) {
            case 'admin':
                return view('content.profiles.v_admin');
                break;
            case 'teacher':
                # code...
                break;

            default:
                # code...
                break;
        }
        // dd('profile');

    }
}
