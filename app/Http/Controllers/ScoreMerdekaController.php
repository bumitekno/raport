<?php

namespace App\Http\Controllers;

use App\Http\Requests\P5\ScoreRequest;
use App\Models\AssesmentWeighting;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class ScoreMerdekaController extends Controller
{
    public function index(Request $request)
    {
        // dd(session()->all());
        $data = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.place_of_birth', 'users.date_of_birth')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                            <a class="dropdown-item" href="' . route('setting_scores.score.create', $row->slug) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"></circle><line x1="21" y1="21" x2="16.65" y2="16.65"></line><line x1="11" y1="8" x2="11" y2="14"></line><line x1="8" y1="11" x2="14" y2="11"></line></svg> Lihat</a>
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

        return view('content.score_p5.v_list_student_score');
    }

    public function create($slug)
    {
        try {
            $weight = AssesmentWeighting::where([
                ['id_study_class', session('teachers.id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')],
            ])->firstOrFail();
            $result = [
                'id_study_class' => session('teachers.id_study_class'),
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_course' => session('teachers.id_course'),
                'id_school_year' => session('id_school_year'),
                'slug' => $slug
            ];
            return view('content.score_p5.v_create_student_score', compact('weight', 'result'));
        } catch (\Throwable $e) {
            session()->put('message', 'Terjadi kesalahan: ' . $e->getMessage());
            return view('pages.v_error');
        }
    }

    public function storeOrUpdate(ScoreRequest $request)
    {
        dd($request);
    }
}
