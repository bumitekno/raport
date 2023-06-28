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
            'id_competency' => 'required|array',
            'id_competency.*' => 'required|numeric',
            'sumatif' => 'required|array',
            'sumatif.*' => 'required|numeric',
            'uts' => 'required|numeric',
            'type' => 'required|in:uts,uas',
            'uas' => [
                'sometimes',
                'required_if:type,uas',
                'integer',
            ],
        ];
    }

    public function validated($key = null, $default = null)
    {
        $validatedData = parent::validated();

        $formative = $validatedData['formative'];
        $idCompetency = $validatedData['id_competency'];

        $formativeData = [];
        foreach ($formative as $key => $score) {
            $id = $idCompetency[$key];
            $formativeData[] = [
                'id_competency' => $id,
                'score' => $score,
            ];
        }

        $validatedData['formative'] = json_encode($formativeData);
        $validatedData['sumatif'] = json_encode($validatedData['sumatif']);

        return $validatedData;
    }
}
