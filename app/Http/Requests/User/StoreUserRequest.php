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
            'date_of_birth' => 'required|date',
            'email' => ['required', 'unique:users,email,' . optional($this->user)->id,],
            'phone' => 'required|numeric',
            'name' => 'required|string',
            'gender' => 'required|in:male,female',
            'nis' => 'required|string',
            'nisn' => 'required|string',
            'religion' => 'required|string',
            'place_of_birth' => 'required|string',
            'entry_year' => 'required|date_format:Y',
            'address' => 'required|string',
            'password' => (empty($this->user->password)) ? ['required', Password::defaults(), 'required_with:password_confirmation', 'same:password_confirmation'] : '',
            // 'password_confirmation' => ['min:8'],
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
        $data['slug'] = str_slug($data['name']) . '-' . Helper::str_random(5);
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
