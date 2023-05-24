<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\SchoolYear;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use App\Models\User;
use App\Models\UserParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DashboardController extends Controller
{
    public function admin()
    {
        // dd(session()->all());
        session()->put('title', 'Dashboard Admin');
        $settings = json_decode(Storage::get('settings.json'), true);
        session()->put('logo', isset($setting['logo']) ? asset($setting['logo']) : asset('asset/img/90x90.jpg'));
        $statistic = self::get_statistic();
        $school_year = SchoolYear::where('status', 1)->first();
        if ($school_year) {
            session()->put('id_school_year', $school_year->id);
            session()->put('slug_year', $school_year->slug);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
            session()->put('year', substr($school_year->name, 0, 4));
        }
        return view('content.dashboard.v_admin', compact('statistic'));
    }

    public function user()
    {
        session()->put('title', 'Dashboard Siswa');
        $school_year = SchoolYear::where('status', 1)->first();

        if ($school_year) {
            session()->put('id_school_year', $school_year->id);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
            session()->put('year', substr($school_year->name, 0, 4));
        } else {
            session()->put('message', 'Admin belum mengaktifkan tahun ajaran. Harap menghubungi admin untuk mengaktifkannya');
            return view('pages.v_error');
        }
        $student_class = StudentClass::where([
            ['id_student', session('id_student')],
            ['year', session('year')],
            ['status', 1],
        ])->latest()->first();
        if ($student_class == null) {
            Helper::toast('Siswa belum terdaftar di kelas manapun', 'error');
            return redirect()->back();
        }
        $study_class = StudyClass::find($student_class->id_study_class);
        session()->put('id_study_class', $student_class->id_study_class);
        session()->put('id_student_class', $student_class->id);
        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')]
        ])->first();
        $array_session = [
            'template' => $template->template,
            'type' => $template->type,
        ];
        session(['templates' => $array_session]);
        return view('content.dashboard.v_user');
    }

    public function teacher()
    {
        // dd(session()->all());
        session()->put('title', 'Dashboard Guru');
        $settings = json_decode(Storage::get('settings.json'), true);
        session()->put('logo', isset($setting['logo']) ? asset($setting['logo']) : asset('asset/img/90x90.jpg'));
        $statistic = self::get_statistic();
        $school_year = SchoolYear::where('status', 1)->first();
        // dd($school_year);
        if ($school_year) {
            session()->put('id_school_year', $school_year->id);
            session()->put('slug_year', $school_year->slug);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
            session()->put('year', substr($school_year->name, 0, 4));
        } else {
            session()->put('message', 'Admin belum mengaktifkan tahun ajaran. Harap menghubungi admin untuk mengaktifkannya');
            return view('pages.v_error');
        }
        return view('content.dashboard.v_teacher', compact('statistic'));
    }

    public static function get_statistic()
    {
        $statistic = [
            'students' => User::where('status', 1)->count(),
            'teachers' => Teacher::where('status', 1)->count(),
            'parents' => UserParent::where('status', 1)->count(),
        ];
        return $statistic;
    }
}
