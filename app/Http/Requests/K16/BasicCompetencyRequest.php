<?php

namespace App\Http\Requests\K16;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class BasicCompetencyRequest extends FormRequest
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
            'id_course' => 'required|numeric',
            'id_level' => 'required|numeric',
            'code' => 'required|string',
            'name' => 'required|string',
            'slug' => 'required|string',
        ];
    }

    public function messages()
    {
        return [
            'id_course.required' => 'Kolom mata pelajaran harus diisi.',
            'id_course.numeric' => 'Kolom mata pelajaran harus berupa angka.',
            'id_level.required' => 'Kolom tingkat harus diisi.',
            'id_level.numeric' => 'Kolom tingkat harus berupa angka.',
            'code.required' => 'Kolom kode harus diisi.',
            'code.string' => 'Kolom kode harus berupa string.',
            'name.required' => 'Kolom nama harus diisi.',
            'name.string' => 'Kolom nama harus berupa string.',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = str_slug($data['name']) . '-' . Helper::str_random(5);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
