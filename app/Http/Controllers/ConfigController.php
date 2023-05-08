<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Setting\ConfigRequest;
use App\Http\Resources\Master\SchoolYearResource;
use App\Models\Config;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class ConfigController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        session()->put('title', 'Pengaturan Config Raport');
        $years = SchoolYear::all();
        $years = SchoolYearResource::collection($years)->toArray(request());
        $data_array = [
            'years' => $years
        ];
        $detail_school_year = SchoolYear::where('slug', $_GET['year'])->first();
        $config = Config::where('id_school_year', $detail_school_year->id)->first();
        if ($config) {
            $data_array['config'] = $config;
        }
        // dd($config);
        return view('content.setting.v_form_config', $data_array);
    }

    public function updateOrCreate(ConfigRequest $request)
    {
        $id_school_year = SchoolYear::where('slug', $request->id_school_year)->first()->id;
        $data = $request->toArray();
        $data['id_school_year'] = $id_school_year;
        // dd($data);
        if ($request->hasFile('signature')) {
            $data = ImageHelper::upload_asset($request, 'signature', 'signature', $data);
        }
        Config::updateOrCreate(
            ['id_school_year' => $id_school_year],
            $data
        );
        Helper::toast('Berhasil menyimpan Konfigurasi', 'success');
        return redirect()->back();
    }
}
