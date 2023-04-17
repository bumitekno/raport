<?php

namespace App\Http\Requests\HomeRoom;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class TeacherNoteRequest extends FormRequest
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
            'id_student_class.*' => 'required',
            'promotion.*' => 'required|in:Y,N',
            'description.*' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id_student_class.*.required' => 'Kelas siswa harus diisi.',
            'promotion.*.required' => 'Status naik kelas harus diisi.',
            'promotion.*.in' => 'Status naik kelas harus Y atau N.',
            'description.*.required' => 'Deskripsi siswa harus diisi.',
            'description.*.string' => 'Deskripsi siswa harus berupa teks.',
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
