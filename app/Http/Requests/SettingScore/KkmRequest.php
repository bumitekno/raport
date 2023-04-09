<?php

namespace App\Http\Requests\SettingScore;

use Illuminate\Foundation\Http\FormRequest;

class KkmRequest extends FormRequest
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
            'id_course' => 'required|array',
            'id_course.*' => 'required|distinct',
            'id_study_class' => 'required|array',
            'id_study_class.*' => 'required',
            'id_school_year' => 'required|array',
            'id_school_year.*' => 'required',
            'score' => 'required|array',
            'score.*' => 'required|numeric|min:0|max:100',
        ];
    }

    public function messages()
    {
        return [
            'id_study_class.required' => 'ID Kelas tidak boleh kosong',
            'id_study_class.*.required' => 'ID Kelas tidak boleh kosong',
            'id_course.required' => 'ID Pelajaran tidak boleh kosong',
            'id_course.*.required' => 'ID Pelajaran tidak boleh kosong',
            'id_course.*.distinct' => 'ID Pelajaran harus unik',
            'id_school_year.required' => 'ID Tahun Ajaran tidak boleh kosong',
            'id_school_year.*.required' => 'ID Tahun Ajaran tidak boleh kosong',
            'score.required' => 'Nilai KKM tidak boleh kosong',
            'score.*.required' => 'Nilai KKM tidak boleh kosong',
            'score.*.numeric' => 'Nilai KKM harus berupa angka',
            'score.*.min' => 'Nilai KKM tidak boleh kurang dari :min',
            'score.*.max' => 'Nilai KKM tidak boleh lebih dari :max',
        ];
    }
}
