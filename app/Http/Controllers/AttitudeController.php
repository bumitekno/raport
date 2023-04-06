<?php

namespace App\Http\Controllers;

use App\Models\Attitude;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttitudeController extends Controller
{
    public function index(Request $request, $type)
    {
        session()->put('title', 'Sikap Sosial');
        $attitudes = Attitude::select('*')->where('type', 'social')->get();
        return view('content.attitudes.v_attitude', compact('attitudes'));
    }

    public function spiritual()
    {
        return view('content.attitudes.v_attitude');
    }

    public function create()
    {
        return view('content.attitudes.v_form_attitude');
    }

    public function storeOrUpdate(Request $request)
    {
        dd($request);
    }
}
