<?php

namespace App\Http\Requests\P5;

use Illuminate\Foundation\Http\FormRequest;

class ScoreRequest extends FormRequest
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
            'average_formative' => 'required|numeric',
            'average_summative' => 'required|numeric',
            'final_score' => 'required|numeric',
            'slug_student_class' => 'required|string',
            'id_course' => 'required|integer',
            'id_study_class' => 'required|integer',
            'id_teacher' => 'required|integer',
            'id_school_year' => 'required|integer',
            'formative' => 'required|array',
            'formative.*' => 'required|numeric',
            'sumatif' => 'required|array',
            'sumatif.*' => 'required|numeric',
            'uts' => 'required|numeric',
            'uas' => 'required|numeric',
        ];
    }

}
