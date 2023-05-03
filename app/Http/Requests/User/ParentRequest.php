<?php

namespace App\Http\Requests\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class ParentRequest extends FormRequest
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
        $rules = [
            'name' => 'required',
            'id_user' => 'required',
            'email' => [
                'required',
                'email',
                Rule::unique('parents')->ignore($this->id),
            ],
            'type' => 'required',
        ];

        // Only require password if creating new parent
        if (!$this->id) {
            $rules['password'] = 'required';
        }

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'Name field is required.',
            'email.required' => 'Email field is required.',
            'id_user.required' => 'User field is required.',
            'email.email' => 'Email field must be a valid email address.',
            'email.unique' => 'Email field is already taken.',
            'type.required' => 'Type field is required.',
            'type.in' => 'Type field must be one of: father, mother, guardian, other.',
            'password.required' => 'Password field is required.',
            'password.min' => 'Password field must be at least 8 characters long.',
        ];
    }
}
