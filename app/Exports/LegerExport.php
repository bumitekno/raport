<?php

namespace App\Exports;

use App\Models\AttendanceScore;
use App\Models\AttitudeGrade;
use App\Models\ScoreExtracurricular;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreManual2;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;

class LegerExport implements FromView
{

    protected $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function view(): View
    {
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $this->slug)->first();
        $setting['study_class'] = $study_class->name;
        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $study_class->id],
        ])->first();
        $setting['teacher'] = $teacher ? $teacher->name : '-';
        $student_class = StudentClass::join('users as us', 'us.id', '=', 'student_classes.id_student')
            ->where('student_classes.year', session('year'))
            ->where('student_classes.status', 1)
            ->where('student_classes.id_study_class', $study_class->id)
            ->orderBy('us.nis', 'ASC')
            ->select('student_classes.id', 'us.nis','us.nisn','us.address','us.name','us.id as id_student')
            ->get();
        
        $student_class_id = $student_class->pluck('id');
        //dd($student_class_id);

        $attitude = AttitudeGrade::join('student_classes','student_classes.id','attitude_grades.id_student_class')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->where('study_classes.id',$study_class->id)
        ->where('student_classes.year',session('year'))
        ->select('student_classes.id_student','attitude_grades.type','attitude_grades.predicate')
        ->get();
        $attitude = collect($attitude)->groupBy('id_student')->toArray();
        //dd($attitude);

        // Kedatangan (absensi) dan keterangan catatan guru ( naik/tdk dan catatan)
        $attendance = AttendanceScore::join('student_classes','student_classes.id','attendance_scores.id_student_class')
        ->join('teacher_notes','teacher_notes.id_student_class','student_classes.id')
        ->select('attendance_scores.ill','attendance_scores.excused','attendance_scores.unexcused',
        'student_classes.id_student','attendance_scores.id_student_class',
        'teacher_notes.promotion','teacher_notes.description')
        ->whereIn('attendance_scores.id_student_class',$student_class_id)
        ->get();
        $attendance = collect($attendance)->groupBy('id_student')->toArray();
        //dd($attendance);

        $extras = ScoreExtracurricular::where('id_study_class',$study_class->id)
        ->get();

        $subject_teachers = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $study_class->id . '"]\')')
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->select('subject_teachers.id', 'c.name', 'subject_teachers.id_course', 'subject_teachers.id_teacher')
            ->get();
        //dd($subject_teachers);
        $code_course = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->leftJoin('kkms', function ($join) use ($study_class) {
                $join->on('kkms.id_school_year', '=', 'subject_teachers.id_school_year')
                    ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
                    ->on('kkms.id_course', '=', 'subject_teachers.id_course');
            })
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
            ->select('subject_teachers.id', 'c.code as code','c.group as group', DB::raw('MAX(kkms.score) as score'))
            ->orderBy('c.group','ASC')
            ->groupBy('subject_teachers.id', 'c.code','c.group')
            ->get()
            ->toArray();
        
        $group_course = collect($code_course)->groupBy('group');
        $group_course = $group_course->map(function ($products, $category) {
            return [
                'category' => $category,
                'count' => $products->count(),
            ];
        });

        $id_subject_teacher = collect($subject_teachers)->pluck('id');

        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')],
        ])->first();
        
        if($template['template'] != 'k13'){
            session()->put('message', 'Fitur ini hanya untuk kelas yang menggunakan kurikulum 13');
           return view('pages.v_error');
        }

        $scores = [];  
        
        //dd($subject_teachers);

        if ($template['template'] == 'merdeka') {
            // dd($subject_teachers->pluck('id_course')->unique()->toArray());
            $scores = ScoreMerdeka::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } else if ($template['template'] == 'k13') {
            $scores = ScoreKd::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_subject_teacher', $subject_teachers->pluck('id')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } else if ($template['template'] == 'manual') {
            $scores = ScoreManual::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } elseif ($template['template'] == 'manual2') {
            $scores = ScoreManual2::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                ->get();
        }

        //dd($scores);
        
        $arr_student_class = [];
        foreach ($student_class as $student) {
            $arr_student_class[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'address' => $student->address,
                'score' => $subject_teachers,
                'sikap' => array_key_exists($student->id_student, $attitude) ? $attitude[$student->id_student] : [],
                'absensi' => array_key_exists($student->id_student, $attendance) ? $attendance[$student->id_student] : []
            ];
        }
        //dd($arr_student_class);

        $nilai_map = collect($arr_student_class)->map(function ($a) {
            return (array) $a;
        })->toArray();

        //dd($nilai_map);
        
        foreach ($nilai_map as $nmv => $nmmv) {
            if ($template['template'] == 'k13') {
                $scoresFiltered = collect($scores)->whereIn('id_subject_teacher', collect($nmmv['score'])->pluck('id')->unique())
                    ->where('id_student_class', $nmmv['id'])
                    ->where('id_school_year', session('id_school_year'));
            } else {
                $scoresFiltered = collect($scores)->where('id_student_class', $nmmv['id'])
                    ->where('id_school_year', session('id_school_year'));

                if (!empty($nmmv['score'])) {
                    $scoresFiltered = $scoresFiltered->whereIn('id_course', collect($nmmv['score'])->pluck('id_course')->unique())
                        ->whereIn('id_teacher', collect($nmmv['score'])->pluck('id_teacher')->unique());
                }

                //dd($scoresFiltered);
            }
            
            $arr = [];
            $jml_score = 0;
            $jml_keterampilan = 0;
            foreach($nmmv['score'] as $nll){
                if ($template['template'] == 'k13') {
                    $raport_ = $scoresFiltered->where('id_subject_teacher', $nll->id)->first();
                    $pengetahuan = $raport_ ? $raport_['final_assesment'] : 0;
                    $keterampilan = $raport_ ? $raport_['final_skill'] : 0;
                    $uts = $raport_ ? $raport_['score_uts'] : 0;
                    $uas = $raport_ ? $raport_['score_uas'] : 0;

                    //Akumulasi
                    $jml_score = $jml_score + $pengetahuan;
                    $jml_keterampilan = $jml_keterampilan + $keterampilan;
                } else {
                    $raport_ = $scoresFiltered->where('id_course', $nll->id_course)
                        ->where('id_teacher', $nll->id_teacher)
                        ->first();
                    if ($template['template'] == 'manual2') {
                        $final_score = $raport_ ? ['assigment' => $raport_['final_assegment'], 'skill' => $raport_['final_skill']] : ['assigment' => null, 'skill' => null];
                    } else {
                        $final_score = $raport_ ? ($template['template'] == 'merdeka' ? $raport_['final_score'] : $raport_['score_final']) : [];
                    }
                }
                $arr[] = [
                    'id' => $nll->id,
                    'name' => $nll->name,
                    'score' => $pengetahuan,
                    'keterampilan' => $keterampilan,
                    'uts' => $uts,
                    'uas' => $uas
                ];
            }
            
            $nilai_map[$nmv]['score'] = $arr;
            $nilai_map[$nmv]['jml_score'] = $jml_score;
            $nilai_map[$nmv]['jml_keterampilan'] = $jml_keterampilan;
            $nilai_map[$nmv]['jml_nilai'] = $jml_keterampilan + $jml_score;
        }

        unset($nmv);
        //array_multisort(array_column($nilai_map, 'jml_nilai'), SORT_DESC, $nilai_map);

        
        $results = array(
            'score' => $nilai_map,
            'course' => $code_course,
            'setting' => $setting
        );
        
        
        
        return view('content.leger_new.v_print_leger', compact('results','group_course'));
        
    }
}
