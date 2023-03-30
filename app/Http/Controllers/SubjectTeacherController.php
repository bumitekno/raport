<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\SubjectTeacher\SubjectTeacherRequest;
use App\Models\SubjectTeacher;
use Illuminate\Http\Request;

class SubjectTeacherController extends Controller
{

    public function storeOrUpdateItem(SubjectTeacherRequest $request)
    {
        $subject_teacher = $request->id ? SubjectTeacher::findOrFail($request->id) : new SubjectTeacher();


        $subject_teacher->id_teacher = $request->id_teacher;
        $subject_teacher->id_course = $request->id_course;
        $subject_teacher->id_school_year = $request->id_school_year;
        $subject_teacher->id_study_class =  json_encode($request->id_class);
        $subject_teacher->status = $request->status;
        $subject_teacher->save();

        Helper::toast($request->id ? 'Berhasil mengedit pembimbing' : 'Berhasil menambah pembimbing', 'success');
        return redirect()->back();
    }

    public function show(Request $request)
    {
        $subjectTeacher = SubjectTeacher::findOrFail($request->id);
        return response()->json($subjectTeacher);
    }

    public function destroy($id)
    {
        $subjectTeacher = SubjectTeacher::findOrFail($id);
        $subjectTeacher->delete();
        Helper::toast('Berhasil menghapus guru pengampu', 'success');
        return redirect()->back();
    }
}
