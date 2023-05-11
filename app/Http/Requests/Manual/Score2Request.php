<?php

namespace App\Http\Requests\Manual;

use Illuminate\Foundation\Http\FormRequest;

class Score2Request extends FormRequest
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
            'final_assegment.*' => ['required', 'numeric'],
            'final_skill.*' => ['required', 'numeric'],
            'kkm.*' => ['required', 'numeric'],
            'predicate_skill.*' => ['required', 'string', 'max:1'],
            'predicate_assegment.*' => ['required', 'string', 'max:1'],
            'id_student_class.*' => ['required', 'numeric'],
        ];
    }

    public function messages()
    {
        return [
            'final_assegment.*.required' => 'Final assesgment is required.',
            'final_assegment.*.numeric' => 'Final assesgment must be a number.',
            'final_skill.*.required' => 'Final skill is required.',
            'final_skill.*.numeric' => 'Final skill must be a number.',
            'kkm.*.required' => 'KKM is required.',
            'kkm.*.numeric' => 'KKM must be a number.',
            'predicate_skill.*.required' => 'Predicate skill is required.',
            'predicate_skill.*.string' => 'Predicate skill must be a string.',
            'predicate_skill.*.max' => 'Predicate skill may not be greater than :max characters.',
            'predicate_assegment.*.required' => 'Predicate assesgment is required.',
            'predicate_assegment.*.string' => 'Predicate assesgment must be a string.',
            'predicate_assegment.*.max' => 'Predicate assesgment may not be greater than :max characters.',
            'id_student_class.*.required' => 'Student class ID is required.',
            'id_student_class.*.numeric' => 'Student class ID must be a number.',
        ];
    }
}
