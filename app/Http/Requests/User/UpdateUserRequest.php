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
            'date_of_birth' => 'required|date',
            'email' => ['sometimes', 'required', 'email:rfc,dns', ($user->email === $this->email) ? '' : 'unique:users,email', 'max:255'],
            'phone' => 'required|numeric',
            'name' => 'required|string',
            'gender' => 'required|in:male,female',
            'nis' => 'required|string',
            'nisn' => 'required|string',
            'religion' => 'required|string',
            'place_of_birth' => 'required|string',
            'entry_year' => 'required|date_format:Y',
            'address' => 'required|string',
            'file'  => [
                'nullable',
                'image',
                'mimes:jpg,png,jpeg,gif,svg',
                'max:2048',
            ],
            'password' => 'nullable',
            'slug' => 'required|string',
            // 'password_confirmation' => 'same:password'
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Kolom nama harus diisi.',
            'email.required' => 'Kolom email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Kolom nomor telepon harus diisi.',
            'phone.numeric' => 'Kolom nomor telepon harus berupa angka.',
            'gender.required' => 'Kolom jenis kelamin harus diisi.',
            'gender.in' => 'Kolom jenis kelamin harus "male" atau "female".',
            'nis.required' => 'Kolom NIS harus diisi.',
            'nisn.required' => 'Kolom NISN harus diisi.',
            'religion.required' => 'Kolom agama harus diisi.',
            'place_of_birth.required' => 'Kolom tempat lahir harus diisi.',
            'entry_year.required' => 'Kolom tahun masuk harus diisi.',
            'entry_year.date_format' => 'Format tahun masuk tidak valid.',
            'address.required' => 'Kolom alamat harus diisi.',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        // dd($this->rules('email'));
        // $data['slug'] = str_slug($data['name']);
        $data['slug'] = str_slug($data['name']) . '-' . Helper::code_slug($this->users);
        if (isset($data['date_of_birth'])) {
            unset($data['day']);
            unset($data['month']);
            unset($data['year']);
        } else {
            $data['date_of_birth'] = $this->year . '-' . $this->month . '-' . $this->day;
        }

        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
