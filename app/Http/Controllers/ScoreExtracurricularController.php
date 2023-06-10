<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Score\ExtracurricularRequest;
use App\Models\Config;
use App\Models\Extracurricular;
use App\Models\ScoreExtracurricular;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ScoreExtracurricularController extends Controller
{
    public function index($slug)
    {
        $detail_extra = Extracurricular::where('slug', $slug)->firstOrFail();
        session()->put('title', 'Detail ' . $detail_extra->name);

        $extras = Extracurricular::where('status', 1)->get();

        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.file', 'users.nis')
            ->where([
                ['id_study_class', session('id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();

        $result = [];
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
        foreach ($students as $student) {
            $score = ScoreExtracurricular::where([
                ['id_study_class', session('id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', session('id_school_year')],
                ['id_extra', $detail_extra->id],
            ])->first();

            if ($score) {
                $scoreData = json_decode($score->score);

                foreach ($scoreData as $data) {
                    if ($data->id_student_class == $student->id) {
                        $score = $data->score;
                        $description = $data->description;
                        break;
                    }
                }
            } else {
                $score = '';
                $description = null;
            }

            $result[] = [
                'id_student_class' => $student->id,
                'file' => $student->file,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_study_class' => session('teachers.id_study_class'),
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_school_year' => session('id_school_year'),
                'score' => $score,
                'description' => $description,
                'status_form' => $status_form,
            ];
        }
        // dd($result);

        return view('content.extracurriculars.v_score_extracurricular', compact('extras', 'slug', 'result', 'detail_extra'));
    }

    public function storeOrUpdate(ExtracurricularRequest $request)
    {
        $data = $request->validated();
        $score = [];

        foreach ($data['id_student_class'] as $index => $id_student_class) {
            $score[$index] = [
                'id_student_class' => $id_student_class,
                'score' => $data['score'][$index],
                'description' => $data['description'][$index],
            ];
        }

        ScoreExtracurricular::updateOrCreate(
            [
                'id_study_class' => session('id_study_class'),
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_school_year' => session('id_school_year'),
                'id_extra' => $data['id_extra'],
            ],
            [
                'score' => json_encode($score),
            ]
        );
        Helper::toast('Berhasil menyimpan data', 'success');
        return redirect()->back();
    }
}
