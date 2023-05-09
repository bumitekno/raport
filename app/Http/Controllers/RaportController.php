<?php

namespace App\Http\Controllers;

use App\Http\Resources\Master\SchoolYearResource;
use App\Models\SchoolYear;
use App\Models\StudentClass;
use App\Models\StudyClass;
use Illuminate\Http\Request;

class RaportController extends Controller
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

        return view('content.raports.v_list_raport', compact('results'));
    }

    public function byClass()
    {
        session()->put('title', 'Print Raport');
        $years = SchoolYear::all();
        $school_years = SchoolYearResource::collection($years)->toArray(request());

        $study_class = StudyClass::where([
            ['slug', $_GET['study_class']],
            ['status', 1],
        ])->first();
        $school_year = SchoolYear::where('slug', $_GET['year'])->first();
        $student_class = StudentClass::join('users as us', 'us.id', '=', 'student_classes.id_student')
            ->where('student_classes.year', substr($school_year->name, 0, 4))
            ->where('student_classes.status', 1)
            ->where('student_classes.id_study_class', $study_class->id)
            ->orderBy('us.nis', 'ASC')
            ->select('student_classes.id', 'us.nis', 'us.name', 'student_classes.slug')
            ->get();
        return view('content.raports.v_list_student', compact('student_class', 'school_years'));
        // dd($student_class);
    }
}
