<?php

namespace App\Http\Controllers;

use App\Exports\FullCompetenceArchievement;
use App\Helpers\Helper;
use App\Http\Requests\P5\CompetenceRequest;
use App\Imports\CompetenceArchievementMultipleImport;
use App\Models\CompetenceAchievement;
use App\Models\Course;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TypeCompetenceAchievement;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class CompetenceAchievementController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Kelola Capaian Kompetensi');
        $courses = [];
        $subject_teacher = SubjectTeacher::all();
        foreach ($subject_teacher as $item) {
            $studyClassIds = json_decode($item->id_study_class, true);

            foreach ($studyClassIds as $studyClassId) {
                $course = Course::find($item->id_course);
                $studyClass = StudyClass::find($studyClassId);
                $teacher = Teacher::find($item->id_teacher);
                if ($course && $studyClass && $teacher) {
                    $courses[] = [
                        'id_course' => $course->id,
                        'name_mapel' => $course->name,
                        'slug_mapel' => $course->slug,
                        'id_study_class' => $studyClass->id,
                        'name_class' => $studyClass->name,
                        'slug_class' => $studyClass->slug,
                        'id_teacher' => $teacher->id,
                        'name_teacher' => $teacher->name,
                        'slug_teacher' => $teacher->slug,
                    ];
                }
            }
        }
        $courses = collect($courses)->unique(function ($item) {
            return $item['id_course'] . $item['id_study_class'];
        })->values()->all();
        if ($request->ajax()) {
            $course = $request->input('course');
            $studyClass = $request->input('study_class');
            $teacher = $request->input('teacher');

            $data = CompetenceAchievement::with('type', 'course', 'study_class')
                ->when($course, function ($query) use ($course) {
                    return $query->whereHas('course', function ($subquery) use ($course) {
                        $subquery->where('slug', $course);
                    });
                })
                ->when($studyClass, function ($query) use ($studyClass) {
                    return $query->whereHas('study_class', function ($subquery) use ($studyClass) {
                        $subquery->where('slug', $studyClass);
                    });
                })
                ->when($teacher, function ($query) use ($teacher) {
                    return $query->whereHas('teacher', function ($subquery) use ($teacher) {
                        $subquery->where('slug', $teacher);
                    });
                })
                ->whereNull('deleted_at')
                ->select('*');

            if (!$course && !$studyClass && !$teacher) {
                $data->withoutGlobalScopes();
            }
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('setting_scores.competence.edit', ['course' => $row->course->slug, 'study_class' => $row->study_class->slug, 'teacher' => $row->teacher->slug, 'slug' => $row->slug]) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('setting_scores.competence.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('description', function ($row) {
                    return str_limit($row['description'], 50);
                })

                ->rawColumns(['action', 'description'])
                ->make(true);
        }
        // dd($courses);
        return view('content.score_p5.v_achievement_competence', compact('courses'));
    }

    public function list_competence(Request $request)
    {
        session()->put('title', 'Capaian Kompetensi');
        if ($request->ajax()) {
            $data = CompetenceAchievement::with('type', 'course', 'study_class')->select('*')->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['id_course', session('teachers.id_course')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', session('id_school_year')],
            ]);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('setting_scores.competence.edit', ['course' => $row->course->slug, 'study_class' => $row->study_class->slug, 'teacher' => $row->teacher->slug, 'slug' => $row->slug]) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('setting_scores.competence.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('description', function ($row) {
                    return str_limit($row['description'], 50);
                })

                ->rawColumns(['action', 'description'])
                ->make(true);
        }
        return view('content.score_p5.v_list_achievement_competence');
    }

    public function create(Request $request)
    {
        session()->put('title', 'Tambah Data');
        $course = Course::where('slug', $request->course)->first();
        // dd($course);
        $study_class = StudyClass::with('major', 'level')->where('slug', $request->study_class)->first();
        $teacher = Teacher::where('slug', $request->teacher)->first();
        $types = TypeCompetenceAchievement::all();
        return view('content.score_p5.v_create_competence', compact('course', 'teacher', 'study_class', 'types'));
    }

    public function edit(Request $request)
    {
        session()->put('title', 'Tambah Data');
        $course = Course::where('slug', $request->course)->first();
        $study_class = StudyClass::with('major', 'level')->where('slug', $request->study_class)->first();
        $teacher = Teacher::where('slug', $request->teacher)->first();
        $types = TypeCompetenceAchievement::all();
        $competence = CompetenceAchievement::where('slug', $request->slug)->first();
        return view('content.score_p5.v_create_competence', compact('course', 'teacher', 'study_class', 'types', 'competence'));
    }

    public function storeOrUpdate(CompetenceRequest $request, $id = null)
    {
        $data = $request->validated();

        CompetenceAchievement::updateOrCreate(
            ['id' => $id],
            [
                'id_course' => $data['id_course'],
                'id_study_class' => $data['id_study_class'],
                'id_teacher' => $data['id_teacher'],
                'id_type_competence' => $data['id_type_competence'],
                'id_school_year' => session('id_school_year'),
                'code' => $data['code'],
                'achievement' => $data['achievement'],
                'slug' => str_slug($data['achievement']) . '-' . Helper::str_random(5),
                'description' => $data['description']
            ]
        );
        Helper::toast('Berhasil mengupdate kompetensi', 'success');
        if (session('role') == 'teacher') {
            return redirect()->route('setting_scores.list_competence');
        } else {
            return redirect()->route('setting_scores.competence');
        }
    }

    public function destroy($slug)
    {
        $data = CompetenceAchievement::where('slug', $slug)->delete();
        // dd($data);
        Helper::toast('Berhasil menghapus kompetensi', 'success');
        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new FullCompetenceArchievement, '' . Carbon::now()->timestamp . '_format_competency.xls');
    }

    public function import(Request $request)
    {
        // dd(session()->all());
        // dd($request);
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $nama_file = $file->hashName();
            $path = $file->storeAs('public/excel/', $nama_file);
            Excel::import(new CompetenceArchievementMultipleImport($request->code_course, $request->code_study_class, $request->code_teacher, session('id_school_year')), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            if (Auth::guard('admin')->check()) {
                return redirect()->route('setting_scores.competence');
            } else {
                return redirect()->route('setting_scores.list_competence');
            }
        } catch (\Throwable $e) {
            Helper::toast($e->getMessage(), 'errror');
            if (Auth::guard('admin')->check()) {
                return redirect()->route('setting_scores.competence');
            } else {
                return redirect()->route('setting_scores.list_competence');
            }
        }
    }
}
