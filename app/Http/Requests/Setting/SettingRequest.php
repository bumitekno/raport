<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name_school' => 'required',
            'name_application' => 'required',
            'npsn' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required|email',
            'max_upload' => 'required|numeric',
            'size_compress' => 'required|numeric',
            'website' => 'nullable|url',
            'format_image' => 'required',
            'footer' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name_school.required' => 'Nama sekolah harus diisi.',
            'name_application.required' => 'Nama aplikasi harus diisi.',
            'npsn.required' => 'NPSN harus diisi.',
            'address.required' => 'Alamat harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'email.required' => 'Alamat email harus diisi.',
            'email.email' => 'Alamat email tidak valid.',
            'max_upload.required' => 'Maksimal ukuran unggahan harus diisi.',
            'max_upload.numeric' => 'Maksimal ukuran unggahan harus berupa angka.',
            'size_compress.required' => 'Kualitas kompresi harus diisi.',
            'size_compress.numeric' => 'Kualitas kompresi harus berupa angka.',
            'website.url' => 'Alamat situs web tidak valid.',
            'format_image.required' => 'Format unggahan harus diisi.',
            'footer.required' => 'Teks footer harus diisi.',
        ];
    }
}
