<?php

namespace App\Http\Controllers;

use App\Models\Extracurricular;
use Illuminate\Http\Request;

class ScoreExtracurricularController extends Controller
{
    public function index()
    {
        // dd('halaman nilai ekstra');
        $extras = Extracurricular::where('status', 1)->get();
        // dd($extras);
        return view('content.extracurriculars.v_score_extracurricular', compact('extras'));
    }
}
