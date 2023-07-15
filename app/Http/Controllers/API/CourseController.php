<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CourseController extends Controller
{
    public function index()
    {
        $data = Course::active()->get();

        return Response::responseApi(200, 'Mata pelajaran berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = Course::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Mata pelajaran berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Mata pelajaran tidak ditampilkan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'key' => 'UID Mata Pelajaran',
            'slug' => 'Slug Mata Pelajaran',
            'name' => 'Nama Mata Pelajaran',
            'code' => 'Kode Mata Pelajaran',
            'group' => 'Kelompok Mata Pelajaran',
        ];

        $rules = ['key' => 'required', 'name' => 'required', 'group' => 'required',
                  'code' => 'required|unique:courses,code,'.$request->key.',key'];

        $messages = ['required' => ':attribute harus diisi.', 'unique' => ':attribute sudah terdaftar.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $data = Course::updateOrCreate(
            [
                'key' => $request->key
            ],
            [
                'slug' => $request->slug,
                'code' => $request->code,
                'name' => $request->name,
                'group' => $request->group,
                'status' => 1
            ]
        );

        return Response::responseApi(200, 'Mata pelajaran berhasil diperbarui.', $data->data());
    }

    public function destroy($key)
    {
        $data = Course::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Mata pelajaran berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Mata pelajaran tidak ditampilkan.');
        }
    }
}
