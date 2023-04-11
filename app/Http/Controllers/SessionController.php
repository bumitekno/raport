<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyClass;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;

class SessionController extends Controller
{
    public function set_layout(Request $request)
    {
        $study_class = StudyClass::find($request->id_study_class);
        $course = Course::find($request->id_course);
        // dd($course);
        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')]
        ])->first();
        if ($template == null) {
            session()->put('message', 'Admin Belum mengatur tampilan / template raport');
            return view('pages.v_error');
        }
        $array_session = [
            'id_study_class' => $request->id_study_class,
            'id_course' => $request->id_course,
            'slug_course' => $course->slug,
            'slug_classes' => $study_class->slug,
            'template' => $template->template,
            'type' => $template->type,

        ];

        session(['teachers' => $array_session]);
        return redirect()->back();
    }
}
