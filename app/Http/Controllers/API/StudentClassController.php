<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\StudentClassCollection;
use App\Http\Resources\StudentClassResource;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudentClassController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $year = $request->get('year');
        $study_class = $request->get('study_class');
        $page = empty($request->get('per_page')) ? 10 : $request->get('per_page');

        $stud_classes = StudentClass::join('users as st', 'st.id', '=', 'student_classes.id_student')
                        ->join('study_classes as sc', 'sc.id', '=', 'student_classes.id_study_class')
                        ->where('student_classes.status', 1)
                        ->where(function($query) use($year, $study_class, $keyword){
                            if (!empty($keyword)) {
                                $query->where('st.name', 'LIKE', "%$keyword%")
                                    ->orWhere('st.nis', 'LIKE', "%$keyword%");
                            }

                            if (!empty($year)) {
                                $query->where('student_classes.year', $year);
                            }

                            if (!empty($study_class)) {
                                $query->where('sc.key', $study_class);
                            }
                        })
                        ->select(
                            'st.*', 'sc.key as sc_key', 'sc.name as sc_name',
                            'student_classes.key as student_classes_key',
                            'student_classes.year as year',
                        )
                        ->paginate($page);

        return Response::responseApi(200, 'Siswa kelas berhasil ditampilkan.', new StudentClassCollection($stud_classes));
    }

    public function all()
    {
        $stud_classes = StudentClass::join('users as st', 'st.id', '=', 'student_classes.id_student')
                        ->join('study_classes as sc', 'sc.id', '=', 'student_classes.id_study_class')
                        ->where('student_classes.status', 1)
                        ->select(
                            'st.*', 'sc.key as sc_key', 'sc.name as sc_name',
                            'student_classes.key as student_classes_key',
                            'student_classes.year as year',
                        )
                        ->get();

        return Response::responseApi(200, 'Siswa kelas berhasil ditampilkan.', StudentClassResource::collection($stud_classes));
    }

    public function show($key)
    {
        $data = StudentClass::join('users as st', 'st.id', '=', 'student_classes.id_student')
                ->join('study_classes as sc', 'sc.id', '=', 'student_classes.id_study_class')
                ->where('student_classes.status', 1)
                ->where('student_classes.key', $key)
                ->select(
                    'st.*', 'sc.key as sc_key', 'sc.name as sc_name',
                    'student_classes.key as student_classes_key',
                    'student_classes.year as year',
                )
                ->first();

        if ($data) {
            return Response::responseApi(200, 'Siswa kelas berhasil ditampilkan.', new StudentClassResource($data));
        } else {
            return Response::responseApi(400, 'Siswa kelas tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'uid' => 'UID Kelas Siswa',
            'student_uid' => 'UID Siswa',
            'study_class_uid' => 'UID Rombel',
            'year' => 'Tahun'
        ];

        $rules = [
            'uid' => 'required',
            'student_uid' => 'required|exists:users,key',
            'study_class_uid' => 'required|exists:study_classes,key',
            'year' => 'required',
        ];

        $messages = ['required' => ':attribute harus diisi.', 'exists' => ':attribute tidak ditemukan.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        $student_id = User::where('key', $request->student_uid)->first();
        $study_class = StudyClass::where('key', $request->study_class_uid)->first();

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $data = StudentClass::updateOrCreate(
            [
                'key' => $request->uid,
                'year' => $request->year,
                'id_student' => $student_id->id,
                'id_study_class' => $study_class->id,
            ],[]
        );

        return Response::responseApi(200, 'Siswa kelas berhasil diperbarui.', new StudentClassResource($data));
    }

    public function destroy($key)
    {
        $data = StudentClass::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Siswa kelas berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Siswa kelas tidak ditampilkan.');
        }
    }
}
