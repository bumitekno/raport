<?php

namespace App\Http\Requests\Score;

use Illuminate\Foundation\Http\FormRequest;

class P5Request extends FormRequest
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
            'id_student_class' => 'required|exists:student_classes,id',
            'id_school_year' => 'required|exists:school_years,id',
            'id_subject_teacher' => 'required|exists:subject_teachers,id',
            'description' => 'required',
            'sub_element.*' => 'required|in:belum,mulai,berkembang,sangat',
        ];
    }
}
