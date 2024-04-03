<?php

namespace App\Http\Controllers;

use App\Exports\DknExport;
use App\Models\AttitudeGrade;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreManual2;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use PDF;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class DKNController extends Controller
{
    public function listClass()
    {
        session()->put('title', 'Daftar Kelas');
        $classes = StudyClass::where('status', 1)->get();

        $results = [];
        foreach ($classes as $class) {
            $major = $class->major;
            $level = $class->level;
            $studentCount = StudentClass::where('id_study_class', $class->id)
                ->where([
                    ['status', 1],
                    ['year', session('year')]
                ])->count();

            $results[] = [
                'slug' => $class->slug,
                'name' => $class->name,
                'major' => $major ? $major->name : '',
                'level' => $level ? $level->name : '',
                'amount' => $studentCount
            ];
        }
        //dd($results);
        return view('content.dkns.v_list_classes', compact('results'));
    }

    public function byClass(Request $request, $slug)
    {
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $slug)->first();
        $setting['study_class'] = $study_class->name;
        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $study_class->id],
        ])->first();
        $setting['teacher'] = $teacher ? $teacher->name : '-';
        $student_class = StudentClass::join('users as us', 'us.id', '=', 'student_classes.id_student')
            // ->join('attitude_grades','attitude_grades.id_student_class','student_classes.id')
            ->where('student_classes.year', session('year'))
            ->where('student_classes.status', 1)
            ->where('student_classes.id_study_class', $study_class->id)
            ->orderBy('us.nis', 'ASC')
            ->select('student_classes.id', 'us.nis', 'us.name','us.id as id_student')
            ->get();
        //dd($student_class);

        $attitude = AttitudeGrade::join('student_classes','student_classes.id','attitude_grades.id_student_class')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->where('study_classes.id',$study_class->id)
        ->where('student_classes.year',session('year'))
        ->select('student_classes.id_student','attitude_grades.type','attitude_grades.predicate')
        ->get();
        $attitude = collect($attitude)->groupBy('id_student')->toArray();
        //dd($attitude);


        //dd($student_class);
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
            ->select('subject_teachers.id', 'c.code as code', DB::raw('MAX(kkms.score) as score'))
            ->groupBy('subject_teachers.id', 'c.code')
            ->get()
            ->toArray();

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

        //dd($student_class);
        
        $arr_student_class = [];
        foreach ($student_class as $student) {
            $arr_student_class[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'score' => $subject_teachers,
                'sikap' => array_key_exists($student->id_student, $attitude) ? $attitude[$student->id_student] : []
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

            }
            //dd($scoresFiltered);
            
            $arr = [];
            $jml_score = 0;
            $jml_keterampilan = 0;
            foreach($nmmv['score'] as $nll){
                if ($template['template'] == 'k13') {
                    $raport_ = $scoresFiltered->where('id_subject_teacher', $nll->id)->first();
                    $pengetahuan = $raport_ ? $raport_['final_assesment'] : 0;
                    $keterampilan = $raport_ ? $raport_['final_skill'] : 0;

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
                ];
            }

            $nilai_map[$nmv]['score'] = $arr;
            $nilai_map[$nmv]['jml_score'] = $jml_score;
            $nilai_map[$nmv]['jml_keterampilan'] = $jml_keterampilan;
            $nilai_map[$nmv]['jml_nilai'] = $jml_keterampilan + $jml_score;
        }

        //dd($nilai_map);
        unset($nmv);

        array_multisort(array_column($nilai_map, 'jml_nilai'), SORT_DESC, $nilai_map);

        
        $results = array(
            'score' => $nilai_map,
            'course' => $code_course,
            'setting' => $setting
        );
        
        if ($request->pdf) {
            return Excel::download(new DknExport($slug), 'invoices.xlsx');
        }
        //dd($results);
        if ($template['template'] == 'manual2') {
            return view('content.dkns.v_list_leger_skill', compact('results', 'slug'));
        } else {
            return view('content.dkns.v_list_leger', compact('results', 'slug'));
        }
    }

}
