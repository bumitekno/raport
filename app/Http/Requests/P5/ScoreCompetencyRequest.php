<?php

namespace App\Http\Requests\P5;

use Illuminate\Foundation\Http\FormRequest;

class ScoreCompetencyRequest extends FormRequest
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
        $rules = [
            'count_each.*' => 'required',
        ];

        foreach ($this->input('count_each') as $index => $count) {
            $rules['competency_achieved_' . ($index + 1)] = 'array|nullable';
            $rules['competency_improved_' . ($index + 1)] = 'array|nullable';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'count_each.*.required' => 'Count each is required',
            'competency_achieved_*.array' => 'Competency achieved must be an array',
            'competency_improved_*.array' => 'Competency improved must be an array',
        ];
    }
}
