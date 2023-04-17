<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\HomeRoom\TeacherNoteRequest;
use App\Models\StudentClass;
use App\Models\TeacherNote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TeacherNoteController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        session()->put('title', 'Catatan Wali Kelas');
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.file', 'users.nis')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();

        $result = [];
        foreach ($students as $student) {
            $score = TeacherNote::where([
                ['id_student_class', $student->id],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', session('id_school_year')]
            ])->first();

            $result[] = [
                'id_student_class' => $student->id,
                'file' => $student->file,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_study_class' =>  session('teachers.id_study_class'),
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_school_year' => session('id_school_year'),
                'promotion' => $score ? $score->promotion : 'Y',
                'description' => $score ? $score->description : null,
            ];
        }
        // dd($students);
        return view('content.teacher_notes.v_teacher_note', compact('result'));
    }

    public function storeOrUpdate(TeacherNoteRequest $request)
    {
        $data = $request->validated();

        foreach ($data['id_student_class'] as $index => $id_student_class) {
            TeacherNote::updateOrCreate(
                [
                    'id_student_class' => $id_student_class,
                    'id_teacher' => Auth::guard('teacher')->user()->id,
                    'id_school_year' => session('id_school_year'),
                ],
                [
                    'promotion' => $request->promotion[$index],
                    'description' => $request->description[$index]
                ]
            );
        }
        Helper::toast('Berhasil menyimpan catatan', 'success');
        return redirect()->back();
    }
}
