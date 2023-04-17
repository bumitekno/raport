<?php

namespace App\Http\Requests\Attendances;

use Illuminate\Foundation\Http\FormRequest;

class AttendanceRequest extends FormRequest
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
            'id_student_class.*' => 'required',
            'ill.*' => 'required|integer|min:0',
            'excused.*' => 'required|integer|min:0',
            'unexcused.*' => 'required|integer|min:0',
        ];
    }

    public function messages()
    {
        return [
            'id_student_class.*.required' => 'Kelas siswa harus diisi.',
            'ill.*.required' => 'Jumlah sakit harus diisi.',
            'ill.*.integer' => 'Jumlah sakit harus berupa bilangan bulat.',
            'ill.*.min' => 'Jumlah sakit tidak boleh kurang dari 0.',
            'excused.*.required' => 'Jumlah izin harus diisi.',
            'excused.*.integer' => 'Jumlah izin harus berupa bilangan bulat.',
            'excused.*.min' => 'Jumlah izin tidak boleh kurang dari 0.',
            'unexcused.*.required' => 'Jumlah tidak izin harus diisi.',
            'unexcused.*.integer' => 'Jumlah tidak izin harus berupa bilangan bulat.',
            'unexcused.*.min' => 'Jumlah tidak izin tidak boleh kurang dari 0.',
        ];
    }
}
