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

    public function rules()
    {
        $rules = [
            'id_teacher.*' => 'required|integer',
            'id_course.*' => 'required|integer',
            'id_study_class.*' => 'required|integer',
            'formative_weight.*' => 'required|integer|between:0,100',
            'sumative_weight.*' => 'required|integer|between:0,100',
            'uts_weight.*' => 'required_if:type,uts|integer|between:0,100',
            'uas_weight.*' => 'required_if:type,uas|integer|between:0,100',
            'total_weight.*' => 'required|in:100',
            'type' => 'required|in:uts,uas',
        ];

        $messages = [
            'required' => 'Field :attribute wajib diisi.',
            'integer' => 'Field :attribute harus berupa angka.',
            'between' => 'Field :attribute harus berada di antara :min dan :max.',
            'in' => 'Jumlah bobot pada :attribute harus sama dengan 100.'
        ];

        return $rules;
    }

    public function withValidator($validator)
    {
        $type = $this->input('type');
        $totalWeight = $this->input('formative_weight') + $this->input('sumative_weight');

        if ($type == 'uts') {
            $totalWeight += $this->input('uts_weight');
        } elseif ($type == 'uas') {
            $totalWeight += $this->input('uas_weight');
        }

        if ($totalWeight !== 100) {
            $validator->errors()->add('total_weight', 'Total bobot harus sama dengan 100.');
        }
    }
}
