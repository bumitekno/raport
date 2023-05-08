<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class ConfigRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'pts_date' => 'nullable|date|date_format:Y-m-d',
            'last_pts_date' => 'nullable|date|date_format:Y-m-d',
            'report_date' => 'nullable|date|date_format:Y-m-d',
            'final_report_date' => 'nullable|date|date_format:Y-m-d',
            'closing_date' => 'nullable|date|date_format:Y-m-d',
            'headmaster' => 'required|string',
            'id_school_year' => 'required',
            'nip_headmaster' => 'required',
            'signature' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi gambar
            'place' => 'nullable',
        ];
    }
}
