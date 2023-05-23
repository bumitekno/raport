<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\Attitude;
use App\Models\AttitudeGrade;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttitudeGradeController extends Controller
{
    public function index($type)
    {
        // dd(session()->all());
        $title = $type == 'social' ? 'Sosial' : 'Spiritual';
        session()->put('title', 'Nilai Sikap ' . $title);

        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.file', 'users.nis')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();

        $result = [];
        $attitudes = Attitude::where('type', $type)->get();
        // dd($attitudes);
        foreach ($students as $student) {
            $score = AttitudeGrade::where([
                ['type', $type],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_student_class', $student->id],
                ['id_school_year', session('id_school_year')]
            ])->first();
            // dd($score);

            $r_attitudes = [];

            foreach ($attitudes as $attitude) {
                if ($score) {
                    $attitude_selected = json_decode($score->attitudes);
                    $checked = in_array($attitude->id, $attitude_selected);
                } else {
                    $checked = false;
                }

                $r_attitudes[] = [
                    'id' => $attitude->id,
                    'name' => $attitude->name,
                    'checked' => $checked,
                ];
            }

            $result[] = [
                'id_student_class' => $student->id,
                'file' => $student->file,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_study_class' =>  session('teachers.id_study_class'),
                'predicate' => $score ? $score->predicate : 'cukup',
                'id_school_year' => session('id_school_year'),
                'attitudes' => $r_attitudes,
            ];
        }
        // dd($result);
        return view('content.attitude_grades.v_attitude_grade', compact('result', 'attitudes', 'type'));
    }

    public function storeOrUpdate(Request $request, $type)
    {
        // dd($request);
        foreach ($request->id_student_class as $key => $val) {
            $attitudes = $request->input('attitudes' . $val, []);
            // dd($attitudes);
            AttitudeGrade::updateOrCreate(
                [
                    'id_student_class' => $val,
                    'id_school_year' => session('id_school_year'),
                    'id_teacher' => Auth::guard('teacher')->user()->id,
                    'type' => $type,
                ],
                [
                    'predicate' => $request->predicate[$key],
                    'attitudes' => json_encode($attitudes)
                ]
            );
        }
        // dd($data);
        Helper::toast('Berhasil menyimpan nilai sikap', 'success');
        return redirect()->back();
    }
}
