<?php

namespace App\Http\Controllers;

use App\Models\StudyClass;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function set_layout(Request $request)
    {
        $id_major = StudyClass::find($request->id_study_class)->id_major;
        $template = TemplateConfiguration::where([
            ['id_major', $id_major],
            ['id_school_year', session('id_school_year')]
        ])->first();
        $array_session = [
            'id_study_class' => $request->id_study_class,
            'id_course' => $request->id_course,
            'template' => $template->template,
            'type' => $template->type,

        ];
        if ($template == null) {
            session()->put('message', 'Admin Belum mengatur tampilan / template raport');
            return view('pages.v_error');
        }
        session(['teachers' => $array_session]);
        return redirect()->back();
    }
}
