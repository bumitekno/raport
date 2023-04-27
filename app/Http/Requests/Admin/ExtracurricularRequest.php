<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ExtracurricularRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => 'required|string|max:255',
            'person_responsible' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.string' => 'Nama harus berupa string.',
            'name.max' => 'Nama maksimal 255 karakter.',
            'person_responsible.required' => 'Penanggung jawab wajib diisi.',
            'person_responsible.string' => 'Penanggung jawab harus berupa string.',
            'person_responsible.max' => 'Penanggung jawab maksimal 255 karakter.',
        ];
    }
}
