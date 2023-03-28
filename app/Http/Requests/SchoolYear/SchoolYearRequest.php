<?php

namespace App\Http\Requests\SchoolYear;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class SchoolYearRequest extends FormRequest
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
        return [
            'year1' => ['required'],
            'year2' => ['required'],
            'semester' => ['required'],
            'name' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
        ];
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $school_year = $this->year1 . '/' . $this->year2 . $this->semester;
        $data['name'] = $school_year;
        $data['slug'] = str_slug($school_year) . '-' . Helper::str_random(5);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
