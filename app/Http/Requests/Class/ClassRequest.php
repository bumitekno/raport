<?php

namespace App\Http\Requests\Class;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class ClassRequest extends FormRequest
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
        // dd($this->all());
        return [
            'name' => 'required',
            'id_major' => 'required|exists:majors',
            'id_level' => 'required|exists:levels',
            'slug' => 'required|string'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama harus diisi!',
            'id_major.required' => 'Jurusan harus diisi!',
            'id_level.required' => 'Tingkat harus diisi!',
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
