<?php

namespace App\Http\Controllers;

use App\Models\AttendanceScore;
use App\Models\CompetenceAchievement;
use App\Models\Config;
use App\Models\Extracurricular;
use App\Models\Letterhead;
use App\Models\SchoolYear;
use App\Models\ScoreCompetency;
use App\Models\ScoreExtracurricular;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\SubjectTeacher;
use App\Models\TeacherNote;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
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
            // dd($school_years);
            return view('content.previews.v_preview', compact('school_years'));
        } else {
            dd('tampilan guru');
        }
    }

    public function sample()
    {
        // dd('tes');
        switch ($_GET['template']) {
            case 'k13':
                $pdf = PDF::loadView('content.previews.k13.v_print_sample_pas');
                return $pdf->stream();
                break;

            default:
                # code...
                break;
        }
    }

    public function print($year)
    {
        $school_year = SchoolYear::where('slug', $year)->first();

        $student_class = StudentClass::with('student', 'study_class', 'study_class.level', 'study_class.major')->where([
            ['id_student', session('id_student')],
            ['year', substr($school_year->name, 0, 4)],
        ])->first();

        $template = TemplateConfiguration::where([
            ['id_major', $student_class->study_class->major->id],
            ['id_school_year', $school_year->id],
        ])->first();

        $setting = json_decode(Storage::get('settings.json'), true);

        switch ($template->template) {
            case 'k13':
                return $this->preview_k13($student_class, $setting, $school_year);
                break;
            case 'merdeka':
                return $this->preview_merdeka($student_class, $setting, $school_year);
                break;

            default:
                # code...
                break;
        }
        // dd($template);
        // dd($student_class);


        // $semester = substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap';

    }

    function preview_merdeka($student_class, $setting, $school_year)
    {
        $result_profile = [
            'name' => strtoupper($student_class->student->name),
            'nisn' => $student_class->student->nisn,
            'school' => strtoupper($setting['name_school']),
            'address_school' => $setting['address'],
            'study_class' => $student_class->study_class->name,
            'fase' => $student_class->study_class->level->fase,
            'semester_number' => substr($school_year->name, -1),
            'semester' => substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap',
            'school_year' => substr($school_year->name, 0, 9),
        ];

        // dd($result_profile);


        $subjects = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . session('id_study_class') . '"]\')')
            ->where([
                ['status', 1],
                ['id_school_year', $school_year->id],
            ])->get();

        $score = ScoreMerdeka::where([
            ['id_student_class', session('id_student_class')],
            ['id_school_year', $school_year->id],
        ])->get()->map(function ($item) {
            $item->id_study_class = json_decode($item->id_study_class);
            return $item;
        });

        $competencies = CompetenceAchievement::where('status', 1)->get();

        foreach ($subjects as $subject) {
            $score_competencies = ScoreCompetency::where([
                ['id_student_class', session('id_student_class')],
                ['id_teacher', $subject->id_teacher],
                ['id_course', $subject->id_course],
                ['id_study_class', session('id_study_class')],
                ['id_school_year', $school_year->id],
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
        $result_extra = [];

        $extras = Extracurricular::where('status', 1)->get();

        foreach ($extras as $extra) {
            $score_extra = ScoreExtracurricular::where([
                ['id_study_class', session('id_study_class')],
                // ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', $school_year->id],
                ['id_extra', $extra->id],
            ])->first();

            $id_extra = $extra->id;
            $name = $extra->name;
            $score = null;
            $description = null;
            if ($score_extra) {
                $scoreData = json_decode($score_extra->score);
                foreach ($scoreData as $data) {
                    if ($data->id_student_class == session('id_student_class')) {
                        $score = $data->score;
                        $description = $data->description;
                        break;
                    }
                }
            }
            $result_extra[] = [
                'id_extra' => $id_extra,
                'name' => $name,
                'score' => $score ? $score : null,
                'description' => $description ? $description : null
            ];
        }
        $attendance = AttendanceScore::where([
            ['id_student_class', session('id_student_class')],
            ['id_school_year', $school_year->id],
        ])->first();

        $result_attendance = [
            'ill' => $attendance ? $attendance->ill : 0,
            'excused' => $attendance ? $attendance->excused : 0,
            'unexcused' => $attendance ? $attendance->unexcused : 0,
        ];

        $letter_head = Letterhead::first();
        $result_kop = [
            'text1' => $letter_head ? $letter_head->text1 : null,
            'text2' => $letter_head ? $letter_head->text2 : null,
            'text3' => $letter_head ? $letter_head->text3 : null,
            'text4' => $letter_head ? $letter_head->text4 : null,
            'text5' => $letter_head ? $letter_head->text5 : null,
            'left_logo' => $letter_head ? $letter_head->left_logo : null,
            'right_logo' => $letter_head ? $letter_head->right_logo : null,
        ];

        $note = TeacherNote::where([
            ['id_student_class', session('id_student_class')],
            ['id_school_year', $school_year->id]
        ])->first();
        // dd($note);
        $config = Config::where('id_school_year', $school_year->id)->first();
        // dd($config);
        $result_other = [
            'note_teacher' => $note ? $note->description : '',
            'promotion' => $note ? $note->promotion : 'Y',
            'place' => $config ? $config->place : '',
            'date' => $config ? $config->report_date : now(),
            'headmaster' => $config ? $config->headmaster : '',
            'nip_headmaster' => $config ? $config->nip_headmaster : '',
            'signature' => $config ? public_path($config->signature) : null,
        ];
        // dd($result_other);
        $pdf = PDF::loadView('content.previews.merdeka.v_print_pas', compact('result_score', 'result_extra', 'result_attendance', 'result_kop', 'result_profile', 'result_other'));
        return $pdf->stream();
    }

    function preview_k13($student_class, $setting, $school_year)
    {
        dd($student_class);
    }
}
