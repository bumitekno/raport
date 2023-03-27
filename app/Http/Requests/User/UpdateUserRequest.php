<?php

namespace App\Http\Requests\User;

use App\Helpers\Helper;
use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $user = User::where('slug', $this->users)->firstOrFail();
        return [
            'day' => ['required'],
            'month' => ['required'],
            'year' => ['required'],
            'date_of_birth' => 'required|date',
            'email' => ['sometimes', 'required','email:rfc,dns', ($user->email === $this->email) ? '' : 'unique:users,email', 'max:255'],
            'name' => ['required'],
            'phone' => 'required|numeric',
            'slug' => 'required|string',
            'entry_year' => 'digits:4|integer|min:1900|max:' . (date('Y') + 1),
            'file'  => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2048',
            ],
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

    protected function getValidatorInstance()
    {
        $data = $this->all();
        // dd($this->rules('email'));
        // $data['slug'] = str_slug($data['name']);
        $data['slug'] = str_slug($data['name']) . '-' . Helper::code_slug($this->users);
        $data['date_of_birth'] = $this->year . '-' . $this->month . '-' . $this->day;
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
