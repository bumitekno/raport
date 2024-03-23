<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\DescriptionCompetence;
use App\Models\DescriptionCompetenceScore;
use Illuminate\Http\Request;

class DescriptionCompetenceController extends Controller
{
    public function index()
    {
        // Ambil data kkm
        session()->put('title', 'Kelola Deskirpsi Capaian Kompetensi');
        $score_competencies = DescriptionCompetenceScore::where([
            'id_course' => (int)session('teachers.id_course'),
            'id_teacher' => (int)auth()->user()->id,
            'id_study_class' => (int)session('teachers.id_study_class')
        ])->first();
        
        // Jika belum ada dibuat
        if($score_competencies == null){
            $score_competencies = DescriptionCompetenceScore::create([
                'id_course' => session('teachers.id_course'),
                'id_teacher' => auth()->user()->id,
                'id_study_class' => session('teachers.id_study_class'),
                'score_kkm' => 70
            ]);
        }

        $description = DescriptionCompetence::all();
        return view('content.score_p5.v_description_competence', compact('description','score_competencies'));
    }

    public function storeOrUpdate(Request $request)
    {
        
        $criteria = $request->input('criteria');
        $description = $request->input('description');

        for ($i = 0; $i < count($criteria); $i++) {
            $data = [
                'criteria' => $criteria[$i],
                'description' => $description[$i],
            ];

            if (isset($request->id[$i])) {
                DescriptionCompetence::where('id', $request->id[$i])->update($data);
            } else {
                DescriptionCompetence::create($data);
            }
        }

        $deletedIds = $request->deleted_id;
        if (!empty($deletedIds)) {
            foreach ($deletedIds as $id) {
                DescriptionCompetence::destroy($id);
            }
        }

        $score_kkm = DescriptionCompetenceScore::find($request->id_sdc);
        $score_kkm->score_kkm = $request->score_kkm;
        $score_kkm->save();


        Helper::toast('Berhasil menambah criteria', 'success');
        return redirect()->back();
    }
}
