<?php

namespace App\Http\Requests\Manual;

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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'id_student_class.*' => 'required|exists:student_classes,id',
            'assigment_grade.*' => 'required|numeric|min:0|max:100',
            'daily_test_score.*' => 'required|numeric|min:0|max:100',
            'score_uts.*' => 'required|numeric|min:0|max:100',
            'score_uas.*' => 'required|numeric|min:0|max:100',
            'description.*' => 'nullable|string|max:255',
            'type' => 'required|in:uts,uas',
            'uas' => [
                'sometimes',
                'required_if:type,uas',
                'integer',
            ],
        ];
    }

    public function messages()
    {
        return [
            'id_student_class.*.required' => 'ID kelas siswa tidak boleh kosong',
            'id_student_class.*.exists' => 'ID kelas siswa tidak ditemukan',
            'assigment_grade.*.required' => 'Nilai tugas tidak boleh kosong',
            'assigment_grade.*.numeric' => 'Nilai tugas harus berupa angka',
            'assigment_grade.*.min' => 'Nilai tugas tidak boleh kurang dari :min',
            'assigment_grade.*.max' => 'Nilai tugas tidak boleh lebih dari :max',
            'daily_test_score.*.required' => 'Nilai ulangan harian tidak boleh kosong',
            'daily_test_score.*.numeric' => 'Nilai ulangan harian harus berupa angka',
            'daily_test_score.*.min' => 'Nilai ulangan harian tidak boleh kurang dari :min',
            'daily_test_score.*.max' => 'Nilai ulangan harian tidak boleh lebih dari :max',
            'score_uts.*.required' => 'Nilai UTS tidak boleh kosong',
            'score_uts.*.numeric' => 'Nilai UTS harus berupa angka',
            'score_uts.*.min' => 'Nilai UTS tidak boleh kurang dari :min',
            'score_uts.*.max' => 'Nilai UTS tidak boleh lebih dari :max',
            'score_uas.*.required' => 'Nilai UAS tidak boleh kosong',
            'score_uas.*.numeric' => 'Nilai UAS harus berupa angka',
            'score_uas.*.min' => 'Nilai UAS tidak boleh kurang dari :min',
            'score_uas.*.max' => 'Nilai UAS tidak boleh lebih dari :max',
            'description.*.max' => 'Deskripsi tidak boleh lebih dari :max karakter',
        ];
    }
}
