<?php

namespace App\Http\Controllers;

use App\Models\Kkm;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LegerController extends Controller
{
    //
    public function byClass($slug)
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

        $subject_teachers = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $study_class->id . '"]\')')
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->select('subject_teachers.id', 'c.name', 'subject_teachers.id_course', 'subject_teachers.id_teacher')
            ->get();
        // dd($subject_teachers);

        $code_course = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->leftJoin('kkms', function ($join) use ($study_class) {
                $join->on('kkms.id_school_year', '=', 'subject_teachers.id_school_year')
                    ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
                    ->on('kkms.id_course', '=', 'subject_teachers.id_course');
            })
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
            ->select('subject_teachers.id', 'c.code as code', 'kkms.score')
            ->get()
            ->toArray();

        // dd($template);

        $id_subject_teacher = collect($subject_teachers)->pluck('id');

        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')],
        ])->first();

        $scores = [];

        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')],
        ])->first();
        // dd($template);

        if ($template['template'] == 'merdeka') {
            // dd($subject_teachers->pluck('id_course')->unique()->toArray());
            $scores = ScoreMerdeka::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                ->get();
        } else if ($template['template'] == 'k13') {
            $scores = ScoreKd::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_subject_teacher', $subject_teachers->pluck('id')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                ->get();
        } else if ($template['template'] == 'manual') {
            $scores = ScoreManual::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                ->get();
        }
        // dd($scores);


        foreach ($student_class as $student) {
            $arr_student_class[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'score' => $subject_teachers,
            ];
        }

        $nilai_map = collect($arr_student_class)->map(function ($a) {
            return (array) $a;
        })->toArray();
        // dd($nilai_map);

        foreach ($nilai_map as &$nmv) {
            if ($template['template'] == 'k13') {
                $scoresFiltered = collect($scores)->whereIn('id_subject_teacher', collect($nmv['score'])->pluck('id')->unique())
                    ->where('id_student_class', $nmv['id'])
                    ->where('id_school_year', session('id_school_year'));
            } else {
                $scoresFiltered = collect($scores)->where('id_student_class', $nmv['id'])
                    ->where('id_school_year', session('id_school_year'));

                if (!empty($nmv['score'])) {
                    $scoresFiltered = $scoresFiltered->whereIn('id_course', collect($nmv['score'])->pluck('id_course')->unique())
                        ->whereIn('id_teacher', collect($nmv['score'])->pluck('id_teacher')->unique());
                }
            }

            $nmv['score'] = collect($nmv['score'])->map(function ($nmn) use ($template, $scoresFiltered) {
                if ($template['template'] == 'k13') {
                    $raport_ = $scoresFiltered->where('id_subject_teacher', $nmn->id)->first();
                    $final_score = $raport_ ? $raport_['final_assesment'] : [];
                } else {
                    $raport_ = $scoresFiltered->where('id_course', $nmn['id_course'])
                        ->where('id_teacher', $nmn['id_teacher'])
                        ->first();
                    $final_score = $raport_ ? ($template['template'] == 'merdeka' ? $raport_['final_score'] : $raport_['score_final']) : [];
                }

                return [
                    'id' => $nmn['id'],
                    'name' => $nmn['name'],
                    'score' => $final_score,
                ];
            })->toArray();
        }

        unset($nmv);

        $results = array(
            'score' => $nilai_map,
            'course' => $code_course,
            'setting' => $setting
        );
        // dd($results);
        return view('content.legers.v_list_leger', compact('results'));
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
}
