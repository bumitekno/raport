<?php

namespace App\Http\Requests\StudentClass;

use Illuminate\Foundation\Http\FormRequest;

class StudentActionRequest extends FormRequest
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
            'action' => ['required', 'string', 'in:move,delete,alumni'],
            'selected_siswa' => ['required', 'string'],
            'data_origin' => ['required', 'string'],
            'id_study_class' => ['required_if:action,move', 'integer', 'exists:study_classes,id'],
            'year' => ['required_if:action,move', 'string', 'regex:/^\d{4}\/\d{4}$/'],
        ];
    }

    public function messages()
    {
        return [
            'action.required' => 'Aksi harus diisi.',
            'action.string' => 'Aksi harus berupa string.',
            'action.in' => 'Aksi tidak valid.',
            'selected_siswa.required' => 'Siswa yang dipilih harus diisi.',
            'selected_siswa.string' => 'Siswa yang dipilih harus berupa string.',
            'data_origin.required' => 'Asal data harus diisi.',
            'data_origin.string' => 'Asal data harus berupa string.',
            'id_study_class.required_if' => 'Kelas tujuan harus diisi.',
            'id_study_class.integer' => 'Kelas tujuan harus berupa angka.',
            'id_study_class.exists' => 'Kelas tujuan tidak ditemukan.',
            'year.required_if' => 'Tahun ajaran harus diisi.',
            'year.string' => 'Tahun ajaran harus berupa string.',
            'year.regex' => 'Tahun ajaran tidak valid.'
        ];
    }
}
