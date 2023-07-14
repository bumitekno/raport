<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Setting\SettingRequest;
use Illuminate\Support\Facades\Storage;
use App\Models\School;

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

        // save setting database 
        School::updateOrCreate([
            'id' => 1
        ], [
            'id' => 1,
            'name' => $data['name_school'],
            'slug' => '1 -' . Helper::str_random(5),
            'address' => $data['address'],
            'image' => $data['logo'] ?? asset('asset/img/90x90.jpg'),
            'phone_number' => $data['phone'],
            'email' => $data['email'],
            'key' => Helper::str_random(5)
        ]);

        Storage::put('settings.json', json_encode($settings, JSON_PRETTY_PRINT));
        session()->put('logo', isset($settings['logo']) ? asset($settings['logo']) : asset('asset/img/90x90.jpg'));

        Helper::toast('Berhasil memperbarui pegaturan', 'success');
        return redirect()->back();
    }
}