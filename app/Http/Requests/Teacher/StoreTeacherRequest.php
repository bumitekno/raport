<?php

namespace App\Http\Requests\Teacher;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
// use Illuminate\Validation\Rules\Password;
// use Illuminate\Contracts\Validation\Validator;
// use Illuminate\Http\Exceptions\HttpResponseException;

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
            'status' => 'required|in:0,1',
            'name' => 'required|string|max:255',
            'nik' => 'nullable|string|max:255',
            'nuptk' => 'nullable|string|max:255',
            'nip' => 'nullable|string|max:255',
            'email' => 'required|email|unique:teachers,email',
            'phone' => 'nullable|string|max:255',
            'address' => 'nullable|string|max:255',
            'place_of_birth' => 'nullable|string|max:255',
            'date_of_birth' => 'nullable|date_format:Y-m-d',
            'gender' => 'required|in:male,female',
            'id_class' => 'nullable',
            'religion' => 'nullable|string|max:255',
            'type' => 'required|in:teacher,other,homeroom',
            'password' => 'required|string|min:8|confirmed',
            'file' => 'nullable|image|max:1024',
            'slug' => 'required|string|unique:teachers,slug'
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'Email is required!',
            'name.required' => 'Name is required!',
            'password.required' => 'Password is required!',
            'slug.required' => 'Slug is required!'
        ];
    }

    public function prepareForValidation()
    {
        $slug = str_slug($this->name) . '-' . Helper::str_random(5);
        $this->merge([
            'slug' => $slug
        ]);
    }

    // protected function failedValidation(Validator $validator)
    // {
    //     throw new HttpResponseException(response()->json([
    //         'message' => 'The given data is invalid',
    //         'errors' => $validator->errors(),
    //     ], 422));
    // }
}
