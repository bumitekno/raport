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
use Illuminate\Support\Facades\Http;
use DateTime;

class SubjectTeacherController extends Controller
{

    public function storeOrUpdateItem(SubjectTeacherRequest $request)
    {

        $subject_teacher = $request->id ? SubjectTeacher::findOrFail($request->id) : new SubjectTeacher();

        $subject_teacher->id_teacher = $request->id_teacher;
        $subject_teacher->id_course = $request->id_course;
        $subject_teacher->id_school_year = $request->id_school_year;
        $subject_teacher->id_study_class = json_encode($request->id_class);
        $subject_teacher->status = $request->status;
        $subject_teacher->sync_date = null;
        $subject_teacher->key = $subject_teacher->key == null ? Helper::str_random(5) : $subject_teacher->key;
        $subject_teacher->slug = $subject_teacher->slug == null ? $request->id_teacher . '-' . Helper::str_random(5) : $subject_teacher->slug;
        $subject_teacher->save();

        $this->sync_subjectTeacher();

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

    /** sync post subject  */
    public function sync_subjectTeacher()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $post_subject_teacher = SubjectTeacher::whereNull('sync_date')->get();
            if (!empty($post_subject_teacher)) {
                $url_post_subject_teacher = env('API_BUKU_INDUK') . '/api/master/subject_teachers';

                foreach ($post_subject_teacher as $keyx => $subjectteacher) {

                    $replace = \Illuminate\Support\Str::replaceFirst('[', '', $post_subject_teacher[$keyx]->id_study_class);
                    $replace = \Illuminate\Support\Str::replaceFirst(']', '', $replace);
                    $replace = \Illuminate\Support\Str::replace('"', '', $replace);

                    $replace = array_map('intval', explode(',', $replace));

                    $form_multi = [];

                    foreach ($replace as $key => $listid) {
                        $studikelas = \App\Models\StudyClass::where('id', $listid)->first();

                        if (!empty($studikelas)) {

                            $studikelas_key[] = $studikelas->key;
                            $level_key = \App\Models\Level::where('id', $studikelas->id_level)->first()?->key;
                            $mapel_key = \App\Models\Course::where('id', $subjectteacher->id_course)->first()?->key;
                            $school_year_key = \App\Models\SchoolYear::where('id', $subjectteacher->id_school_year)->first()?->key;
                            $teacher_key = \App\Models\Teacher::where('id', $subjectteacher->id_teacher)->first()?->key;

                            $form_multi = array(
                                'key' => $post_subject_teacher[$keyx]->key,
                                'level_key' => $level_key,
                                'mapel_key' => $mapel_key,
                                'school_year_key' => $school_year_key,
                                'teacher_key' => $teacher_key,
                                'status' => $post_subject_teacher[$keyx]->status,
                                'id' => $post_subject_teacher[$keyx]->id,
                                'study_class_key' => implode(',', $studikelas_key)
                            );
                        }
                    }

                    if (!empty($form_multi)) {

                        $response_subject_teacher = Http::post($url_post_subject_teacher, $form_multi);
                        if ($response_subject_teacher->ok()) {
                            $post_studkelas = SubjectTeacher::where('id', $post_subject_teacher[$keyx]->id)->update(['sync_date' => \Carbon\Carbon::now()]);
                        }
                    }
                }
            }
        }

        return;
    }

}