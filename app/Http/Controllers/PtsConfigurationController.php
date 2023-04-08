<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SettingScore\PTSConfigurationRequest;
use App\Models\PtsConfiguration;
use App\Models\SchoolYear;
use Illuminate\Http\Request;

class PtsConfigurationController extends Controller
{
    public function index()
    {
        session()->put('title', 'Pengaturan Nilai PTS');
        $school_years = SchoolYear::all();
        $configurations = [];

        foreach ($school_years as  $school_year) {
            $found = PtsConfiguration::where('id_school_year', $school_year->id)->first();
            $semester =  substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap';
            $configurations[] = [
                'id_school_year' => $school_year->id,
                'school_year' => substr($school_year->name, 0, 9) . ' ' . $semester,
                'average_daily_rate' => optional($found)->average_daily_rate,
                'score_uts' => optional($found)->score_uts,
            ];
        }
        return view('content.setting_scores.v_pts_configuration', compact('configurations'));
    }

    public function storeOrUpdate(PTSConfigurationRequest $request)
    {
        $data = $request->validated();

        foreach ($data['id_school_year'] as $index => $idSchoolYear) {
            $ptsConfiguration = PtsConfiguration::updateOrCreate(
                ['id_school_year' => $idSchoolYear],
                [
                    'average_daily_rate' => $data['average_daily_rate'][$index],
                    'score_uts' => $data['score_uts'][$index],
                ]
            );
            Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        }

        return redirect()->back();
    }
}
