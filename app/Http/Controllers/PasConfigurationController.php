<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SettingScore\PASConfigurationRequest;
use App\Models\PasConfiguration;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class PasConfigurationController extends Controller
{
    public function index()
    {
        session()->put('title', 'Pengaturan Nilai PAS');
        $school_years = SchoolYear::all();
        $configurations = [];

        foreach ($school_years as  $school_year) {
            $found = PasConfiguration::where('id_school_year', $school_year->id)->first();
            $semester =  substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap';
            $configurations[] = [
                'id_school_year' => $school_year->id,
                'school_year' => substr($school_year->name, 0, 9) . ' ' . $semester,
                'average_daily_rate' => optional($found)->average_daily_rate,
                'score_uts' => optional($found)->score_uts,
                'score_uas' => optional($found)->score_uas,
            ];
        }
        return view('content.setting_scores.v_pas_configuration', compact('configurations'));
    }

    public function storeOrUpdate(PASConfigurationRequest $request)
    {
        // dd($request);
        $data = $request->validated();

        foreach ($data['id_school_year'] as $index => $idSchoolYear) {
            $ptsConfiguration = PasConfiguration::updateOrCreate(
                ['id_school_year' => $idSchoolYear],
                [
                    'average_daily_rate' => $data['average_daily_rate'][$index],
                    'score_uts' => $data['score_uts'][$index],
                    'score_uas' => $data['score_uas'][$index],
                ]
            );
            Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        }

        return redirect()->back();
    }
}
