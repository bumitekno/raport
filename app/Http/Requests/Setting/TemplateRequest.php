<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;

class TemplateRequest extends FormRequest
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
            'id_school_year.*' => 'required|integer',
            'type.*' => 'required|present|in:uas,uts',
            'id_major.*' => 'required|integer',
            'template.*' => 'required|present|in:k13,merdeka,manual,manual2',
        ];
    }

    public function messages()
    {
        return [
            'id_school_year.*.required' => 'Kolom tahun ajaran harus diisi',
            'id_school_year.*.integer' => 'Kolom tahun ajaran harus berisi angka',

            'type.*.required' => 'Kolom jenis ulangan harus diisi',
            'type.*.in' => 'Kolom jenis ulangan harus berisi uas atau uts',

            'id_major.*.required' => 'Kolom jurusan harus diisi',
            'id_major.*.integer' => 'Kolom jurusan harus berisi angka',

            'template.*.required' => 'Kolom template harus diisi',
            'template.*.in' => 'Kolom template harus berisi k13, merdeka, manual atau manual v2',
        ];
    }
}
