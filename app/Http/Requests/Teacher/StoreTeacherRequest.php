<?php

namespace App\Http\Requests\Teacher;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreTeacherRequest extends FormRequest
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
            'email' => ['required', 'unique:teachers,email,' . optional($this->teacher)->id,],
            'name' => ['required'],
            'phone' => 'required|numeric',
            'password' => (empty($this->teacher->password)) ? ['required', Password::defaults(), 'required_with:password_confirmation', 'same:password_confirmation'] : '',
            'password_confirmation' => ['min:8'],
            'slug' => 'required|string',
            'file'  => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2048',
            ],

        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!'
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
