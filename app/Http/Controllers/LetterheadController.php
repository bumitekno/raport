<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Setting\LetterHeadRequest;
use App\Models\Letterhead;
use Illuminate\Http\Request;

class LetterheadController extends Controller
{
    public function index()
    {
        session()->put('title', 'Pengaturan Kop Raport');
        $data_array = [];
        $kop = Letterhead::first();
        if ($kop) {
            $data_array['kop'] = $kop;
        }
        // dd($kop);
        return view('content.setting.v_form_letterhead', $data_array);
    }

    public function updateOrCreate(LetterHeadRequest $request)
    {
        $data = $request->validated();
        // dd($request);

        $letterhead = Letterhead::updateOrCreate([], [
            'text1' => $data['text1'],
            'text2' => $data['text2'],
            'text3' => $data['text3'],
            'text4' => $data['text4'],
            'text5' => $data['text5'],
        ]);

        if ($request->hasFile('left_logo')) {
            $data = ImageHelper::upload_asset($request, 'left_logo', 'letter_head', $data);
            $letterhead->left_logo = $data['left_logo'];
        }

        if ($request->hasFile('right_logo')) {
            $data = ImageHelper::upload_asset($request, 'right_logo', 'letter_head', $data);
            $letterhead->right_logo = $data['right_logo'];
        }
        // dd($letterhead);

        $letterhead->save();

        Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        return redirect()->back();
    }

    public function removeImage($image)
    {
        $letterhead = Letterhead::firstOrFail();
        $letterhead->update([$image => null]);
        // $letterhead->update(array('image' => 'asdasd'));
        // if ($request->hasFile('left_logo')) {
        //     $letterhead->left_logo = $data['left_logo'];
        // }
        return redirect()->back();
    }
}
