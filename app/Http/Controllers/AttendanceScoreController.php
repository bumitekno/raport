<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Attendances\AttendanceRequest;
use App\Models\AttendanceScore;
use App\Models\Config;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;

class AttendanceScoreController extends Controller
{
    public function index()
    {
        session()->put('title', 'Nilai Absensi');
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id',  'student_classes.status',  'student_classes.year', 'users.name', 'users.nis', 'users.file')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
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
        $result = [];
        foreach ($students as $student) {
            $score = AttendanceScore::where([
                ['id_student_class', $student->id],
                ['id_school_year', session('id_school_year')]
            ])->first();

            $result[] = [
                'id_student_class' => $student->id,
                'file' => $student->file,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_school_year' => session('id_school_year'),
                'ill' => $score ? $score->ill : 0,
                'excused' => $score ? $score->excused : 0,
                'unexcused' => $score ? $score->unexcused : 0,
                'status_form' => $status_form
            ];
        }
        return view('content.attendances.v_attendance', compact('result'));
    }

    public function storeOrUpdate(AttendanceRequest $request)
    {
        $data = $request->validated();
        $id = $data['id_student_class'];

        for ($i = 0; $i < count($id); $i++) {
            AttendanceScore::updateOrCreate(
                [
                    'id_student_class' => $id[$i],
                    'id_school_year' => session('id_school_year')
                ],
                [
                    'ill' => $data['ill'][$i],
                    'excused' => $data['excused'][$i],
                    'unexcused' => $data['unexcused'][$i]
                ]
            );
        }
        Helper::toast('Berhasil mengupdate absensi', 'success');
        return redirect()->back();
    }
}
