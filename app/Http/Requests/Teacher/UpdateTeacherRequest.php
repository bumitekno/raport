<?php

namespace App\Http\Requests\Teacher;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTeacherRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required|numeric',
            'gender' => 'required',
            'type' => 'required',
            'id_class' => 'nullable',
            'address' => 'sometimes',
            'place_of_birth' => 'sometimes',
            'date_of_birth' => 'date_format:Y-m-d|before:today',
            'file' => 'sometimes | mimes:jpeg,jpg,png | max:5000',
            'slug' => 'required|string',
            'password' => 'nullable',
            'password_confirmation' => 'same:password'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
        ];
    }

    public function response(array $errors)
    {
        // dd($errors);
        return parent::response($errors);
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = str_slug($data['name']) . '-' . Helper::str_random(5);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
