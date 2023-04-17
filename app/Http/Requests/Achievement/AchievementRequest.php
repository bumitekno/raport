<?php

namespace App\Http\Requests\Achievement;

use Illuminate\Foundation\Http\FormRequest;

class AchievementRequest extends FormRequest
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
            'id_student_class' => 'required|numeric',
            'ranking' => 'required|string',
            'name' => 'required|string|max:255',
            'level' => 'required|string|max:255',
            'description' => 'nullable|string',
        ];
    }

    public function messages()
    {
        return [
            'id_student_class.required' => 'Kelas siswa harus diisi.',
            'id_student_class.numeric' => 'Kelas siswa harus berupa angka.',
            'ranking.required' => 'Peringkat harus diisi.',
            'ranking.numeric' => 'Peringkat harus berupa angka.',
            'name.required' => 'Nama kejuaraan harus diisi.',
            'name.string' => 'Nama kejuaraan harus berupa teks.',
            'name.max' => 'Nama kejuaraan maksimal :max karakter.',
            'level.required' => 'Tingkat kejuaraan harus diisi.',
            'level.string' => 'Tingkat kejuaraan harus berupa teks.',
            'level.max' => 'Tingkat kejuaraan maksimal :max karakter.',
            'description.string' => 'Deskripsi harus berupa teks.',
        ];
    }
}
