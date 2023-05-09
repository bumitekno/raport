<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

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
        $subject_teacher = SubjectTeacher::whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $request->id_study_class . '"]\', "$")')->where([
            ['id_course', $request->id_course],
            ['id_teacher', Auth::guard('teacher')->user()->id],
            ['id_school_year', session('id_school_year')],
        ])->first();
        $array_session = [
            'id_study_class' => $request->id_study_class,
            'id_course' => $request->id_course,
            'slug_course' => $course->slug,
            'slug_classes' => $study_class->slug,
            'id_level' => $study_class->id_level,
            'template' => $template->template,
            'type' => $template->type,
            'id_subject_teacher' => $subject_teacher->id,
        ];

        session(['teachers' => $array_session]);
        return redirect()->back();
    }

    public function layout(Request $request)
    {
        session(['layout' => $request->layout]);
        if ($request->layout == 'homeroom') {
            Session::forget('teachers');
            session(['id_study_class' => Auth::guard('teacher')->user()->id_class]);
            $study_class = StudyClass::find(session('id_study_class'));
            session(['slug_class' => $study_class->slug]);
            $template = TemplateConfiguration::where([
                ['id_major', $study_class->id_major],
                ['id_school_year', session('id_school_year')]
            ])->first();
            $array_session = [
                'template' => $template->template,
                'type' => $template->type,
            ];
            session(['templates' => $array_session]);
        }
        return redirect()->route('teacher.dashboard');
    }
}
