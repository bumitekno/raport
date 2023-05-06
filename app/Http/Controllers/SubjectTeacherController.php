<?php

namespace App\Http\Controllers;

use App\Exports\FullSubjectTeacherExport;
use App\Helpers\Helper;
use App\Http\Requests\SubjectTeacher\SubjectTeacherRequest;
use App\Imports\SubjectTeacherMultipleImport;
use App\Models\SubjectTeacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

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

    public function get_study_class(Request $request)
    {
        $id_class = $request->id_study_class;
        // $id_class = 1;
        $teachers = SubjectTeacher::with('teacher', 'course')->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $id_class . '"]\')')
            ->where('status', 1)
            ->get();
        return response()->json($teachers);
        // dd($teachers);
    }

    public function export()
    {
        return Excel::download(new FullSubjectTeacherExport(), '' . Carbon::now()->timestamp . '_format_guru_mapel.xls');
    }

    public function import(Request $request, $slug)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $nama_file = $file->hashName();
            $path = $file->storeAs('public/excel/', $nama_file);
            Excel::import(new SubjectTeacherMultipleImport($slug), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->route('courses.show', $slug);
        } catch (\Throwable $e) {
            // dd($e['message']);
            Helper::toast($e->getMessage(), 'errror');
            return redirect()->route('courses.show', $slug);
        }
    }
}
