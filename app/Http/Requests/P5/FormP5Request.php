<?php

namespace App\Http\Requests\P5;

use Illuminate\Foundation\Http\FormRequest;

class FormP5Request extends FormRequest
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
            'id_tema' => 'required|integer',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'id_teacher' => 'required|integer',
            'id_study_class' => 'required|integer',
            'sub_element' => 'required|array',
            'sub_element.*' => 'required|string',
        ];
    }
}
