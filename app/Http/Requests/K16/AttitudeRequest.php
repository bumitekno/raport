<?php

namespace App\Http\Requests\K16;

use Illuminate\Foundation\Http\FormRequest;

class AttitudeRequest extends FormRequest
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
            'type' => 'required|string',
            'name.*' => 'required|string',
            'deleted_id.*' => 'nullable|integer',
        ];
    }
}
