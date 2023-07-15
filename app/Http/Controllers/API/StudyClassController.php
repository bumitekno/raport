<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\StudyClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StudyClassController extends Controller
{
    public function index()
    {
        $data = [];

        $study_classes = StudyClass::where('status', 1)->with('major')->with('level')->get();

        foreach ($study_classes as $study_class){
            $data[] = [
                'key' => $study_class->key,
                'slug' => $study_class->slug,
                'major' => empty($study_class->major) ? null : $study_class->major->name,
                'level' => empty($study_class->level) ? null : $study_class->level->name,
                'name' => $study_class->name,
                'status' => $study_class->status,
            ];
        }

        return Response::responseApi(200, 'Rombongan belajar berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = StudyClass::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Rombongan belajar berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Rombongan belajar tidak ditampilkan.');
        }
    }

    public function update(Request $request)
    {
        $customAttributes = [
            'key' => 'UID Rombel',
            'name' => 'Nama Rombel',
        ];

        $rules = ['key' => 'required','name' => 'required'];

        $messages = ['required' => ':attribute harus diisi.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $data = StudyClass::where('key', $request->key)->first();

        if ($data) {
            $data->update(['name' => $request->name]);

            return Response::responseApi(200, 'Rombongan belajar berhasil diperbarui.', $data->data());
        } else {
            return Response::responseApi(400, 'Rombongan belajar tidak ditampilkan.');
        }
    }

    public function destroy($key)
    {
        $data = StudyClass::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Rombongan belajar berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Rombongan belajar tidak ditampilkan.');
        }
    }
}
