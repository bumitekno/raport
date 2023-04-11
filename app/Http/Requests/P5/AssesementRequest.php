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
        $rules = [
            'id_teacher.*' => 'required|integer',
            'id_course.*' => 'required|integer',
            'id_study_class.*' => 'required|integer',
            'formative_weight.*' => 'required|integer|between:0,100',
            'sumative_weight.*' => 'required|integer|between:0,100',
            'uts_weight.*' => 'required|integer|between:0,100',
            'uas_weight.*' => 'required|integer|between:0,100',
            'total_weight.*' => 'required|in:100',
        ];

        $messages = [
            'required' => 'Field :attribute wajib diisi.',
            'integer' => 'Field :attribute harus berupa angka.',
            'between' => 'Field :attribute harus berada di antara :min dan :max.',
            'in' => 'Jumlah bobot pada :attribute harus sama dengan 100.'
        ];

        $this->merge([
            'total_weight' => array_map(function ($formative, $sumative, $uts, $uas) {
                return $formative + $sumative + $uts + $uas;
            }, $this->formative_weight, $this->sumative_weight, $this->uts_weight, $this->uas_weight),
        ]);

        $rules['total_weight.*'] = 'required|in:100';

        return $rules;
    }
}
