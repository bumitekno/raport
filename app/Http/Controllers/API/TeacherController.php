<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\TeacherCollection;
use App\Http\Resources\TeacherResource;
use App\Models\Teacher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        $keyword = $request->get('search');
        $page = empty($request->get('per_page')) ? 10 : $request->get('per_page');

        if (isset($keyword)){
            $teachers = Teacher::active()->where(function ($query) use ($keyword){
                $query->where('name', 'like', "%$keyword%")
                    ->orWhere('nip', 'like', "%$keyword%");
            })->paginate($page);
        } else {
            $teachers = Teacher::active()->paginate($page);
        }

        return Response::responseApi(200, 'Guru berhasil ditampilkan.', new TeacherCollection($teachers));
    }

    public function show($key)
    {
        $teacher = Teacher::where('key', $key)->first();

        if ($teacher) {
            return Response::responseApi(200, 'Guru berhasil ditampilkan.', new TeacherResource($teacher));
        } else {
            return Response::responseApi(400, 'Guru tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'key' => 'Key',
            'name' => 'Nama Guru',
            'gender' => 'Jenis Kelamin',
            'email' => 'Email',
            'file' => 'Foto',
            'type' => 'Tipe',
        ];

        $rules = [
            'key' => 'required',
            'name' => 'required',
            'gender' => 'required',
            'type' => 'required',
            'email' => 'required|email|unique:teachers,email',
            'file' => 'nullable|mimes:jpeg,jpg,png',
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

        $teacher = Teacher::create([
            'key' => $request->key,
            'slug' => str_slug($request->name.'-'.str_random(10).''),
            'nip' => $request->nip,
            'nik' => $request->nik,
            'nuptk' => $request->nuptk,
            'name' => $request->name,
            'gender' => $request->gender,
            'religion' => $request->religion,
            'file' => $avatar,
            'phone' => $request->phone,
            'email' => $request->email,
            'place_of_birth' => $request->place_of_birth,
            'date_of_birth' => $request->date_of_birth,
            'address' => $request->address,
            'type' => $request->type,
            'id_class' => $request->id_class,
            'password' => bcrypt(12345),
            'status' => 1,
        ]);

        return Response::responseApi(200, 'Guru berhasil ditambahkan.', new TeacherResource($teacher));
    }

    public function update(Request $request, $key)
    {
        $teacher = Teacher::where('key', $key)->first();

        if ($teacher) {
            $customAttributes = [
                'name' => 'Nama Guru',
                'gender' => 'Jenis Kelamin',
                'email' => 'Email',
                'file' => 'Foto',
                'type' => 'Tipe',
            ];
    
            $rules = [
                'name' => 'required',
                'gender' => 'required',
                'type' => 'required',
                'email' => 'required|email|unique:teachers,email,'.$key.',key',
                'file' => 'nullable|mimes:jpeg,jpg,png',
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

            $avatar = empty($request->file('file')) ? $teacher->file : $request->file('file')->store('images');

            $teacher->update([
                'slug' => str_slug($request->name.'-'.str_random(10).''),
                'nip' => $request->nip,
                'nik' => $request->nik,
                'nuptk' => $request->nuptk,
                'name' => $request->name,
                'gender' => $request->gender,
                'religion' => $request->religion,
                'file' => $avatar,
                'phone' => $request->phone,
                'email' => $request->email,
                'place_of_birth' => $request->place_of_birth,
                'date_of_birth' => $request->date_of_birth,
                'address' => $request->address,
                'type' => $request->type,
                'id_class' => $request->id_class,
            ]);

            return Response::responseApi(200, 'Guru berhasil diperbarui.', new TeacherResource($teacher));
        } else {
            return Response::responseApi(400, 'Guru tidak ditemukan.');
        }
    }

    public function update_status(Request $request)
    {
        $teacher = Teacher::where('key', $request->key)->first();

        if ($teacher) {
            $teacher->update(['status' => $request->status]);

            return Response::responseApi(200, 'Guru berhasil diperbarui.', new TeacherResource($teacher));
        } else {
            return Response::responseApi(400, 'Guru tidak ditemukan.');
        }
    }

    public function destroy($key)
    {
        $data = Teacher::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Guru berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Guru tidak ditampilkan.');
        }
    }
}
