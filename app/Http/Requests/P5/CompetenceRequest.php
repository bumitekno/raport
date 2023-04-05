<?php

namespace App\Http\Requests\P5;

use Illuminate\Foundation\Http\FormRequest;

class CompetenceRequest extends FormRequest
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
            'id_course' => 'required|numeric',
            'id_study_class' => 'required|numeric',
            'id_teacher' => 'required|numeric',
            'id_type_competence' => 'required|numeric',
            'code' => 'required|string|max:255',
            'achievement' => 'required|string|max:255',
            'description' => 'required|string|max:255',
        ];
    }
}
