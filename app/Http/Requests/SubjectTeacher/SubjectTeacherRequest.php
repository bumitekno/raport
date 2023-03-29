<?php

namespace App\Http\Requests\SubjectTeacher;

use Illuminate\Foundation\Http\FormRequest;

class SubjectTeacherRequest extends FormRequest
{

    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'id_school_year' => 'required',
            'id_class' => 'required|array',
            'id_class.*' => 'required',
            'id_course' => 'required',
            'id_teacher' => 'required',
            'status' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'id_school_year.required' => 'Kolom tahun ajaran wajib diisi.',
            'id_class.required' => 'Kolom kelas wajib diisi.',
            'id_teacher.required' => 'Kolom guru wajib diisi.',
        ];
    }
}
