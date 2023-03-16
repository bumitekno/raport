<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        return view('content.dashboard.v_admin');
    }

    public function user()
    {
        return view('content-users.dashboard.v_dashboard');
    }
}
