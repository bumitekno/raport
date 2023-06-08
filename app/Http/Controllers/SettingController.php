<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Setting\SettingRequest;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        session()->put('title', 'Setelan Sekolah');
        $setting = json_decode(Storage::get('settings.json'), true);
        return view('content.setting.v_form_setting', compact('setting'));
    }

    public function updateOrCreate(SettingRequest $request)
    {
        $data = $request->validated();
        $settings = json_decode(Storage::get('settings.json'), true);
        if ($request->hasFile('logo')) {
            $data = ImageHelper::upload_asset($request, 'logo', 'logo', $data);
            $settings['logo'] = $data['logo'];
        }

        $settings['name_school'] = $data['name_school'];
        $settings['name_application'] = $data['name_application'];
        $settings['npsn'] = $data['npsn'];
        $settings['address'] = $data['address'];
        $settings['phone'] = $data['phone'];
        $settings['email'] = $data['email'];
        $settings['max_upload'] = $data['max_upload'];
        $settings['size_compress'] = $data['size_compress'];
        $settings['website'] = $data['website'];
        $settings['format_image'] = $data['format_image'];
        $settings['footer'] = $data['footer'];


        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
        session()->put('logo', isset($setting['logo']) ? asset($setting['logo']) : asset('asset/img/90x90.jpg'));

        Helper::toast('Berhasil memperbarui pegaturan', 'success');
        return redirect()->back();
    }
}
