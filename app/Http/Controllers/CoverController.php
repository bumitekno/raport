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
        // dd(session()->all());
        session()->put('title', 'Pengaturan Sampul Raport');
        $years = SchoolYear::all();
        $years = SchoolYearResource::collection($years)->toArray(request());
        // dd($years);
        $data_array = [
            'years' => $years
        ];
        $detail_year = SchoolYear::where('slug', $_GET['year'])->first();
        $result_cover = Cover::where('id_school_year', $detail_year->id)->first();
        // dd($cover);
        $cover = [
            'title' => $result_cover ? $result_cover->title : null,
            'sub_title' => $result_cover ? $result_cover->sub_title : null,
            'footer' => $result_cover ? $result_cover->footer : null,
            'instruction' => $result_cover ? $result_cover->instruction : null,
            'left_logo' => $result_cover ? $result_cover->left_logo : null,
            'right_logo' => $result_cover ? $result_cover->right_logo : null,
        ];
        $data_array['cover'] = $cover;
        // dd($data_array);
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
