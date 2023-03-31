<?php

namespace App\Http\Controllers;

use App\Models\Letterhead;
use Illuminate\Http\Request;

class LetterheadController extends Controller
{
    public function index()
    {
        session()->put('title', 'Pengaturan Kop Raport');
        $data_array = [];
        $cover = Letterhead::first();
        if ($cover) {
            $data_array['cover'] = $cover;
        }
        return view('content.setting.v_form_letterhead', $data_array);
    }
}
