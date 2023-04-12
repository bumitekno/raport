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

    public function rules()
    {
        return [
            'average_formative' => 'required|numeric',
            'average_summative' => 'required|numeric',
            'final_score' => 'required|numeric',
            'id_student_class' => 'required|integer',
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

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        // Convert formative and sumatif input to JSON
        $validatedData['formative'] = json_encode($validatedData['formative']);
        $validatedData['sumatif'] = json_encode($validatedData['sumatif']);

        return $validatedData;
    }
}
