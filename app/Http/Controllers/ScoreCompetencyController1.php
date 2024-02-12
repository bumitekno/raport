<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\P5\ScoreCompetencyRequest;
use App\Models\CompetenceAchievement;
use App\Models\ScoreCompetency;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ScoreCompetencyController extends Controller
{
    public function index(Request $request)
    {
        $data = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.place_of_birth', 'users.date_of_birth')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        $competencies = CompetenceAchievement::with('type', 'course', 'study_class')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['id_course', session('teachers.id_course')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', session('id_school_year')],
            ])->get();
        $result = [];
        foreach ($data as $student) {
            $score = ScoreMerdeka::where([
                ['id_student_class', $student->id],
                ['id_study_class', session('teachers.id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')]
            ])->first();
            $score_competencies = ScoreCompetency::where([
                ['id_student_class', $student->id],
                ['id_study_class', session('teachers.id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')]
            ])->first();
            $archieved = [];

            foreach ($competencies as $competency) {
                if ($score_competencies == null) {
                    $checked = false;
                } else {
                    $competency_archieved = json_decode($score_competencies->competency_archieved);
                    $checked = in_array($competency->id, $competency_archieved);
                }
                $archieved[] = [
                    'id' => $competency->id,
                    'code' => $competency->code,
                    'achievement' => $competency->achievement,
                    'checked' => $checked,
                ];
            }
            $improved = [];

            foreach ($competencies as $competency) {
                if ($score_competencies == null) {
                    $checked = false;
                } else {
                    $competency_improved = json_decode($score_competencies->competency_improved);
                    $checked = in_array($competency->id, $competency_improved);
                }
                $improved[] = [
                    'id' => $competency->id,
                    'code' => $competency->code,
                    'achievement' => $competency->achievement,
                    'checked' => $checked,
                ];
            }
            $result[] = [
                'id' => $student->id,
                'slug' => $student->slug,
                'name' => $student->name,
                'file' => $student->file,
                'nisn' => $student->nisn,
                'place_of_birth' => $student->place_of_birth,
                'date_of_birth' => $student->date_of_birth,
                'score' => $score ? $score->final_score : 0,
                'competency_archieved' => $archieved,
                'competency_improved' => $improved,
            ];
        }
        // dd($result);

        return view('content.score_p5.v_score_competency', compact('result', 'competencies'));
    }

    public function storeOrUpdate(ScoreCompetencyRequest $request)
    {
        $counts = $request->input('count_each');
        foreach ($counts as $index => $count) {
            $archieved = [];
            if ($request->has('competency_achieved_' . ($index + 1))) {
                $archieved = $request->input('competency_achieved_' . ($index + 1));
            }

            $improved = [];
            if ($request->has('competency_improved_' . ($index + 1))) {
                $improved = $request->input('competency_improved_' . ($index + 1));
            }

            ScoreCompetency::updateOrCreate(
                [
                    'id_student_class' => $request->input('id_student_class_' . ($index + 1)),
                    'id_teacher' => Auth::guard('teacher')->user()->id,
                    'id_course' => session('teachers.id_course'),
                    'id_study_class' => session('teachers.id_study_class'),
                    'id_school_year' => session('id_school_year'),
                ],
                [
                    'competency_archieved' => json_encode($archieved),
                    'competency_improved' => json_encode($improved),
                ]
            );
        }

        Helper::toast('Berhasil mengupdate Nilai Kompetensi', 'success');
        return redirect()->back();
    }
}
