<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Achievement\AchievementRequest;
use App\Models\Achievement;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Prestasi');
        if ($request->ajax()) {
            $data = Achievement::select('*')->with('student_class.student', 'student_class.study_class');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('achievements.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('achievements.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('student', function ($row) {
                    $file = asset('asset/img/90x90.jpg');
                    if ($row->student_class->student->file != null) {
                        $file = asset($row->student_class->student->file);
                    }
                    return '<div class="d-flex">
                    <div class="usr-img-frame mr-2 rounded-circle">
                        <img alt="avatar" class="img-fluid rounded-circle" src="' . $file . '">
                    </div>
                    <p class="align-self-center mb-0 admin-name">' . $row->student_class->student->name . '</p>
                </div>';
                })
                ->rawColumns(['action', 'student'])
                ->make(true);
        }
        return view('content.achievements.v_achievement');
    }

    public function create()
    {
        session()->put('title', 'Tambah Prestasi');
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.file', 'users.nis')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        return view('content.achievements.v_form_achievement', compact('students'));
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Prestasi');
        $achievement = Achievement::where('slug', $slug)->first();
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.file', 'users.nis')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        return view('content.achievements.v_form_achievement', compact('students', 'achievement'));
    }

    public function storeOrUpdate(AchievementRequest $request, $id = null)
    {
        $data = $request->validated();
        Achievement::updateOrCreate(
            [
                'id' => $id
            ],
            [
                'id_student_class' => $data['id_student_class'],
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_study_class' => session('id_study_class'),
                'ranking' => $data['ranking'],
                'level' => $data['level'],
                'id_school_year' => session('id_school_year'),
                'name' => $data['name'],
                'slug' => str_slug($data['name']) . $data['id_student_class'] . Auth::guard('teacher')->user()->id . '-' . Helper::str_random(5),
                'description' => $data['description']
            ]
        );
        Helper::toast('Berhasil menyimpan prestasi', 'success');
        return redirect()->route('achievements.index');
    }

    public function destroy($slug)
    {
        Achievement::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus prestasi', 'success');
        return redirect()->back();
    }
}
