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
            'address' => 'required',
            'password' => 'nullable|confirmed|min:8',
        ];

        if (Auth::guard('admin')->check()) {
            $rules['phone'] = 'required|regex:/^\d{10,14}$/|unique:admins,phone,' . Auth::guard('admin')->id();
            $rules['email'] = 'required|email|unique:admins,email,' . Auth::guard('admin')->id();
            $rules['gender'] = 'required|in:male,female';
            $rules['place_of_birth'] = 'required';
            $rules['day'] = 'required|numeric|min:1|max:31';
            $rules['month'] = [
                'required',
                'numeric',
                Rule::in(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']),
            ];
            $rules['year'] = 'required|numeric|digits:4';
        }
        if (Auth::guard('teacher')->check()) {
            $rules['nip'] = 'required|string|unique:teachers,nip,' . Auth::guard('teacher')->id();
            $rules['nik'] = 'required|string|unique:teachers,nik,' . Auth::guard('teacher')->id();
            $rules['nuptk'] = 'required|string|unique:teachers,nuptk,' . Auth::guard('teacher')->id();
            $rules['religion'] = 'required|string';
            $rules['type'] = 'required|in:teacher,homeroom,other';
            $rules['id_class'] = 'nullable';
            $rules['phone'] = 'required|regex:/^\d{10,14}$/|unique:teachers,phone,' . Auth::guard('teacher')->id();
            $rules['email'] = 'required|email|unique:teachers,email,' . Auth::guard('teacher')->id();
            $rules['gender'] = 'required|in:male,female';
            $rules['place_of_birth'] = 'required';
            $rules['day'] = 'required|numeric|min:1|max:31';
            $rules['month'] = [
                'required',
                'numeric',
                Rule::in(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']),
            ];
            $rules['year'] = 'required|numeric|digits:4';
        }
        if (Auth::guard('user')->check()) {
            $rules['nis'] = 'required|string|unique:users,nis,' . Auth::guard('user')->id();
            $rules['nisn'] = 'required|string|unique:users,nisn,' . Auth::guard('user')->id();
            $rules['entry_year'] = 'required|numeric|min:1900|max:' . (date('Y'));
            $rules['religion'] = 'required|string';
            $rules['family_status'] = 'required|in:kandung,tiri';
            $rules['child_off'] = 'required|string';
            $rules['school_from'] = 'required|string';
            $rules['accepted_grade'] = 'required|numeric';
            $rules['accepted_date'] = 'required|date';
            $rules['phone'] = 'required|regex:/^\d{10,14}$/|unique:users,phone,' . Auth::guard('user')->id();
            $rules['email'] = 'required|email|unique:users,email,' . Auth::guard('user')->id();
            $rules['gender'] = 'required|in:male,female';
            $rules['place_of_birth'] = 'required';
            $rules['day'] = 'required|numeric|min:1|max:31';
            $rules['month'] = [
                'required',
                'numeric',
                Rule::in(['1', '2', '3', '4', '5', '6', '7', '8', '9', '10', '11', '12']),
            ];
            $rules['year'] = 'required|numeric|digits:4';
        }

        if (Auth::guard('parent')->check()) {
            $rules['nik'] = 'required|string|unique:parents,nik,' . Auth::guard('parent')->id();
            $rules['religion'] = 'required|string';
            $rules['type'] = 'required|in:father,mother,guardian,other';
            $rules['job'] = 'nullable';
            $rules['email'] = 'required|email|unique:parents,email,' . Auth::guard('parent')->id();
            $rules['phone'] = 'required|regex:/^\d{10,14}$/|unique:parents,phone,' . Auth::guard('parent')->id();
        }

        return $rules;
    }
}
