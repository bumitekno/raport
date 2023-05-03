<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ProfileRequest extends FormRequest
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
            'file' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'gender' => 'required|in:male,female',
            'place_of_birth' => 'required',
            'address' => 'required',
            'password' => 'nullable|confirmed|min:8',
            'day' => 'required|numeric|min:1|max:31',
            'month' => [
                'required',
                'numeric',
                Rule::in(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']),
            ],
            'year' => 'required|numeric|digits:4',
        ];

        if (Auth::guard('admin')->check()) {
            $rules['phone'] = 'required|regex:/^\+\d{10,14}$/|unique:admins,phone,' . Auth::guard('admin')->id();
            $rules['email'] = 'required|email|unique:admins,email,' . Auth::guard('admin')->id();
        }

        return $rules;
    }
}
