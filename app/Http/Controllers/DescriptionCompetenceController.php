<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Models\DescriptionCompetence;
use Illuminate\Http\Request;

class DescriptionCompetenceController extends Controller
{
    public function index()
    {
        // dd(session('role'));
        session()->put('title', 'Kelola Deskirpsi Capaian Kompetensi');
        $description = DescriptionCompetence::all();
        return view('content.score_p5.v_description_competence', compact('description'));
    }

    public function storeOrUpdate(Request $request)
    {
        // dd($request);
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

        Helper::toast('Berhasil menambah criteria', 'success');
        return redirect()->back();
    }
}
