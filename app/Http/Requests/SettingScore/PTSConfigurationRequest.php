<?php

namespace App\Http\Requests\SettingScore;

use Illuminate\Foundation\Http\FormRequest;

class PTSConfigurationRequest extends FormRequest
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
            'id_school_year.*' => 'required|exists:school_years,id',
            'average_daily_rate.*' => 'required|integer|min:0|max:100',
            'score_uts.*' => 'required|integer|min:0|max:100',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            $averageDailyRates = $this->input('average_daily_rate');
            $scoreUts = $this->input('score_uts');

            foreach ($averageDailyRates as $key => $rate) {
                $total = intval($rate) + intval($scoreUts[$key]);

                if ($total !== 100) {
                    $validator->errors()->add("average_daily_rate_total.$key", 'Total Nilai Harus 100');
                }
            }
        });
    }
}
