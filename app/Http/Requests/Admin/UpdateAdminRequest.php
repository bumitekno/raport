<?php

namespace App\Http\Requests\Admin;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
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
            'email' => 'required|email',
            'name' => 'required',
            'phone' => 'required|numeric',
            'gender' => 'required',
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
        $data['slug'] = str_slug($data['name']).'-'. Helper::str_random(5);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
