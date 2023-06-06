<?php

namespace App\Helpers;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Image;
use Yaza\LaravelGoogleDriveStorage\Gdrive;

class ImageHelper

{

    public static function get_settings()
    {
        return json_decode(Storage::get('settings.json'), true);
    }

    public static function upload_asset($request, $name, $path, $data)
    {
        $setting = self::get_settings();
        $file = $request->file($name);
        $profileImage = date('YmdHis') . Helper::str_random(5) . "." . $file->getClientOriginalExtension();
        $resolution = isset($setting['size_compress']) ? $setting['size_compress'] : 200;
        $thumb = Image::make($file->getRealPath())->resize($resolution, $resolution, function ($constraint) {
            $constraint->aspectRatio();
        });
        $destination = public_path($path);
        Helper::check_and_make_dir($destination);
        $thumb->save($destination . '/' . $profileImage);
        $data[$name] = $path . '/' . $profileImage;
        return $data;
    }

    public static function upload_asset_drive($request, $name, $path, $data)
    {
        $setting = self::get_settings();
        $file = $request->file($name);
        $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $resolution = isset($setting['size_compress']) ? $setting['size_compress'] : 200;
        $thumb = Image::make($file->getRealPath())->resize($resolution, $resolution, function ($constraint) {
            $constraint->aspectRatio();
        });
        $destination = public_path($path);
        Helper::check_and_make_dir($destination);
        $thumb->save($destination . '/' . $profileImage);
        $data[$name] = $path . '/' . $profileImage;
        Gdrive::put($data[$name], $file);
        return $data;
    }

    public static function upload_file($request, $name, $path, $data)
    {
        $file = $request->file($name);
        $profileImage = date('YmdHis') . "." . $file->getClientOriginalExtension();
        $destinationPath = public_path($path);
        Helper::check_and_make_dir($destinationPath);
        $file->move($destinationPath, $profileImage);
        $data[$name] = $path . "/" . $profileImage;
        return $data;
    }


    public static function upload_drive($request, $name, $path, $data)
    {
        $asset = ImageHelper::upload_asset($request, $name, $path, $data);
        $dir_path = public_path() . '/' . $asset[$name];
        Gdrive::put($asset[$name], $dir_path);
        File::delete($asset[$name]);
        return $asset;
    }


    public static function show_drive($image)
    {
        $data = Gdrive::get($image);
        return response($data->file, 200)
            ->header('Content-Type', $data->ext);
    }

    public static function upload_multiple_asset_drive($file, $path)
    {
        $setting = self::get_settings();
        $profileImage = date('YmdHis') . Helper::str_random(5) . "." . $file->getClientOriginalExtension();
        $resolution = isset($setting['size_compress']) ? $setting['size_compress'] : 200;
        $thumb = Image::make($file->getRealPath())->resize($resolution, $resolution, function ($constraint) {
            $constraint->aspectRatio();
        });
        $destination = public_path($path);
        Helper::check_and_make_dir($destination);
        $thumb->save($destination . '/' . $profileImage);
        $data = $path . '/' . $profileImage;
        Gdrive::put($data, $file);
        return $data;
    }
}
