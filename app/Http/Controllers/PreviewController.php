<?php

namespace App\Http\Controllers;

use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PreviewController extends Controller
{
    public function index()
    {
        $school_years = SchoolYear::all();
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('user')->check()) {
            $result = $school_years;
            return view('content.previews.v_preview', compact('result'));
        } elseif (Auth::guard('teacher')->check()) {
            // Auth::guard('teacher')->logout();
        } elseif (Auth::guard('parent')->check()) {
            Auth::guard('parent')->logout();
        }
    }
}
