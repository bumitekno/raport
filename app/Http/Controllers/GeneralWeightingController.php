<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Setting\GeneralWeightRequest;
use App\Models\GeneralWeighting;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GeneralWeightingController extends Controller
{
    public function index($type)
    {
        session()->put('title', 'Bobot Nilai ' . $type);
        $subjectTeachers = SubjectTeacher::where('status', 1)->get(['id_study_class']);

        $idStudyClasses = collect([]);

        foreach ($subjectTeachers as $subjectTeacher) {
            $idStudyClasses = $idStudyClasses->merge(json_decode($subjectTeacher->id_study_class));
        }

        $classes = StudyClass::whereIn('id', $idStudyClasses->unique())
            ->get(['slug', 'name']);


        if (isset($_GET['study_class'])) {
            $study_class = StudyClass::where('slug', $_GET['study_class'])->first();
            $datas = SubjectTeacher::with('teacher', 'course')
                ->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $study_class->id . '"]\')')
                ->where('status', 1)
                ->get();

            $general_weights = DB::table('general_weightings')
                ->join('teachers', 'teachers.id', '=', 'general_weightings.id_teacher')
                ->where('general_weightings.id_study_class', $study_class->id)
                ->where('general_weightings.type', $type)
                ->get();

            $result = [];
            foreach ($datas as $data) {
                $found = $general_weights->first(function ($item) use ($data) {
                    return $item->id_course == $data->id_course
                        && $item->id_teacher == $data->id_teacher
                        && $item->id_school_year == $data->id_school_year;
                });

                $score_weight = $found ? $found->score_weight : null;
                $score_uts = $found ? $found->uts_weight : null;
                $score_uas = $found ? $found->uas_weight : null;

                $result[] = [
                    'course' => $data->course->name,
                    'teacher' => $data->teacher->name,
                    'type' => $type,
                    'score_weight' => $score_weight,
                    'uts_weight' => $score_uts,
                    'uas_weight' => $score_uas,
                    'id_teacher' => $data->id_teacher,
                    'id_course' => $data->id_course,
                    'id_study_class' => $study_class->id,
                    'id_school_year' => $data->id_school_year,
                ];
            }
            // dd($result);
        } else {
            $result = [];
        }
        return view('content.score_k13.v_general_weighting', compact('classes', 'result'));
    }

    public function storeOrUpdate(GeneralWeightRequest $request)
    {
        $data = $request->validated();
        // dd($data);

        $id = $data['id_teacher'];

        for ($i = 0; $i < count($id); $i++) {
            if ($data['type'] == 'uts') {
                GeneralWeighting::updateOrCreate(
                    [
                        'id_teacher' => $id[$i],
                        'id_course' => $data['id_course'][$i],
                        'id_study_class' => $data['id_study_class'][$i],
                        'id_school_year' => session('id_school_year'),
                        'type' => $data['type']
                    ],
                    [
                        'score_weight' => $data['score_weight'][$i],
                        'uts_weight' => $data['uts_weight'][$i],
                    ]
                );
            } else {
                GeneralWeighting::updateOrCreate(
                    [
                        'id_teacher' => $id[$i],
                        'id_course' => $data['id_course'][$i],
                        'id_study_class' => $data['id_study_class'][$i],
                        'id_school_year' => session('id_school_year'),
                        'type' => $data['type']
                    ],
                    [
                        'score_weight' => $data['score_weight'][$i],
                        'uts_weight' => $data['uts_weight'][$i],
                        'uas_weight' => $data['uas_weight'][$i],
                    ]
                );
            }
        }
        Helper::toast('Berhasil mengupdate bobot penilaian', 'success');
        return redirect()->back();
    }
}
