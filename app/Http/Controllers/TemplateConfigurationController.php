<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Setting\TemplateRequest;
use App\Models\Major;
use App\Models\SchoolYear;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;

class TemplateConfigurationController extends Controller
{
    public function index()
    {
        session()->put('title', 'Tampilan Raport');
        $school_years = SchoolYear::all();
        $school_year = SchoolYear::where('slug', $_GET['year'])->first();
        $majors = Major::all();
        $templates = [];
        foreach ($majors as $major) {
            $found = TemplateConfiguration::where([
                ['id_school_year', $school_year->id],
                ['id_major', $major->id]
            ])->first();
            $templates[] = [
                'major' => $major->name,
                'id_school_year' => $school_year->id,
                'id_major' => $major->id,
                'type' => optional($found)->type,
                'template' => optional($found)->template,
            ];
        }
        return view('content.setting.v_template', compact('school_years', 'templates'));
    }

    public function updateOrCreate(TemplateRequest $request)
    {
        $data = $request->validated();

        foreach ($data['id_school_year'] as $index => $idSchoolYear) {
            if (isset($data['type'][$index]) && isset($data['template'][$index])) {
                TemplateConfiguration::updateOrCreate(
                    [
                        'id_school_year' => $idSchoolYear,
                        'id_major' => $data['id_major'][$index],
                    ],
                    [
                        'type' => $data['type'][$index],
                        'template' => $data['template'][$index],
                    ]
                );
                Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
            }
        }
        return redirect()->back();
    }
}
