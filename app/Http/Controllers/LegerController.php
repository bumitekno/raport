<?php

namespace App\Http\Controllers;

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
        // dd($template);

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

        // foreach ($nilai_map as $nmv) {
        //     if ($template['template'] == 'k13') {
        //         $scoresFiltered = collect($scores)->whereIn('id_subject_teacher', collect($nmv['score'])->pluck('id')->unique())
        //             ->where('id_student_class', $nmv['id'])
        //             ->where('id_school_year', session('id_school_year'));
        //     } else {
        //         $scoresFiltered = collect($scores)->where('id_student_class', $nmv['id'])
        //             ->where('id_school_year', session('id_school_year'));

        //         if (!empty($nmv['score'])) {
        //             $scoresFiltered = $scoresFiltered->whereIn('id_course', collect($nmv['score'])->pluck('id_course')->unique())
        //                 ->whereIn('id_teacher', collect($nmv['score'])->pluck('id_teacher')->unique());
        //         }

        //         // dd($scoresFiltered);
        //     }

        //     $nmv['score'] = collect($nmv['score'])->map(function ($nmn) use ($template, $scoresFiltered) {
        //         if ($template['template'] == 'k13') {
        //             $raport_ = $scoresFiltered->where('id_subject_teacher', $nmn->id)->first();
        //             $final_score = $raport_ ? $raport_['final_assesment'] : [];
        //         } else {
        //             $raport_ = $scoresFiltered->where('id_course', $nmn['id_course'])
        //                 ->where('id_teacher', $nmn['id_teacher'])
        //                 ->first();
        //             if ($template['template'] == 'manual2') {
        //                 $final_score = $raport_ ? ['assigment' => $raport_['final_assegment'], 'skill' => $raport_['final_skill']] : ['assigment' => null, 'skill' => null];
        //             } else {
        //                 $final_score = $raport_ ? ($template['template'] == 'merdeka' ? $raport_['final_score'] : $raport_['score_final']) : [];
        //             }
        //         }

        //         return [
        //             'id' => $nmn['id'],
        //             'name' => $nmn['name'],
        //             'score' => $final_score,
        //         ];
        //     })->toArray();
            
        //     // dd($nmv['score']);
        // }
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

                // dd($scoresFiltered);
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
        // dd($result);
        return view('content.legers.v_list_classes', compact('results'));
    }

    public function allLeger($slug){
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $slug)->first();
        $setting['study_class'] = $study_class->name;
        //dd($study_class);

        // Dapatkan siswa pada kelas tsb
        $siswa = DB::table('student_classes')
        ->where('id_study_class',$study_class->id)
        ->pluck('id_student');
        //dd($siswa);

        // $kelas_siswa = DB::table('student_classes')
        // ->join('score_merdekas','score_merdekas.id_study_class','student_classes.id')
        // ->select(['score_merdekas.id_student_class','score_merdekas.final_score',
        // 'student_classes.id_study_class'])
        // ->whereIn('student_classes.id_student',$siswa)
        // ->get();

        $kelas_siswa = DB::table('student_classes')
        ->whereIn('student_classes.id_student',$siswa)
        ->pluck('id');
        dd($kelas_siswa);

        // $student_class = DB::table('student_classes')
        // ->join('study_classes','study_classes.id','student_classes.id_study_class')
        // ->join('score_merdekas','score_merdekas.id_study_class','student_classes.id')
        // ->select(['score_merdekas.id_student_class','study_classes.name',
        // 'study_classes.id_major','student_classes.id_student',
        // 'score_merdekas.final_score','score_merdekas.id_course'])
        // ->whereIn('student_classes.id_student',$siswa)
        // ->get();

        $student_class = DB::table('score_merdekas')
        ->join('study_classes','study_classes.id','score_merdekas.id_study_class')
        //->select(['study_classes.name'])
        ->whereIn('score_merdekas.id_study_class',$kelas_siswa)
        ->get();

        dd($student_class);


        $score = ScoreMerdeka::where('id_study_class', $study_class->id)
        ->select(['courses.name','id_course','final_score','id_school_year',
        'id_study_class','id_student_class'
        ])
        ->join('courses','courses.id','score_merdekas.id_course')
        ->get();

        dd($score);
        
        //Data siswa
        $user = '';
    }
}
