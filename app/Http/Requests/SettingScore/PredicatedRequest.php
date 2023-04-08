<?php

namespace App\Http\Requests\SettingScore;

use App\Helpers\Helper;
use Illuminate\Foundation\Http\FormRequest;

class PredicatedRequest extends FormRequest
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
            'name' => 'required|string',
            'score.*' => 'required|integer|min:0|max:100',
            'grade_weight' => 'required|integer',
            'description' => 'nullable|string',
            'slug' => 'required|string',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $score = $this->input('score');

            if (count($score) > 0) {
                $minScore = min($score);
                $maxScore = max($score);
                $this->merge([
                    'score' => $minScore . '-' . $maxScore
                ]);
            }
        });
    }

    protected function getValidatorInstance()
    {
        $data = $this->all();
        $data['slug'] = str_slug($data['name']) . '-' . Helper::str_random(5);
        $this->getInputSource()->replace($data);

        return parent::getValidatorInstance();
    }
}
