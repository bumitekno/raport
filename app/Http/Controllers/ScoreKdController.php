<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\K16\ScoreKdRequest;
use App\Models\BasicCompetency;
use App\Models\Config;
use App\Models\GeneralWeighting;
use App\Models\ScoreKd;
use App\Models\StudentClass;
use App\Models\SubjectTeacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ScoreKdController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Kelola Nilai K16');
        $data = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.place_of_birth', 'users.date_of_birth')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        $result = [];
        foreach ($data as $student) {
            $subject_teacher = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . session('teachers.id_study_class') . '"]\')')
                ->where([
                    ['id_teacher', Auth::guard('teacher')->user()->id],
                    ['id_course', session('teachers.id_course')],
                    ['id_school_year', session('id_school_year')],
                ])->first();
            $score = ScoreKd::where([
                ['id_student_class', $student->id],
                ['id_study_class', session('teachers.id_study_class')],
                ['id_subject_teacher', $subject_teacher->id],
                ['id_school_year', session('id_school_year')],
                ['type', session('teachers.type')]
            ])->first();
            $result[] = [
                'slug' => $student->slug,
                'name' => $student->name,
                'file' => $student->file,
                'email' => $student->email,
                'final_assesment' => $score ? $score->final_assesment : 0,
                'final_skill' => $score ? $score->final_skill : 0
            ];
        }
        // dd($data)
        if ($request->ajax()) {
            return DataTables::of($result)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('k13.scores.create', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg> Lihat</a>
                    </div>
                </div> ';
                })
                ->editColumn('name', function ($row) {
                    $file = asset('asset/img/90x90.jpg');
                    if ($row['file'] != null) {
                        $file = asset($row['file']);
                    }
                    return '<div class="d-flex">
                    <div class="usr-img-frame mr-2 rounded-circle">
                        <img alt="avatar" class="img-fluid rounded-circle" src="' . $file . '">
                    </div>
                    <p class="align-self-center mb-0 admin-name">' . $row['name'] . '</p>
                </div>';
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
        return view('content.score_k13.v_list_student_score');
    }

    public function create($slug)
    {
        // dd(session('teachers.type'));
        $basic_competencies = BasicCompetency::where([
            ['id_course', session('teachers.id_course')],
            ['id_level', session('teachers.id_level')]
        ])->get();
        // dd($basic_competencies);
        $weight = GeneralWeighting::where([
            ['id_study_class', session('teachers.id_study_class')],
            ['id_teacher', Auth::guard('teacher')->user()->id],
            ['id_course', session('teachers.id_course')],
            ['id_school_year', session('id_school_year')],
            ['type', session('teachers.type')],
        ])->first();
        $config = Config::where([
            ['id_school_year', session('id_school_year')],
            ['status', 1]
        ])->first();
        $status_form = true;
        if (!empty($config) && $config->closing_date != null) {
            $closing_date = Carbon::parse($config->closing_date)->startOfDay();
            if ($closing_date < now()->startOfDay()) {
                $status_form = false;
            }
        }
        // dd($weight);
        $student_class = StudentClass::where('slug', $slug)->first();
        $subject_teacher = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . session('teachers.id_study_class') . '"]\')')
            ->where([
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')],
            ])->first();
        $score = ScoreKd::where([
            ['id_student_class', $student_class->id],
            ['id_subject_teacher', $subject_teacher->id],
            ['id_study_class', session('teachers.id_study_class')],
            ['id_school_year', session('id_school_year')],
            ['type', session('teachers.type')]
        ])->first();
        $result = [
            'id_study_class' => session('teachers.id_study_class'),
            'id_subject_teacher' => $subject_teacher->id,
            'id_school_year' => session('id_school_year'),
            'id_student_class' => $student_class->id,
            'assessment_score' => $score ? json_decode($score->assessment_score) : [],
            'average_assesment' => $score ? $score->averege_assesment : 0,
            'skill_score' => $score ? json_decode($score->skill_score) : [],
            'average_skill' => $score ? $score->averege_skill : 0,
            'score_uts' => $score ? $score->score_uts : 0,
            'score_uas' => $score ? $score->score_uas : 0,
            'final_assesment' => $score ? $score->final_assesment : 0,
            'final_skill' => $score ? $score->final_skill : 0,
            'status_form' => $status_form
        ];
        // dd($result);
        if (empty($weight)) {
            session()->put('message', 'Terjadi kesalahan: Dikarenakan bobot nilai belum di setting ');
            return view('pages.v_error');
        }
        // dd($weight);
        if (session('teachers.type') == 'uas') {
            return view('content.score_k13.v_create_student_score', compact('weight', 'basic_competencies', 'result'));
        } else {
            return view('content.score_k13.v_create_student_score_uts', compact('weight', 'basic_competencies', 'result'));
        }

        // return view('content.score_k13.v_create_student_score', compact('weight', 'basic_competencies', 'result'));
    }

    public function update(ScoreKdRequest $request)
    {
        $data = $request->transformedData();
        ScoreKd::updateOrCreate(
            [
                'id_student_class' => $data['id_student_class'],
                'id_subject_teacher' => $data['id_subject_teacher'],
                'id_study_class' => $data['id_study_class'],
                'id_school_year' => $data['id_school_year'],
                'type' => $data['type'],
            ],
            [
                'assessment_score' =>  $data['assesment_score'],
                'averege_assesment' =>  $data['average_assesment'],
                'skill_score' =>  $data['skill_score'],
                'averege_skill' =>  $data['average_skill'],
                'score_uts' =>  $data['uts'],
                'score_uas' => $data['type'] == 'uas' ? $data['uas'] : null,
                'final_assesment' =>  $data['final_assesment'],
                'final_skill' =>  $data['final_skill'],
            ]
        );
        Helper::toast('Berhasil menyimpan data', 'success');
        return redirect()->back();
    }
}
