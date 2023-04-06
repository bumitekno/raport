<?php

namespace App\Http\Requests\P5;

use Illuminate\Foundation\Http\FormRequest;

class AssesementRequest extends FormRequest
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
            'id_teacher' => 'required|array',
            'id_course' => 'required|array',
            'id_study_class' => 'required|array',
            'formative_weight' => 'required|array',
            'sumative_weight' => 'required|array',
            'id_teacher.*' => 'required|integer',
            'id_course.*' => 'required|integer',
            'id_study_class.*' => 'required|integer',
            'formative_weight.*' => 'required|integer',
            'sumative_weight.*' => 'required|integer',
        ];
    }
}
