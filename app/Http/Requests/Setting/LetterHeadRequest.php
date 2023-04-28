<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class LetterHeadRequest extends FormRequest
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'text1' => 'required|string',
            'text2' => 'required|string',
            'text3' => 'required|string',
            'text4' => 'required|string',
            'text5' => 'required|string',
            'left_logo' => 'image|max:2048',
            'right_logo' => 'image|max:2048',
        ];
    }

    public function messages()
    {
        return [
            'text1.required' => 'Kolom Text 1 wajib diisi.',
            'text2.required' => 'Kolom Text 2 wajib diisi.',
            'text3.required' => 'Kolom Text 3 wajib diisi.',
            'text4.required' => 'Kolom Text 4 wajib diisi.',
            'text5.required' => 'Kolom Text 5 wajib diisi.',
            'left_logo.required' => 'Kolom Logo Kiri wajib diisi.',
            'right_logo.required' => 'Kolom Logo Kanan wajib diisi.',
            'left_logo.image' => 'Kolom Logo Kiri harus berupa file gambar.',
            'right_logo.image' => 'Kolom Logo Kanan harus berupa file gambar.',
            'left_logo.max' => 'Ukuran file Logo Kiri terlalu besar. Maksimal 2MB.',
            'right_logo.max' => 'Ukuran file Logo Kanan terlalu besar. Maksimal 2MB.',
        ];
    }
}
