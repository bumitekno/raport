<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function admin()
    {
        // dd('admin');
        $school_year = SchoolYear::where('status', 1)->first();
        if ($school_year) {
            session()->put('id_school_year', $school_year->id);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
        }
        return view('content.dashboard.v_admin');
    }

    public function user()
    {
        return view('content-users.dashboard.v_dashboard');
    }

    public function teacher()
    {
        // dd('teacher');
        $school_year = SchoolYear::where('status', 1)->first();
        // dd($school_year);
        if ($school_year) {
            session()->put('id_school_year', $school_year->id);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
        } else {
            session()->put('message', 'Admin belum mengaktifkan tahun ajaran. Harap menghubungi admin untuk mengaktifkannya');
            return view('pages.v_error');
        }
        return view('content.dashboard.v_teacher');
    }
}
