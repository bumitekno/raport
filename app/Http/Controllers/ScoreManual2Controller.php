<?php

namespace App\Http\Controllers;

use App\Exports\ScoreManual2Export;
use App\Helpers\Helper;
use App\Http\Requests\Manual\Score2Request;
use App\Imports\ScoreManual2Import;
use App\Models\Config;
use App\Models\Kkm;
use App\Models\PredicatedScore;
use App\Models\ScoreManual2;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ScoreManual2Controller extends Controller
{
    public function index()
    {
        $predicated = PredicatedScore::all();
        // dd($predicated);
        session()->put('title', 'Input Nilai');
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.nis')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
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
        $kkm = Kkm::where([
            ['id_study_class', session('teachers.id_study_class')],
            ['id_course', session('teachers.id_course')],
            ['id_school_year', session('id_school_year')],
        ])->first();

        $result = [];
        foreach ($students as $student) {
            $score = ScoreManual2::where([
                ['id_student_class', $student->id],
                ['id_study_class', session('teachers.id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')]
            ])->first();

            $result[] = [
                'id_student_class' => $student->id,
                'file' => $student->file,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_study_class' =>  session('teachers.id_study_class'),
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_course' => session('teachers.id_course'),
                'id_school_year' => session('id_school_year'),
                'kkm' => $kkm ? $kkm->score : '-',
                'final_assegment' => $score ? $score->final_assegment : 0,
                'final_skill' => $score ? $score->final_skill : 0,
                'predicate_assegment' => $score ? $score->predicate_assegment : 0,
                'predicate_skill' => $score ? $score->predicate_skill : 0,
                'status_form' => $status_form
            ];
        }
        // dd($result);
        return view('content.score_manual.v_student_score2', compact('result', 'predicated'));
    }

    public function storeOrUpdate(Score2Request $request)
    {
        // dd($request);
        $data = $request->validated();
        // dd($data);

        foreach ($data['id_student_class'] as $index => $id_student_class) {
            ScoreManual2::updateOrCreate(
                [
                    'id_student_class' => $id_student_class,
                    'id_teacher' => Auth::guard('teacher')->user()->id,
                    'id_study_class' => session('teachers.id_study_class'),
                    'id_course' => session('teachers.id_course'),
                    'id_school_year' => session('id_school_year'),
                ],
                [
                    'final_assegment' => $request->final_assegment[$index],
                    'final_skill' => $request->final_skill[$index],
                    'predicate_skill' => $request->predicate_skill[$index],
                    'predicate_assegment' => $request->predicate_assegment[$index],
                    'kkm' => $request->kkm[$index],
                ]
            );
        }
        Helper::toast('Berhasil menyimpan nilai', 'success');
        return redirect()->back();
    }

    public function export()
    {
        $title = '' . Carbon::now()->timestamp . '_format_mapel.xls';
        $MAX_LENGTH = 31;

        if (mb_strlen($title) > $MAX_LENGTH) {
            $truncated_title = mb_substr($title, 0, 28) . '...';
            $title = $truncated_title;
        }
        return Excel::download(new ScoreManual2Export, $title);
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $nama_file = $file->hashName();
            $path = $file->storeAs('public/excel/', $nama_file);
            Excel::import(new ScoreManual2Import(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->route('manual2s.scores.index');
        } catch (\Throwable $e) {
            Helper::toast($e->getMessage(), 'errror');
            // dd($e->getMessage());
            return redirect()->route('manual2s.scores.index');
        }
    }
}
