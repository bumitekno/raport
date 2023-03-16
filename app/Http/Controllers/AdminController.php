<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $admin = Admin::get();
        // dd($admin);
        return view('content.admins.v_admin', compact('admin'));
    }

    public function create()
    {
        return view('content.admins.v_create');
    }

    public function store(Request $request)
    {
        dd($request);
    }
}
