<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreAdminRequest extends FormRequest
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
        // dd('rules');
        return [
            'email' => ['required', 'unique:admins,email,' . optional($this->admin)->id,],
            'name' => ['required'],
            'password' => (empty($this->admin->password)) ? ['required', Password::defaults(), 'required_with:password_confirmation', 'same:password_confirmation'] : '',
            'password_confirmation' => ['min:8']
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

    public function response(array $errors)
    {
        // dd($errors);
        return parent::response($errors);
    }
}
