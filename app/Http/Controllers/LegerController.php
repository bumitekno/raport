<?php

namespace App\Http\Controllers;

use App\Exports\AllLeger;
use App\Models\Kkm;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreManual2;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LegerController extends Controller
{
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
            ->where('student_classes.year', session('year'))
            ->where('student_classes.status', 1)
            ->where('student_classes.id_study_class', $study_class->id)
            ->orderBy('us.nis', 'ASC')
            ->select('student_classes.id', 'us.nis', 'us.name')
            ->get();
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
        //dd($template);

        $scores = [];

        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')],
        ])->first();

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
        // dd(collect($subject_teachers->pluck('id_course')->unique()->toArray()));
        $arr_student_class = [];
        foreach ($student_class as $student) {
            $arr_student_class[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'score' => $subject_teachers,
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
            foreach($nmmv['score'] as $nll){
                if ($template['template'] == 'k13') {
                    $raport_ = $scoresFiltered->where('id_subject_teacher', $nll->id)->first();
                    $final_score = $raport_ ? $raport_['final_assesment'] : [];
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
                    'score' => $final_score,
                    ];
            }
            $nilai_map[$nmv]['score'] = $arr;
        }

        //dd($nilai_map);
        unset($nmv);
        
        $results = array(
            'score' => $nilai_map,
            'course' => $code_course,
            'setting' => $setting
        );
        //dd($results['score']);
        if ($request->pdf) {
            if ($template['template'] == 'manual2') {
                $pdf = PDF::loadView('content.legers.v_print_leger_skill', compact('results'));
            } else {
                $pdf = PDF::loadView('content.legers.v_print_leger', compact('results'));
            }
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream();
        }
        //dd($results);
        if ($template['template'] == 'manual2') {
            return view('content.legers.v_list_leger_skill', compact('results', 'slug'));
        } else {
            return view('content.legers.v_list_leger', compact('results', 'slug'));
        }
    }

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
        return view('content.legers.v_list_classes', compact('results'));
    }

    public function allLeger(Request $request,$slug){

        return Excel::download(new AllLeger($slug), 'allleger.xlsx');

        // $setting = json_decode(Storage::get('settings.json'), true);
        // $study_class = StudyClass::where('slug', $slug)->first();
        // $setting['study_class'] = $study_class->name;
        // $setting['teacher'] = '';
        // //dd($study_class);

        // // Dapatkan siswa pada kelas tsb
        // $siswa = DB::table('student_classes')
        // ->where('id_study_class',$study_class->id)
        // ->pluck('id_student');
 
        // $student_class = DB::table('student_classes')
        // ->join('study_classes','study_classes.id','student_classes.id_study_class')
        // ->whereIn('student_classes.id_student',$siswa)
        // ->pluck('student_classes.id');

        // $score_merdeka = DB::table('users as u')
        // ->select('sm.id','y.name as semester','c.name as mapel',
        // 'u.name as siswa','u.nis','u.id as id_student',
        // 'sc.year','sm.final_score')
        
        // ->crossJoin('courses as c')
        // ->join('student_classes as sc','sc.id_student','u.id')
        // ->leftJoin('score_merdekas as sm', function($join){
        //     $join->on('sm.id_student_class','sc.id')
        //     ->on('sm.id_course','c.id');
        // })
        // ->join('school_years as y','y.id','sm.id_school_year')
        // //->where('sc.id_study_class',$study_class->id)
        // ->whereIn('u.id', function($query) use ($study_class) {
        //     $query->select('id_student')
        //             ->from('student_classes')
        //             ->where('id_study_class', $study_class->id);
        // })
        // ->orderBy('u.name','asc')
        // ->orderBy('c.name','asc')
        // //->orderBy('c.name','asc')
        // ->get();

        // //dd($score_merdeka);

        // $score_merdeka = collect($score_merdeka);
        // $semester = $score_merdeka->pluck('semester')->unique()->values();
        // $mapel = $score_merdeka->pluck('mapel')->unique();
        // $siswas = $score_merdeka->pluck('siswa')->unique();

        // $score_merdeka = $score_merdeka->groupBy('siswa')->map(function ($group) {
        //     return $group->groupBy('mapel');
        // });

        // //dd($mapel);

     
        // // $score_merdeka = collect($score_merdeka)->map(function ($a) {
        // //     return (array) $a;
        // // })->toArray();

        

        // //dd($mapel);


        // //Coba
        // // Original array
        // // Array data awal
        // $data = [
        //     [
        //         "id" => 1,
        //         "semester" => "2023/20241",
        //         "siswa" => "Alfa",
        //         "nis" => 123,
        //         "mapel" => "Tajwid",
        //         "final_score" => 80
        //     ],
        //     [
        //         "id" => 5,
        //         "semester" => "2023/20242",
        //         "siswa" => "Alfa",
        //         "nis" => 123,
        //         "mapel" => "Tajwid",
        //         "final_score" => 70
        //     ],
        //     [
        //         "id" => 6,
        //         "semester" => "2023/20241",
        //         "siswa" => "feri",
        //         "nis" => 1234,
        //         "mapel" => "Tajwid",
        //         "final_score" => 80
        //     ]
        // ];

        // // Inisialisasi array baru
        // $dataBaru = [];
        // $dataBaru = $score_merdeka;

        // //dd($dataBaru);
        // //dd($dataBaru['Abdul Aziz Sumanto']);

    
        // $results = array(
        //     'setting' => $setting
        // );

        // if ($request->pdf) {
           
        //     $pdf = PDF::loadView('content.legers.v_print_all_leger', compact('mapel','semester',
        //     'results','dataBaru'));
           
        //     $pdf->setPaper('A4', 'landscape');
        //     return $pdf->stream();
        // }
        //dd($semester);

        return view('content.legers.v_print_all_leger', compact('mapel','semester',
        'results','dataBaru'));
        
       
    }
}
