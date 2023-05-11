<?php

namespace App\Http\Requests\K16;

use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Http\Exceptions\HttpResponseException;

class ScoreKdRequest extends FormRequest
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
            'id_school_year' => 'required|integer',
            'id_student_class' => 'required|integer',
            'id_subject_teacher' => 'required|integer',
            'id_study_class' => 'required|integer',
            'average_assesment' => 'required|numeric',
            'average_skill' => 'required|numeric',
            'final_assesment' => 'required|numeric',
            'final_skill' => 'required|numeric',
            'id_kd_assesment.*' => 'required|integer',
            'nilai_pengetahuan.*' => 'required|integer',
            'id_kd_skill.*' => 'required|integer',
            'nilai_ketrampilan.*' => 'required|integer',
            'uts' => 'required|integer',
            'type' => 'required|in:uts,uas',
            'uas' => [
                'sometimes',
                'required_if:type,uas',
                'integer',
            ],
        ];
    }

    public function transformedData()
    {
        $validated = $this->validated();

        $kd_assesment = array_map(function ($id, $score) {
            return ['id_kd' => $id, 'score' => $score];
        }, $validated['id_kd_assesment'], $validated['nilai_pengetahuan']);

        $kd_skill = array_map(function ($id, $score) {
            return ['id_kd' => $id, 'score' => $score];
        }, $validated['id_kd_skill'], $validated['nilai_ketrampilan']);

        // Ubah array menjadi JSON
        $validated['assesment_score'] = json_encode($kd_assesment);
        $validated['skill_score'] = json_encode($kd_skill);

        unset($validated['id_kd_assesment'], $validated['nilai_pengetahuan'], $validated['id_kd_skill'], $validated['nilai_ketrampilan']);

        return $validated;
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'message' => 'The given data is invalid',
    //         'errors' => $validator->errors(),
    //     ], 422));
    // }
}
