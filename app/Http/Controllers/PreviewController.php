<?php

namespace App\Http\Controllers;

use App\Http\Resources\Master\SchoolYearResource;
use App\Models\Achievement;
use App\Models\AttendanceScore;
use App\Models\Attitude;
use App\Models\AttitudeGrade;
use App\Models\BasicCompetency;
use App\Models\CompetenceAchievement;
use App\Models\Config;
use App\Models\Cover;
use App\Models\Dimension;
use App\Models\Extracurricular;
use App\Models\Letterhead;
use App\Models\P5;
use App\Models\PredicatedScore;
use App\Models\SchoolYear;
use App\Models\ScoreCompetency;
use App\Models\ScoreExtracurricular;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreManual2;
use App\Models\ScoreMerdeka;
use App\Models\ScoreP5;
use App\Models\StudentClass;
use App\Models\SubElement;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TeacherNote;
use App\Models\TemplateConfiguration;
use App\Models\DefaultTemplate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use PDF;

class PreviewController extends Controller
{
    public function index()
    {
        session()->put('title', 'Lihat Raport');
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
                        case 'manual2':
                            $score = ScoreManual2::where([
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
            // dd(session()->all());
            $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
                ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status', 'student_classes.year', 'users.name', 'users.file', 'users.nis')
                ->where([
                    ['id_study_class', session('id_study_class')],
                    ['student_classes.status', 1],
                ])->get();
            $years = SchoolYear::all();
            $years = SchoolYearResource::collection($years)->toArray(request());
            if ($_GET['template'] == 'merdeka') {
                $detail_year = SchoolYear::where('slug', $_GET['year'])->first();
                $students = $students->where('year', substr($detail_year->name, 0, 4));
                // dd($students);

                // dd($years);
                $view = 'content.previews.v_list_merdeka_students';
            } else {
                // $years = [];
                $students = $students->where('year', session('year'));
                $view = 'content.previews.v_list_students';
            }
            // dd($students);

            return view($view, compact('students', 'years'));
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
            case 'merdeka':
                $pdf = PDF::loadView('content.previews.merdeka.v_print_sample_pas');
                return $pdf->stream();
                break;
            case 'manual2':
                $pdf = PDF::loadView('content.previews.manual2.v_print_sample_pas');
                return $pdf->stream();
                break;
            default:
                $pdf = PDF::loadView('content.previews.manual.v_print_sample_pas');
                return $pdf->stream();
                break;
        }
    }

    public function otherPrint($slug)
    {
        dd($slug);
    }


    public function print($year)
    {
        $school_year = SchoolYear::where('slug', $year)->first();

        $student_class = StudentClass::with('student', 'study_class', 'study_class.level', 'study_class.major')->where([
            ['id_student', session('id_student')],
            ['year', substr($school_year->name, 0, 4)],
        ])->latest()->first();

        $template = TemplateConfiguration::where([
            ['id_major', $student_class->study_class->major->id],
            ['id_school_year', $school_year->id],
        ])->first();


        $subjects = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . $student_class->id_study_class . '"]\')')
            ->where([
                ['status', 1],
                ['id_school_year', $school_year->id],
            ])->get();

        $setting = json_decode(Storage::get('settings.json'), true);

        if (!empty($template)) {
            switch ($template->template) {
                case 'k13':
                    return $this->preview_k13($student_class, $setting, $school_year, $subjects, $template->type);
                    break;
                case 'merdeka':
                    return $this->preview_merdeka($student_class, $setting, $school_year, $subjects, $template->type);
                    break;
                case 'manual2':
                    return $this->preview_manual2($student_class, $setting, $school_year, $subjects);
                    break;
                default:
                    return $this->preview_manual($student_class, $setting, $school_year, $subjects, $template->type);
                    break;
            }
        } else {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }
    }

    public function print_other()
    {
        // dd('print other');
        $school_year = SchoolYear::where('slug', $_GET['year'])->first();

        $defaultTemplate = DefaultTemplate::where('id_school_year', $school_year->slug)->first();

        if (empty($school_year)) {
            session()->put('message', 'Tahun Ajaran belum di ketahui , silahkan setting terlebih dahulu!');
            return view('pages.v_error');
        }

        if (empty($defaultTemplate)) {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }


        $student_class = StudentClass::with('student', 'study_class', 'study_class.level', 'study_class.major')->where('slug', $_GET['student'])->latest()->first();

        if ($defaultTemplate->type == 'tingkatan' && !empty($defaultTemplate)) {

            $template = TemplateConfiguration::where([
                ['id_level', $student_class->study_class->level->id],
                ['id_school_year', $school_year->id],
            ])->first();

        } else if ($defaultTemplate->type == 'jurusan' && !empty($defaultTemplate)) {

            $template = TemplateConfiguration::where([
                ['id_major', $student_class->study_class->major->id],
                ['id_school_year', $school_year->id],
            ])->first();

        }

        $subjects = SubjectTeacher::whereRaw('JSON_CONTAINS(id_study_class, \'["' . $student_class->id_study_class . '"]\')')
            ->where([
                ['status', 1],
                ['id_school_year', $school_year->id],
            ])->get();

        $setting = json_decode(Storage::get('settings.json'), true);
        // dd($template->template);
        if (!empty($template)) {
            switch ($template->template) {
                case 'k13':
                    return $this->preview_k13($student_class, $setting, $school_year, $subjects, $template->type, $defaultTemplate);
                    break;
                case 'merdeka':
                    $type = (session('role') == 'admin') ? $template->type : $_GET['type'];
                    return $this->preview_merdeka($student_class, $setting, $school_year, $subjects, $type, $defaultTemplate);
                    break;
                case 'manual2':
                    return $this->preview_manual2($student_class, $setting, $school_year, $subjects, $defaultTemplate);
                    break;
                default:
                    return $this->preview_manual($student_class, $setting, $school_year, $subjects, $template->type, $defaultTemplate);
                    break;
            }
        } else {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }
    }

    public function coverPrint()
    {
        // dd('print sampul raport');
        $school_year = SchoolYear::where('slug', $_GET['year'])->first();
        $student_class = StudentClass::where([
            ['slug', $_GET['student']],
            ['status', 1]
        ])->with([
                    'student',
                    'student.study_class',
                    'student.families' => function ($query) {
                        $query->whereIn('type', ['father', 'mother', 'guardian']);
                    }
                ])->first();

        if (!empty($student_class->student->families)) {

            $families = $student_class->student->families->first(function ($family) {
                return $family->type === 'father' || $family->type === 'mother' || $family->type === 'guardian';
            });

            // Jika parents ditemukan, dapatkan data-nya, jika tidak, setel menjadi null
            $father = $families && $families->type === 'father' ? $families : null;
            $mother = $families && $families->type === 'mother' ? $families : null;
            $guardian = $families && $families->type === 'guardian' ? $families : null;
            $familly = [
                'father' => $father,
                'mother' => $mother,
                'guardian' => $guardian,
            ];
        }

        // dd($student_class);
        $cover = Cover::where('id_school_year', $school_year->id)->first();
        // dd($cover);
        if (empty($cover)) {
            session()->put('message', 'Belum ada cover yang tersedia, harap hubungi admin untuk segera menambahkannya');
            return view('pages.v_error');
        }
        $setting = json_decode(Storage::get('settings.json'), true);
        // dd($setting);
        $config = Config::where('id_school_year', $school_year->id)->first();
        // dd($config);
        $result_other = [
            'headmaster' => $config ? $config->headmaster : '',
            'nip_headmaster' => $config ? $config->nip_headmaster : '',
            'signature' => $config && $config['signature'] != null ? public_path($config->signature) : null,
        ];
        // return view('content.previews.v_print_cover', compact('cover', 'student_class', 'setting', 'result_other'));
        $pdf = PDF::loadView('content.previews.v_print_cover', compact('cover', 'student_class', 'setting', 'result_other', 'familly'));
        return $pdf->stream();
    }

    public function printP5()
    {

        $student_class = StudentClass::where([
            ['slug', $_GET['student']],
            ['status', 1]
        ])->first();
        $setting = json_decode(Storage::get('settings.json'), true);
        $school_year = SchoolYear::where('slug', $_GET['year'])->first();
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
        $scores_p5 = ScoreP5::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $result_score = [];

        foreach ($scores_p5 as $score_p5) {
            $title = optional($score_p5->p5)->title;
            $tema = optional(optional($score_p5->p5)->tema)->name;

            $dimensions = Dimension::where('status', 1)->get();
            $dimension_data = [];

            foreach ($dimensions as $dimension) {
                $sub_elements = SubElement::where([
                    ['id_dimension', $dimension->id],
                    ['status', 1]
                ])->get();

                $sub_element_scores = collect(json_decode($score_p5->score))->where('id_dimension', $dimension->id)->keyBy('id_sub_element');

                if ($sub_element_scores->count() == 0) {
                    continue;
                }

                $sub_element_data = [];
                foreach ($sub_elements as $sub_element) {
                    if (!$sub_element_scores->has($sub_element->id)) {
                        continue;
                    }

                    $score = $sub_element_scores[$sub_element->id]->score;
                    $sub_element_data[] = [
                        'name' => $sub_element->name,
                        'score' => $score,
                    ];
                }

                $dimension_data[] = [
                    'name' => $dimension->name,
                    'sub_elements' => $sub_element_data,
                ];
            }

            $description = $score_p5->description;

            $result_score[] = [
                'title' => $title,
                'tema' => $tema,
                'dimensi' => $dimension_data,
                'description' => $description,
            ];
        }

        $note = TeacherNote::where([
            ['id_student_class', $student_class->id],
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
            'signature' => $config && $config->signature != null ? public_path($config->signature) : null,
        ];
        // dd($result_score);
        // return view('content.previews.merdeka.v_print_p5', compact('result_score', 'result_profile', 'result_other'));

        $pdf = PDF::loadView('content.previews.merdeka.v_print_p5', compact('result_score', 'result_profile', 'result_other'));
        // set ukuran margin
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream();
    }

    function preview_merdeka($student_class, $setting, $school_year, $subjects, $type_template, $defaultTemplate)
    {

        if (empty($defaultTemplate)) {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }

        // dd($student_class);
        $result_profile = [
            'name' => strtoupper($student_class->student->name),
            'nisn' => $student_class->student->nisn,
            'school' => strtoupper($setting['name_school']),
            'address_school' => $setting['address'],
            'study_class' => $student_class->study_class->name,
            'level' => $student_class->study_class->level->name,
            'fase' => $student_class->study_class->level->fase,
            'major' => $student_class->study_class->major->name,
            'semester_number' => substr($school_year->name, -1),
            'semester' => substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap',
            'school_year' => substr($school_year->name, 0, 9),
        ];
        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $student_class->study_class->id],
        ])->latest()->first();

        $competencies = CompetenceAchievement::where('status', 1)->get();
        $result_score = [];
        // dd($student_class);
        foreach ($subjects as $subject) {
            $score = ScoreMerdeka::where([
                ['id_student_class', $student_class->id],
                ['id_school_year', $school_year->id],
                ['type', $type_template],
                ['id_teacher', $subject->id_teacher],
            ])->get()->map(function ($item) {
                $item->id_study_class = json_decode($item->id_study_class);
                return $item;
            });
            // dd($score);
            $score_competencies = ScoreCompetency::where([
                ['id_student_class', $student_class->id],
                ['id_teacher', $subject->id_teacher],
                ['id_course', $subject->id_course],
                ['id_study_class', $student_class->id_study_class],
                ['id_school_year', $school_year->id],
            ])->get();

            $nilai = null;
            if (!$score->isEmpty()) {
                $nilai = collect($score)
                    ->firstWhere('id_teacher', $subject->id_teacher)
                    ->where('id_study_class', $student_class->id_study_class)
                    ->where('id_course', $subject->id_course)
                    ->where('type', $type_template)
                    ->where('id_school_year', intval($subject->id_school_year))->first();
            }

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
            // dd($nilai);

            $result_score[] = [
                'id_course' => $subject->id_course,
                'course' => $subject->course->name,
                'score' => empty($nilai) ? null : $nilai->final_score,
                'competence_archieved' => $competency_archieved ? $competency_archieved->toArray() : [],
                'competency_improved' => $competency_improved ? $competency_improved->toArray() : [],

            ];
        }
        // dd($result_score);
        $result_extra = [];

        $extras = Extracurricular::where('status', 1)->get();

        foreach ($extras as $extra) {
            $score_extra = ScoreExtracurricular::where([
                ['id_study_class', $student_class->id_study_class],
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
                    if ($data->id_student_class == $student_class->id) {
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
            ['id_student_class', $student_class->id],
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
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id]
        ])->first();
        $config = Config::where('id_school_year', $school_year->id)->first();
        // dd($config);
        $result_other = [
            'note_teacher' => $note ? $note->description : '',
            'promotion' => $note ? $note->promotion : 'Y',
            'place' => $config ? $config->place : '',
            'date' => $config ? $config->report_date : now(),
            'headmaster' => $config ? $config->headmaster : '',
            'nip_headmaster' => $config ? $config->nip_headmaster : '',
            'teacher' => $teacher ? $teacher->name : '',
            'nip_teacher' => $teacher ? $teacher->nip : '',
            'signature' => $config && $config['signature'] != null ? public_path($config->signature) : null,
        ];
        $pdf = PDF::loadView('content.previews.merdeka.v_print_pas', compact('result_score', 'result_extra', 'result_attendance', 'result_kop', 'result_profile', 'result_other', 'type_template', 'defaultTemplate'));
        return $pdf->stream();
    }

    function preview_manual($student_class, $setting, $school_year, $subjects, $type_template, $defaultTemplate)
    {

        if (empty($defaultTemplate)) {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }

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
        $result_profile = [
            'name' => strtoupper($student_class->student->name),
            'nisn' => $student_class->student->nisn,
            'school' => strtoupper($setting['name_school']),
            'address_school' => $setting['address'],
            'study_class' => $student_class->study_class->name,
            'fase' => $student_class->study_class->level->fase,
            'level' => $student_class->study_class->level->name,
            'major' => $student_class->study_class->major->name,
            'semester_number' => substr($school_year->name, -1),
            'semester' => substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap',
            'school_year' => substr($school_year->name, 0, 9),
        ];
        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $student_class->study_class->id],
        ])->latest()->first();
        // dd($teacher);

        $score_attitude = AttitudeGrade::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $result_attitude = [];

        foreach ($score_attitude as $score) {
            $type = $score['type'];
            $predicate = $score['predicate'];
            $attitude_ids = json_decode($score['attitudes']);

            $attitude_names = Attitude::whereIn('id', $attitude_ids)
                ->pluck('name')
                ->toArray();

            $attitude_data = [
                "type" => $type,
                "predicate" => $predicate,
                "attitudes" => $attitude_names
            ];

            array_push($result_attitude, $attitude_data);
        }

        $result_attitude = collect($result_attitude)->groupBy('type')->map(function ($item) {
            $first = $item->first();

            return [
                "type" => $first["type"],
                "predicate" => $first["predicate"],
                "attitudes" => $item->pluck('attitudes')->flatten()->toArray()
            ];
        })->toArray();

        $result_extra = [];

        $extras = Extracurricular::where('status', 1)->get();

        foreach ($extras as $extra) {
            $score_extra = ScoreExtracurricular::where([
                ['id_study_class', $student_class->id_study_class],
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
                    if ($data->id_student_class == $student_class->id) {
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

        $note = TeacherNote::where([
            ['id_student_class', $student_class->id],
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
            'teacher' => $teacher ? $teacher->name : '',
            'nip_teacher' => $teacher ? $teacher->nip : '',
            'signature' => $config && $config->signature != null ? public_path($config->signature) : null,
        ];

        $result_achievement = Achievement::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $attendance = AttendanceScore::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->first();

        $result_attendance = [
            'ill' => $attendance ? $attendance->ill : 0,
            'excused' => $attendance ? $attendance->excused : 0,
            'unexcused' => $attendance ? $attendance->unexcused : 0,
        ];

        $result_score = [];
        foreach ($subjects as $subject) {
            $score_manual = ScoreManual::where([
                ['id_student_class', $student_class->id],
                ['id_school_year', $school_year->id],
                ['id_teacher', $subject->id_teacher],
                ['id_course', $subject->id_course],
                ['type', $type_template]
            ])->first();

            $result_score[] = [
                'course' => $subject->course->name,
                'score' => $score_manual ? $score_manual->score_final : null,
                'predicate' => $score_manual ? $score_manual->predicate : null,
                'description' => $score_manual ? $score_manual->description : null,
            ];
        }
        // $pdf = PDF::loadView('content.previews.manual.v_print_pas', compact('result_profile', 'result_kop', 'result_attitude', 'result_extra', 'result_other', 'result_achievement', 'result_attendance'));
        $pdf = PDF::loadView('content.previews.manual.v_print_pas', compact('result_profile', 'result_kop', 'result_attitude', 'result_score', 'result_extra', 'result_other', 'result_achievement', 'result_attendance', 'type_template', 'defaultTemplate'));
        return $pdf->stream();
    }

    function preview_manual2($student_class, $setting, $school_year, $subjects, $defaultTemplate)
    {

        if (empty($defaultTemplate)) {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }

        // dd($subjects);
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
        $result_profile = [
            'name' => strtoupper($student_class->student->name),
            'nisn' => $student_class->student->nisn,
            'school' => strtoupper($setting['name_school']),
            'address_school' => $setting['address'],
            'study_class' => $student_class->study_class->name,
            'major' => $student_class->study_class->major->name,
            'fase' => $student_class->study_class->level->fase,
            'level' => $student_class->study_class->level->name,
            'semester_number' => substr($school_year->name, -1),
            'semester' => substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap',
            'school_year' => substr($school_year->name, 0, 9),
        ];

        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $student_class->study_class->id],
        ])->latest()->first();

        $score_attitude = AttitudeGrade::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $result_attitude = [];

        foreach ($score_attitude as $score) {
            $type = $score['type'];
            $predicate = $score['predicate'];
            $attitude_ids = json_decode($score['attitudes']);

            $attitude_names = Attitude::whereIn('id', $attitude_ids)
                ->pluck('name')
                ->toArray();

            $attitude_data = [
                "type" => $type,
                "predicate" => $predicate,
                "attitudes" => $attitude_names
            ];

            array_push($result_attitude, $attitude_data);
        }

        $result_attitude = collect($result_attitude)->groupBy('type')->map(function ($item) {
            $first = $item->first();

            return [
                "type" => $first["type"],
                "predicate" => $first["predicate"],
                "attitudes" => $item->pluck('attitudes')->flatten()->toArray()
            ];
        })->toArray();

        $result_extra = [];

        $extras = Extracurricular::where('status', 1)->get();

        foreach ($extras as $extra) {
            $score_extra = ScoreExtracurricular::where([
                ['id_study_class', $student_class->id_study_class],
                // ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_school_year', $school_year->id],
                ['id_extra', $extra->id],
            ])->first();


            if ($score_extra) {
                $id_extra = $extra->id;
                $name = $extra->name;
                $score = null;
                $description = null;

                $scoreData = json_decode($score_extra->score);
                foreach ($scoreData as $data) {
                    if ($data->id_student_class == $student_class->id) {
                        $score = $data->score;
                        $description = $data->description;
                        break;
                    }
                }

                if ($score !== null && $score !== '-') {
                    $result_extra[] = [
                        'id_extra' => $id_extra,
                        'name' => $name,
                        'score' => $score,
                        'description' => $description,
                    ];
                }
            }
        }

        $note = TeacherNote::where([
            ['id_student_class', $student_class->id],
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
            'teacher' => $teacher ? $teacher->name : '',
            'nip_teacher' => $teacher ? $teacher->nip : '',
            'signature' => $config && $config['signature'] != null ? public_path($config->signature) : null,
        ];
        // dd("hallo user");

        $result_achievement = Achievement::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $attendance = AttendanceScore::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->first();

        $result_attendance = [
            'ill' => $attendance ? $attendance->ill : 0,
            'excused' => $attendance ? $attendance->excused : 0,
            'unexcused' => $attendance ? $attendance->unexcused : 0,
        ];

        $result_score = [];
        foreach ($subjects as $subject) {
            $score_manual2 = ScoreManual2::where([
                ['id_student_class', $student_class->id],
                ['id_school_year', $school_year->id],
                ['id_teacher', $subject->id_teacher],
                ['id_course', $subject->id_course]
            ])->first();

            $result_score[$subject->course->group][] = [
                'course' => $subject->course->name,
                'final_assegment' => $score_manual2 ? $score_manual2->final_assegment : null,
                'final_skill' => $score_manual2 ? $score_manual2->final_skill : null,
                'predicate_assegment' => $score_manual2 ? $score_manual2->predicate_assegment : null,
                'predicate_skill' => $score_manual2 ? $score_manual2->predicate_skill : null,
                'kkm' => $score_manual2 ? $score_manual2->kkm : null,
            ];

            usort($result_score[$subject->course->group], function ($a, $b) {
                $aParts = explode(' ', $a['course']);
                $bParts = explode(' ', $b['course']);

                $aNumber = $aParts[0];
                $bNumber = $bParts[0];

                $aNumberParts = explode('.', $aNumber);
                $bNumberParts = explode('.', $bNumber);

                $aMainNumber = intval($aNumberParts[0]);
                $bMainNumber = intval($bNumberParts[0]);

                if ($aMainNumber === $bMainNumber) {
                    $aSubNumber = isset($aNumberParts[1]) ? intval($aNumberParts[1]) : 0;
                    $bSubNumber = isset($bNumberParts[1]) ? intval($bNumberParts[1]) : 0;

                    if ($aSubNumber === $bSubNumber) {
                        return strnatcasecmp($a['course'], $b['course']);
                    } else {
                        return $aSubNumber - $bSubNumber;
                    }
                } else {
                    return $aMainNumber - $bMainNumber;
                }
            });
        }
        // dd($result_score);

        $pdf = PDF::loadView('content.previews.manual2.v_print_pas', compact('result_profile', 'result_kop', 'result_attitude', 'result_score', 'result_extra', 'result_other', 'result_achievement', 'result_attendance', 'defaultTemplate'));
        return $pdf->stream();
    }

    function preview_k13($student_class, $setting, $school_year, $subjects, $type_template, $defaultTemplate)
    {

        if (empty($defaultTemplate)) {
            session()->put('message', 'Admin belum mengaktifkan template raport');
            return view('pages.v_error');
        }

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
        $result_profile = [
            'name' => strtoupper($student_class->student->name),
            'nisn' => $student_class->student->nisn,
            'school' => strtoupper($setting['name_school']),
            'address_school' => $setting['address'],
            'study_class' => $student_class->study_class->name,
            'fase' => $student_class->study_class->level->fase,
            'level' => $student_class->study_class->level->name,
            'major' => $student_class->study_class->major->name,
            'semester_number' => substr($school_year->name, -1),
            'semester' => substr($school_year->name, -1) == 1 ? 'Ganjil' : 'Genap',
            'school_year' => substr($school_year->name, 0, 9),
        ];

        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $student_class->study_class->id],
        ])->latest()->first();

        $score_attitude = AttitudeGrade::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $result_attitude = [];

        foreach ($score_attitude as $score) {
            $type = $score['type'];
            $predicate = $score['predicate'];
            $attitude_ids = json_decode($score['attitudes']);

            $attitude_names = Attitude::whereIn('id', $attitude_ids)
                ->pluck('name')
                ->toArray();

            $attitude_data = [
                "type" => $type,
                "predicate" => $predicate,
                "attitudes" => $attitude_names
            ];

            array_push($result_attitude, $attitude_data);
        }

        $result_attitude = collect($result_attitude)->groupBy('type')->map(function ($item) {
            $first = $item->first();

            return [
                "type" => $first["type"],
                "predicate" => $first["predicate"],
                "attitudes" => $item->pluck('attitudes')->flatten()->toArray()
            ];
        })->toArray();

        $score_kd = ScoreKd::where([
            ['id_student_class', $student_class->id],
            ['type', $type_template],
            ['id_school_year', $school_year->id],
        ])->get();
        $result_score = [];


        foreach ($subjects as $subject) {
            $score_kd = ScoreKd::where([
                ['id_student_class', $student_class->id],
                ['id_school_year', $school_year->id],
                ['id_subject_teacher', $subject->id],
                ['type', $type_template],
            ])->first();

            if ($score_kd) {
                $course = $subject->course->name;
                $final_assessment = $score_kd->final_assesment;
                $final_skill = $score_kd->final_skill;

                // Konversi assessment_score dan skill_score dari JSON menjadi array
                $assessment_score = json_decode($score_kd->assessment_score, true);
                $skill_score = json_decode($score_kd->skill_score, true);

                // Ambil id_kd dari assessment_score dan skill_score
                $kd_assessment_ids = collect($assessment_score)->pluck('id_kd')->toArray();
                $kd_skill_ids = collect($skill_score)->pluck('id_kd')->toArray();

                // Ambil nama kd dari id_kd
                $kd_assessment = BasicCompetency::whereIn('id', $kd_assessment_ids)->pluck('name')->toArray();
                $kd_assessment = array_map(function ($value) {
                    return json_decode($value)->name;
                }, $kd_assessment);
                $kd_skill = BasicCompetency::whereIn('id', $kd_skill_ids)->pluck('name')->toArray();
                $kd_skill = array_map(function ($value) {
                    return json_decode($value)->name;
                }, $kd_skill);

                // Cari predikat dari nilai final_assessment dan final_skill
                $predicate_score = PredicatedScore::where('score', '<=', $final_assessment)->orderBy('score', 'desc')->first();
                if ($predicate_score == null) {
                    session()->put('message', 'Harap admin suruh mengisi dulu nilai predikat raport');
                    return view('pages.v_error');
                }
                $predicate_assessment = PredicatedScore::where('score', '<=', $final_assessment)->orderBy('score', 'desc')->first()->name;
                $description_assessment = PredicatedScore::where('score', '<=', $final_assessment)->orderBy('score', 'desc')->first()->description;
                $predicate_skill = PredicatedScore::where('score', '<=', $final_skill)->orderBy('score', 'desc')->first()->name;
                $description_skill = PredicatedScore::where('score', '<=', $final_skill)->orderBy('score', 'desc')->first()->description;

                $result_score[] = [
                    'course' => $course,
                    'final_assessment' => $final_assessment,
                    'predicate_assessment' => $predicate_assessment,
                    'description_assessment' => $description_assessment,
                    'kd_assessment' => $kd_assessment,
                    'final_skill' => $final_skill,
                    'predicate_skill' => $predicate_skill,
                    'description_skill' => $description_skill,
                    'kd_skill' => $kd_skill,
                ];
            } else {
                $result_score[] = [
                    'course' => $subject->course->name,
                    'final_assessment' => null,
                    'predicate_assessment' => null,
                    'description_assessment' => null,
                    'kd_assessment' => [],
                    'final_skill' => null,
                    'predicate_skill' => null,
                    'description_skill' => null,
                    'kd_skill' => [],
                ];
            }
        }

        $result_extra = [];

        $extras = Extracurricular::where('status', 1)->get();

        foreach ($extras as $extra) {
            $score_extra = ScoreExtracurricular::where([
                ['id_study_class', $student_class->id_study_class],
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
                    if ($data->id_student_class == $student_class->id) {
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

        $note = TeacherNote::where([
            ['id_student_class', $student_class->id],
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
            'teacher' => $teacher ? $teacher->name : '',
            'nip_teacher' => $teacher ? $teacher->nip : '',
            'nip_headmaster' => $config ? $config->nip_headmaster : '',
            'signature' => $config && $config->signature != null ? public_path($config->signature) : null,
        ];

        $result_achievement = Achievement::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->get();

        $attendance = AttendanceScore::where([
            ['id_student_class', $student_class->id],
            ['id_school_year', $school_year->id],
        ])->first();

        $result_attendance = [
            'ill' => $attendance ? $attendance->ill : 0,
            'excused' => $attendance ? $attendance->excused : 0,
            'unexcused' => $attendance ? $attendance->unexcused : 0,
        ];
        // dd($result_achievement);

        $pdf = PDF::loadView('content.previews.k13.v_print_pas', compact('result_profile', 'result_kop', 'result_attitude', 'result_score', 'result_extra', 'result_other', 'result_achievement', 'result_attendance', 'type_template', 'defaultTemplate'));
        return $pdf->stream();
    }
}