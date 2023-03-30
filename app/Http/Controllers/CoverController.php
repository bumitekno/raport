<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CoverController extends Controller
{
    public function index()
    {
        session()->put('title', 'Pengaturan Config Raport');
        $years = SchoolYear::all();
        $years = SchoolYearResource::collection($years)->toArray(request());
        $data_array = [
            'years' => $years
        ];
        $config = Config::where('id_school_year', session('id_school_year'))->first();
        if($config){
            $data_array['config'] = $config;
        }
        return view('content.setting.v_form_config', $data_array);
    }

}
