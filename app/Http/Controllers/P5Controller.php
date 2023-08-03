<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\P5\FormP5Request;
use App\Models\Dimension;
use App\Models\P5;
use App\Models\ScoreP5;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubElement;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\Tema;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class P5Controller extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Kelola Projek Penguatan Profil Pelajar Pancasila');

        if (Auth::guard('teacher')->check()) {
            $data = P5::select('p5_s.*', 'temas.name as tema', 'teachers.name as teacher', 'study_classes.name as class', DB::raw('JSON_LENGTH(sub_element) as sub_element_count'))
                ->leftJoin('temas', 'temas.id', '=', 'p5_s.id_tema')
                ->leftJoin('subject_teachers', 'subject_teachers.id', '=', 'p5_s.id_subject_teacher')
                ->leftJoin('teachers', 'teachers.id', '=', 'subject_teachers.id_teacher')
                ->leftJoin('study_classes', 'study_classes.id', '=', 'p5_s.id_study_class')
                ->leftJoin('sub_elements', 'sub_elements.id', '=', 'p5_s.id')
                ->where('subject_teachers.id_teacher', Auth::guard('teacher')->user()->id)
                ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . session('teachers.id_study_class') . '"]\', "$")')
                ->where('p5_s.id_study_class', session('teachers.id_study_class'))
                ->where('subject_teachers.id_course', session('teachers.id_course'))
                ->where('subject_teachers.id_school_year', session('id_school_year'))
                ->get();
        } else {
            $data = P5::select('p5_s.*', 'temas.name as tema', 'teachers.name as teacher', 'study_classes.name as class', DB::raw('JSON_LENGTH(sub_element) as sub_element_count'))
                ->leftJoin('temas', 'temas.id', '=', 'p5_s.id_tema')
                ->leftJoin('subject_teachers', 'subject_teachers.id', '=', 'p5_s.id_subject_teacher')
                ->leftJoin('teachers', 'teachers.id', '=', 'subject_teachers.id_teacher')
                ->leftJoin('study_classes', 'study_classes.id', '=', 'p5_s.id_study_class')
                ->leftJoin('sub_elements', 'sub_elements.id', '=', 'p5_s.id')
                ->get();
        }

        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                        <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                            <a class="dropdown-item" href="' . route('manages.detail', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path><circle cx="12" cy="12" r="3"></circle></svg> Detail</a>
                            <a class="dropdown-item" href="' . route('manages.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                            <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('manages.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                        </div>
                    </div> ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.p5.v_p5');
    }

    public function create()
    {
        session()->put('title', 'Tambah Proyek');
        $temas = Tema::where('status', 1)->get();
        $classes = StudyClass::where('status', 1)->get();

        $dimensions = Dimension::with('elements')->get();
        $subElements = SubElement::all();
        return view('content.p5.v_create_p5', compact('temas', 'classes', 'dimensions', 'subElements'));
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Proyek');
        $p5 = P5::where('slug', $slug)->firstOrFail();
        // dd($p5);
        if ($p5->id_study_class) {
            $teachers = SubjectTeacher::with('teacher', 'course')->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $p5->id_study_class . '"]\')')
                ->where('status', 1)
                ->get();
        } else {
            $teachers = collect([]);
        }
        // dd($teachers);
        $temas = Tema::where('status', 1)->get();
        // $teachers = Teacher::where('status', 1)->get();
        $classes = StudyClass::where('status', 1)->get();

        $dimensions = Dimension::with('elements')->get();
        $subElements = SubElement::all();
        return view('content.p5.v_create_p5', compact('temas', 'teachers', 'classes', 'dimensions', 'subElements', 'p5'));
    }

    public function detail(Request $request, $slug)
    {
        // dd(session()->all());
        $p5 = P5::where('slug', $slug)->with('study_class.level', 'tema')->first();
        // dd($p5);
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.id_student', 'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.slug', 'users.place_of_birth', 'users.date_of_birth', DB::raw("IF(student_classes.status = 1, 'siswa', 'alumni') as type"))
            ->when(session('year'), function ($query, $year) {
                return $query->where('year', $year);
            })
            ->where('id_study_class', $p5->id_study_class)
            ->get();

        $detail_student = StudentClass::join('users', 'users.id', '=', 'student_classes.id_student')
            ->select('users.*', 'student_classes.id as id_student_class')
            ->when($request->has('student'), function ($query) use ($request) {
                return $query->where('users.slug', $request->student);
            })
            ->latest()
            ->first();
        $scores = $detail_student ? ScoreP5::where('id_student_class', $detail_student->id_student_class)->first() : null;
        $description = optional($scores)->description;

        $subElements = collect(json_decode($p5->sub_element, true))
            ->map(function ($subElement) use ($scores) {
                $subElementModel = SubElement::with('dimension')->findOrFail($subElement['id_sub_element']);

                $score = 0;
                if ($scores && $scores->score) {
                    $scoreData = collect(json_decode($scores->score, true))->where('id_sub_element', $subElement['id_sub_element'])->first();
                    if ($scoreData) {
                        $score = $scoreData['score'];
                    }
                }

                return [
                    'id' => $subElementModel->id,
                    'name' => $subElementModel->name,
                    'score' => $score,
                    'dimension' => [
                        'id' => $subElementModel->dimension->id,
                        'name' => $subElementModel->dimension->name,
                    ],
                ];
            })
            ->groupBy('dimension.id')
            ->map(function ($grouped) {
                $dimension = $grouped->first()['dimension'];
                $subElements = $grouped->map(function ($subElement) {
                    return [
                        'id' => $subElement['id'],
                        'name' => $subElement['name'],
                        'score' => $subElement['score'],
                    ];
                })->toArray();

                return [
                    'id' => $dimension['id'],
                    'name' => $dimension['name'],
                    'sub_elements' => $subElements,
                ];
            })
            ->values()
            ->toArray();

        $data = [
            'subElements' => $subElements,
            'description' => $description,
        ];
        // dd($data);
        return view('content.p5.v_modify_p5', compact('p5', 'students', 'data', 'detail_student'));
    }

    public function updateOrCreate(FormP5Request $request, $id = null)
    {
        // dd($id);
        $sub_elements = [];
        if ($request->sub_element && is_array($request->sub_element)) {
            foreach ($request->sub_element as $sub_element) {
                $id_element = explode('-', $sub_element);
                $sub_elements[] = [
                    'id_sub_element' => $id_element[0],
                    'id_dimension' => $id_element[1],
                ];
            }
        }

        if ($id) {
            // update existing data
            $user = P5::findOrFail($id);
            $user->id_tema = $request->input('id_tema');
            $user->title = $request->input('title');
            $user->slug = str_slug($request->input('title')) . '-' . Helper::str_random(5);
            $user->description = $request->input('description');
            $user->id_subject_teacher = $request->input('id_subject_teacher');
            $user->id_study_class = $request->input('id_study_class');
            $user->sub_element = json_encode($sub_elements);
            $user->save();
        } else {
            // create new data
            $user = new P5();
            // set user data
            $user->id_tema = $request->input('id_tema');
            $user->title = $request->input('title');
            $user->description = $request->input('description');
            $user->id_subject_teacher = $request->input('id_subject_teacher');
            $user->id_study_class = $request->input('id_study_class');
            $user->slug = str_slug($request->input('title')) . '-' . Helper::str_random(5);
            $user->sub_element = json_encode($sub_elements);
            $user->save();
        }

        Helper::toast('Berhasil menambah proyek K5', 'success');
        return redirect()->route('manages.index');
    }

    public function destroy($slug)
    {
        $p5 = P5::where('slug', $slug)->firstOrFail();
        $p5->delete();
        Helper::toast('Berhasil menghapus proyek P5', 'success');
        return redirect()->route('manages.index');
    }
}
