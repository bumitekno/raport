<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Score\P5Request;
use App\Models\ScoreP5;
use Illuminate\Http\Request;

class ScoreP5Controller extends Controller
{
    public function storeOrUpdate(P5Request $request)
    {
        // dd($request);
        $id_student_class = $request->id_student_class;
        $id_school_year = $request->id_school_year;
        $id_subject_teacher = $request->id_subject_teacher;

        // Cek apakah data sudah ada di database
        $score = ScoreP5::where('id_student_class', $id_student_class)
            ->where('id_school_year', $id_school_year)
            ->first();

        if (!$score) {
            // Jika data belum ada, maka buat baru
            $score = new ScoreP5;
            $score->id_student_class = $id_student_class;
            $score->id_school_year = $id_school_year;
        }
        $sub_elements = $request->sub_element;

        $scores = [];

        foreach ($sub_elements as $key => $value) {
            $exploded = explode(',', $key);
            $id_sub_element = $exploded[1];
            $id_dimension = $exploded[0];

            $scores[] = [
                'id_dimension' => $id_dimension,
                'id_sub_element' => $id_sub_element,
                'score' => $value,
            ];
        }

        $score_json = json_encode($scores);

        // Update atau tambahkan data sub_element dan description
        $score->id_subject_teacher = $id_subject_teacher;
        $score->id_p5 = $request->id_p5;
        $score->score = $score_json;
        $score->description = $request->description;

        // Simpan perubahan
        $score->save();
        Helper::toast('Berhasil mengupdate nilai', 'success');
        return redirect()->back();
    }
}
