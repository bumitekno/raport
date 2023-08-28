<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Setting\TemplateRequest;
use App\Models\Major;
use App\Models\Level;
use App\Models\SchoolYear;
use App\Models\TemplateConfiguration;
use App\Models\DefaultTemplate;
use Illuminate\Http\Request;

class TemplateConfigurationController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Tampilan Raport');
        $school_years = SchoolYear::all();

        $school_year = SchoolYear::where('slug', $_GET['year'])->first();

        $defaultTemplate = DefaultTemplate::where('id_school_year', $_GET['year'])->first();

        $majors = Major::all();
        $levels = Level::all();

        $templates = [];

        if (!empty($defaultTemplate)) {

            if ($defaultTemplate->type == 'jurusan') {

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
                        'type_template_default' => $defaultTemplate->type
                    ];
                }

            } else if ($defaultTemplate->type == 'tingkatan') {
                foreach ($levels as $levels) {
                    $found = TemplateConfiguration::where([
                        ['id_school_year', $school_year->id],
                        ['id_level', $levels->id]
                    ])->first();
                    $templates[] = [
                        'level' => $levels->name,
                        'id_school_year' => $school_year->id,
                        'id_level' => $levels->id,
                        'type' => optional($found)->type,
                        'template' => optional($found)->template,
                        'type_template_default' => $defaultTemplate->type
                    ];
                }
            }

        }

        return view('content.setting.v_template', compact('school_years', 'templates', 'levels', 'defaultTemplate'));
    }

    public function defaultsave(Request $request)
    {

        $request->validate([
            'template_type' => 'required',
            'id_school_year_' => 'required',
        ]);

        DefaultTemplate::updateOrCreate([
            'id_school_year' => $request->id_school_year_
        ], [
            'type' => $request->template_type
        ]);

        return redirect()->back();

    }

    public function updateOrCreate(Request $request)
    {

        foreach ($request['id_school_year'] as $index => $idSchoolYear) {

            if (isset($request['type'][$index]) && isset($request['template'][$index])) {

                if ($request['template_types'][$index] == 'jurusan') {

                    TemplateConfiguration::updateOrCreate(
                        [
                            'id_school_year' => $idSchoolYear,
                            'id_major' => $request['id_major'][$index],
                        ],
                        [
                            'type' => $request['type'][$index],
                            'template' => $request['template'][$index],
                        ]
                    );

                } else if ($request['template_types'][$index] == 'tingkatan') {
                    TemplateConfiguration::updateOrCreate(
                        [
                            'id_school_year' => $idSchoolYear,
                            'id_level' => $request['id_level'][$index],
                        ],
                        [
                            'type' => $request['type'][$index],
                            'template' => $request['template'][$index],
                        ]
                    );
                }

                Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
            } else {
                Helper::toast('Silahkan Pilih Jenis dan Template yang akan digunakan !', 'error');
            }

        }


        return redirect()->back();
    }
}