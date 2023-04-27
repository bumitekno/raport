<?php

namespace App\Http\Controllers;

use App\Models\CompetenceAchievement;
use App\Models\SchoolYear;
use App\Models\ScoreCompetency;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreMerdeka;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDF;

class PreviewController extends Controller
{
    public function index()
    {
        $school_years = SchoolYear::all();
        if (Auth::guard('user')->check() || Auth::guard('parent')->check()) {
            if (session()->has('templates')) {
                $templatesTemplate = session('templates.template');
                foreach ($school_years as &$year) {
                    $score = null;
                    switch ($templatesTemplate) {
                        case 'manual':
                            $score = ScoreManual::where([
                                ['id_study_class', session('id_study_class')],
                                ['id_student_class', session('id_student_class')],
                                ['id_school_year', $year->id],
                            ])->exists();
                            break;
                        case 'k16':
                            $score = ScoreKd::where([
                                ['id_student_class', session('id_student_class')],
                                ['id_school_year', $year->id],
                            ])->exists();
                            break;
                        default:
                            $score = ScoreMerdeka::where([
                                ['id_study_class', session('id_study_class')],
                                ['id_student_class', session('id_student_class')],
                                ['id_school_year', $year->id],
                            ])->exists();
                    }
                    $year['score'] = $score;
                }
            } else {
                session()->put('message', 'Admin belum mengaktifkan template raport');
                return view('pages.v_error');
            }
            return view('content.previews.v_preview', compact('school_years'));
        } else {
            dd('tampilan guru');
        }
    }

    public function print()
    {
        $result_score = [];
        $ekskul_tampil = [];
        $prestasi_for = [];


        $subjects = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . session('id_study_class') . '"]\')')
            ->where([
                ['status', 1],
                ['id_school_year', session('id_school_year')],
            ])->get();

        $score = ScoreMerdeka::where([
            ['id_student_class', session('id_student_class')],
            ['id_school_year', session('id_school_year')],
        ])->get()->map(function ($item) {
            $item->id_study_class = json_decode($item->id_study_class);
            return $item;
        });

        $competencies = CompetenceAchievement::where('status', 1)->get();
        // dd($competencies);

        // $mapel_tampil = [];

        foreach ($subjects as $subject) {
            $score_competencies = ScoreCompetency::where([
                ['id_student_class', session('id_student_class')],
                ['id_teacher', $subject->id_teacher],
                ['id_course', $subject->id_course],
                ['id_study_class', session('id_student_class')],
                ['id_school_year', session('id_school_year')],
            ])->get();

            $nilai = collect($score)->firstWhere('id_teacher', $subject->id_teacher)
                ->where('id_study_class', session('id_study_class'))
                ->where('id_course', $subject->id_course)
                ->where('id_school_year', intval($subject->id_school_year))->first();

            $competency_archieved = [];
            $competency_improved = [];

            foreach ($score_competencies as $score_competency) {
                $archieved_ids = json_decode($score_competency->competency_archieved);
                $improved_ids = json_decode($score_competency->competency_improved);

                $archieved_names = $competencies->whereIn('id', $archieved_ids)->pluck('achievement');
                $improved_names = $competencies->whereIn('id', $improved_ids)->pluck('achievement');

                $competency_archieved = collect($competency_archieved)->merge($archieved_names);
                $competency_improved = collect($competency_improved)->merge($improved_names);
            }

            $result_score[] = [
                'id_course' => $subject->id_course,
                'course' => $subject->course->name,
                'score' => empty($score) ? null : $nilai->final_score,
                'competence_archieved' => $competency_archieved->toArray(),
                'competency_improved' => $competency_improved->toArray(),
            ];
        }
        // dd($mapel_tampil);
        $pdf = PDF::loadView('content.previews.merdeka.v_print_pas', compact('result_score'));

        // Mengirim output PDF ke browser
        return $pdf->stream();
        // return view('content.previews.merdeka.v_print_pas');
    }
}
