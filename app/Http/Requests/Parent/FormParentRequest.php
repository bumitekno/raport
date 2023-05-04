<?php

namespace App\Http\Requests\Parent;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class FormParentRequest extends FormRequest
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
        $id = $this->route('id');
        $rules = [
            'name' => 'required',
            'nik' => 'required',
            'email' => 'required|email',
            'religion' => 'required',
            'id_user' => 'required',
            // 'id_user' => [
            //     'required',
            //     Rule::unique('parents')->where(function ($query) use ($id) {
            //         return $query->where('id', '<>', $id)->whereNotDeleted();
            //     }),
            // ],
            'type' => 'required|in:father,mother,other,guardian',
            'phone' => 'required|regex:/^\d{10,14}$/',
            'job' => 'required',
            'address' => 'required',
        ];

        if (isset($this->id)) {
            $rules['password'] = 'nullable|confirmed';
        } else {
            $rules['password'] = 'required|confirmed';
        }

        return $rules;
    }
}
