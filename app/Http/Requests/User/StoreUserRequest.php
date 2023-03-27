<?php

namespace App\Http\Requests\User;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class StoreUserRequest extends FormRequest
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
        // dd($this->request);
        return [
            'day' => ['required'],
            'month' => ['required'],
            'year' => ['required'],
            'date_of_birth' => 'required|date',
            'email' => ['required', 'unique:users,email,' . optional($this->user)->id,],
            'name' => ['required'],
            'phone' => 'required|numeric',
            'password' => (empty($this->user->password)) ? ['required', Password::defaults(), 'required_with:password_confirmation', 'same:password_confirmation'] : '',
            'password_confirmation' => ['min:8'],
            'slug' => 'required|string',
            'entry_year' => 'digits:4|integer|min:1900|max:' . (date('Y') + 1),
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
        $data['date_of_birth'] = $this->year . '-' . $this->month . '-' . $this->day;
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
