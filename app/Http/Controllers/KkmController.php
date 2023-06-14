<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SettingScore\KkmRequest;
use App\Http\Resources\Master\SchoolYearResource;
use App\Models\Kkm;
use App\Models\SchoolYear;
use App\Models\ScoreManual2;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class KkmController extends Controller
{
    public function index()
    {
        // dd('kkm');
        session()->put('title', 'Kelola KKM');
        $school_years = SchoolYear::all();
        $classes = StudyClass::all();
        $name_class = 'Belum memilih kelas';
        $result = [];
        if (isset($_GET['class'])) {
            $school_year = SchoolYear::where('slug', $_GET['year'])->first();
            $study_class = StudyClass::where('slug', $_GET['class'])->first();
            $name_class = $study_class->name;
            $subject_teachers =  SubjectTeacher::with('teacher', 'course')
                ->where('id_school_year', $school_year->id)
                ->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $study_class->id . '"]\')')
                ->where('status', 1)
                ->get();

            $kkm = DB::table('kkms')
                ->where('id_study_class', $study_class->id)
                ->where('id_school_year', $school_year->id)
                ->get();

            $result = [];
            foreach ($subject_teachers as $data) {
                $found = $kkm->first(function ($item) use ($data) {
                    return $item->id_course == $data->id_course
                        && $item->id_school_year == $data->id_school_year;
                });

                $score = $found ? $found->score : null;
                $result[$data->id_course] = [
                    'course' => $data->course->name,
                    'teacher' => $data->teacher->name,
                    'score' => $score,
                    'id_course' => $data->id_course,
                    'id_study_class' => $study_class->id,
                    'id_school_year' => $data->id_school_year,
                    'school_year' => substr($school_year->name, 0, 9),
                ];
            }
            // Konversi hasil loop menjadi array asosiatif dengan kunci id_course
            $result = array_values($result);
        }
        // dd($result);
        return view('content.setting_scores.v_kkm', compact('school_years', 'classes', 'result', 'name_class'));
    }

    public function storeOrUpdate(KkmRequest $request)
    {
        // dd($request);
        $data = $request->validated();

        foreach ($data['id_school_year'] as $index => $idSchoolYear) {
            $kkm = Kkm::updateOrCreate(
                [
                    'id_school_year' => $idSchoolYear,
                    'id_course' => $data['id_course'][$index],
                    'id_study_class' => $data['id_study_class'][$index]
                ],
                [
                    'score' => $data['score'][$index],
                ]
            );

            ScoreManual2::where('id_school_year', $idSchoolYear)
                ->where('id_course', $data['id_course'][$index])
                ->where('id_study_class', $data['id_study_class'][$index])
                ->update(['kkm' => $data['score'][$index]]);

            Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        }

        return redirect()->back();
    }
}
