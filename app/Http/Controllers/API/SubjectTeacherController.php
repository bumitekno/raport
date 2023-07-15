<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\SubjectTeacherResource;
use App\Http\Resources\SubjectTeacherWithJoinCollection;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubjectTeacherController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $key_ta_sm = $request->get('key_ta_sm');
        $key_rombel = $request->get('key_rombel');
        $page = empty($request->get('per_page')) ? 10 : $request->get('per_page');

        $data = SubjectTeacher::join('teachers', 'teachers.id', '=', 'subject_teachers.id_teacher')
        ->join('school_years', 'school_years.id', '=', 'subject_teachers.id_school_year')
        ->join('study_classes', 'study_classes.id', '=', 'subject_teachers.id_study_class')
        ->join('courses', 'courses.id', '=', 'subject_teachers.id_course')
        ->where('subject_teachers.status', 1)
        ->where(function($query) use($keyword, $key_rombel, $key_ta_sm){
            if (!empty($keyword)) {
                $query->where('teachers.name', 'LIKE', "%$keyword%");
            }

            if (!empty($key_rombel)) {
                $query->where('study_classes.key', $key_rombel);
            }

            if (!empty($key_ta_sm)) {
                $query->where('school_years.key', $key_ta_sm);
            }
        })
        ->select(
            'subject_teachers.*',
            'teachers.key as uid_guru',
            'teachers.name as nama_guru',
            'school_years.key as uid_ta_sm',
            'school_years.name as ta_sm',
            'study_classes.key as uid_rombel',
            'study_classes.key as uid_rombel',
            'study_classes.name as nama_rombel',
            'subjects.key as uid_mapel',
            'subjects.nama as nama_mapel',
            'subjects.code as kode_mapel',
        )
        ->paginate($page);

        return Response::responseApi(200, 'Guru mapel berhasil ditampilkan.', new SubjectTeacherWithJoinCollection($data));
    }

    public function show($key)
    {
        $data = SubjectTeacher::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Guru mapel berhasil ditampilkan.', new SubjectTeacherResource($data));
        } else {
            return Response::responseApi(400, 'Guru mapel tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $study_class = StudyClass::where('key', $request->study_class_key)->first();
        $subject = Course::where('key', $request->course_key)->first();
        $school_year = SchoolYear::where('key', $request->school_year_key)->first();
        $teacher = Teacher::where('key', $request->teacher_key)->first();

        $customAttributes = [
            'key' => 'UID Guru Pelajaran',
            'study_class_key' => 'Rombel',
            'course_key' => 'Mata Pelajaran',
            'school_year_key' => 'Tahun Ajaran',
            'teacher_key' => 'Guru',
        ];

        $rules = [
            'key' => 'required',
            'study_class_key' => 'required',
            'course_key' => 'required',
            'school_year_key' => 'required',
            'teacher_key' => 'required',
        ];

        $messages = ['required' => ':attribute harus diisi.', 'unique' => ':attribute sudah terdaftar.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        if (empty($study_class) || empty($subject) || empty($school_year) || empty($teacher)) {
            return Response::responseApi(400, 'Key pada salah satu inputan tidak ada.');
        }

        $study_class_id = $study_class->id;
        $subject_id = $subject->id;
        $school_year_id = $school_year->id;
        $teacher_id = $teacher->id;

        $data = SubjectTeacher::updateOrCreate(
            [
                'key' => $request->key
            ],
            [
                'slug' => $request->key,
                'id_teacher' => $teacher_id,
                'id_school_year' => $school_year_id,
                'id_course' => $subject_id,
                'id_study_class' => $study_class_id,
            ]
        );

        return Response::responseApi(200, 'Guru mapel berhasil diperbarui.', new SubjectTeacherResource($data));
    }

    public function destroy($key)
    {
        $data = SubjectTeacher::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Guru mapel berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Guru mapel tidak ditampilkan.');
        }
    }
}
