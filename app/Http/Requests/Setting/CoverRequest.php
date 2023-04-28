<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class CoverRequest extends FormRequest
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
            'title' => 'nullable|string',
            'sub_title' => 'nullable|string',
            'instructions' => 'nullable',
            'footer' => 'nullable|string',
            // 'id_school_year' => 'required',
            'left_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
            'right_logo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
        ];
    }
}
