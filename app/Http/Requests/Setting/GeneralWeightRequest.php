<?php

namespace App\Http\Requests\Setting;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class GeneralWeightRequest extends FormRequest
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
        $scoreWeight = $this->input('score_weight');
        $utsWeight = $this->input('uts_weight');
        $uasWeight = $this->input('uas_weight');

        if ($this->type == 'uts') {
            $totalWeight = $scoreWeight[0] + $utsWeight[0];
        } else if ($this->type == 'uas') {
            $totalWeight = $scoreWeight[0] + $utsWeight[0] + $uasWeight[0];
        }

        $rules = [
            'id_teacher' => 'required|array|min:1',
            'id_teacher.*' => 'required|numeric|exists:teachers,id',
            'id_course' => 'required|array|min:1',
            'id_course.*' => 'required|numeric|exists:courses,id',
            'id_study_class' => 'required|array|min:1',
            'id_study_class.*' => 'required|numeric|exists:study_classes,id',
            'type' => 'required|string|in:uts,uas',
            'score_weight' => 'required|array|min:1',
            'score_weight.*' => 'required|numeric|min:0',
            'uts_weight' => 'required_if:type,uts|array|min:1',
            'uts_weight.*' => 'required_if:type,uts|numeric|min:0',
            'uas_weight' => 'required_if:type,uas|array|min:1',
            'uas_weight.*' => 'required_if:type,uas|numeric|min:0',
        ];

        if ($totalWeight !== 100) {
            if ($this->type == 'uts') {
                $rules['score_weight.*'] .= '|max:' . (100 - $utsWeight[0]);
                $rules['uts_weight.*'] .= '|max:' . (100 - $scoreWeight[0]);
            } else if ($this->type == 'uas') {
                $rules['score_weight.*'] .= '|max:' . (100 - $uasWeight[0]);
                $rules['uts_weight.*'] .= '|max:' . (100 - $scoreWeight[0]);
                $rules['uas_weight.*'] .= '|max:' . (100 - $scoreWeight[0]);
            }
            $rules['sum_weight'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'score_weight.required' => 'Bobot nilai harus diisi',
            'uts_weight.required_if' => 'Bobot nilai harus diisi',
            'uas_weight.required_if' => 'Bobot nilai harus diisi',
            'score_weight.numeric' => 'Bobot nilai harus angka',
            'uts_weight.numeric' => 'Bobot nilai harus angka',
            'uas_weight.numeric' => 'Bobot nilai harus angka',
            'score_weight.min' => 'Bobot nilai minimal 0',
            'uts_weight.min' => 'Bobot nilai minimal 0',
            'uas_weight.min' => 'Bobot nilai minimal 0',
            'score_weight.max' => 'Bobot nilai maksimal 100',
            'uts_weight.max' => 'Bobot nilai maksimal 100',
            'uas_weight.max' => 'Bobot nilai maksimal 100',
            'sum_weight.required' => 'Total bobot nilai harus 100',
            'sum_weight_uts' => 'Total bobot nilai harus 100 untuk tipe UTS',
            'sum_weight_uas' => 'Total bobot nilai harus 100 untuk tipe UAS',
        ];
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'message' => 'The given data is invalid',
    //         'errors' => $validator->errors(),
    //     ], 422));
    // }
}
