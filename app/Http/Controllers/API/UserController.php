<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $page = empty($request->get('per_page')) ? 10 : $request->get('per_page');

        if (isset($keyword)){
            $students = User::active()->where(function ($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('nis', 'like', "%$keyword%")
                    ->orWhere('nisn', 'like', "%$keyword%");
            })->paginate($page);
        } else {
            $students = User::active()->paginate($page);
        }

        return Response::responseApi(200, 'Siswa berhasil ditampilkan.', new UserCollection($students));
    }

    public function show($key)
    {
        $students = User::where('key', $key)->first();

        if ($students) {
            return Response::responseApi(200, 'Siswa berhasil ditampilkan.', new UserResource($students));
        } else {
            return Response::responseApi(400, 'Siswa tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'key' => 'Key',
            'name' => 'Nama Siswa',
            'email' => 'Email',
            'nis' => 'NIS',
            'nisn' => 'NISN',
            'gender' => 'Jenis Kelamin',
            'religion' => 'Agama',
            'file' => 'Foto',
            'family_status' => 'Status Keluarga'
        ];

        $rules = [
            'key' => 'required',
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'file' => 'nullable|mimes:jpeg,jpg,png',
            'family_status' => 'required'
        ];

        $messages = [
            'required' => ':attribute harus diisi.',
            'mimes' => 'Format :attribute jpg, jpeg atau png.',
            'unique' => ':attribute sudah terdaftar.',
            'email' => 'Format penulisan :attribute belum benar.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $avatar = empty($request->file('file')) ? null : $request->file('file')->store('images');

        $student = User::create([
            'key' => $request->key,
            'name' => $request->name,
            'slug' => str_slug($request->name.'-'. str_random(10) .''),
            'email' => $request->email,
            'nis' => $request->nis,
            'nisn' => $request->nisn,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'file' => $avatar,
            'phone' => $request->phone,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'family_status' => $request->family_status,
            'child_off' => $request->child_off,
            'school_from' => $request->school_from,
            'accepted_grade' => $request->accepted_grade,
            'accepted_date' => $request->accepted_date,
            'password' => bcrypt($request->nis),
            'entry_year' => $request->entry_year,
            'status' => 1,
        ]);

        return Response::responseApi(200, 'Siswa berhasil ditambahkan.', new UserResource($student));
    }

    public function update(Request $request, $key)
    {
        $student = User::where('key', $key)->first();

        if ($student) {
            $customAttributes = [
                'name' => 'Nama Siswa',
                'email' => 'Email',
                'nis' => 'NIS',
                'nisn' => 'NISN',
                'gender' => 'Jenis Kelamin',
                'religion' => 'Agama',
                'file' => 'Foto',
                'family_status' => 'Status Keluarga'
            ];
    
            $rules = [
                'name' => 'required',
                'email' => 'required|email|unique:users,email,'. $key .',key',
                'file' => 'nullable|mimes:jpeg,jpg,png',
                'family_status' => 'required'
            ];
    
            $messages = [
                'required' => ':attribute harus diisi.',
                'mimes' => 'Format :attribute jpg, jpeg atau png.',
                'unique' => ':attribute sudah terdaftar.',
                'email' => 'Format penulisan :attribute belum benar.',
            ];
    
            $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);
    
            if ($validator->fails()) {
                return Response::responseApi(302, $validator->messages()->first());
            }

            $avatar = empty($request->file('file')) ? $student->file : $request->file('file')->store('images');

            $student->update([
                'name' => $request->name,
                'slug' => str_slug($request->name.'-'. str_random(10) .''),
                'email' => $request->email,
                'nis' => $request->nis,
                'nisn' => $request->nisn,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'file' => $avatar,
                'phone' => $request->phone,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'family_status' => $request->family_status,
                'child_off' => $request->child_off,
                'school_from' => $request->school_from,
                'accepted_grade' => $request->accepted_grade,
                'accepted_date' => $request->accepted_date,
                'entry_year' => $request->entry_year,
            ]);

            return Response::responseApi(200, 'Siswa berhasil diperbarui.', new UserResource($student));
        } else {
            return Response::responseApi(400, 'Siswa tidak ditemukan.');
        }
    }

    public function update_status(Request $request)
    {
        $teacher = User::where('key', $request->key)->first();

        if ($teacher) {
            $teacher->update(['status' => $request->status]);

            return Response::responseApi(200, 'Siswa berhasil diperbarui.', new UserResource($teacher));
        } else {
            return Response::responseApi(400, 'Siswa tidak ditemukan.');
        }
    }
}
