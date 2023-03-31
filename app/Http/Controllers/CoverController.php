<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Setting\CoverRequest;
use App\Http\Resources\Master\SchoolYearResource;
use App\Models\Cover;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class CoverController extends Controller
{
    public function index()
    {
        // dd('ping');
        session()->put('title', 'Pengaturan Sampul Raport');
        $years = SchoolYear::all();
        $years = SchoolYearResource::collection($years)->toArray(request());
        // dd($years);
        $data_array = [
            'years' => $years
        ];
        $cover = Cover::where('id_school_year', session('id_school_year'))->first();
        if ($cover) {
            $data_array['cover'] = $cover;
        }
        return view('content.setting.v_form_cover', $data_array);
    }

    public function updateOrCreate(CoverRequest $request)
    {
        // dd($request);
        $data = $request->toArray();
        if ($request->hasFile('left_logo')) {
            $data = ImageHelper::upload_asset($request, 'left_logo', 'cover', $data);
        }
        if ($request->hasFile('right_logo')) {
            $data = ImageHelper::upload_asset($request, 'right_logo', 'cover', $data);
        }

        Cover::updateOrCreate(
            ['id_school_year' => $request->id_school_year],
            $data
        );
        Helper::toast('Berhasil menyimpan Sampul Raport', 'success');
        return redirect()->back();
    }

    // public function error()
    // {
    //     session()->put('message', 'Anda belum terdaftar menjadi pengampu pelajaran');
    //     return view('pages.v_error');
    // }
}
