<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Extracurricular;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ExtracurricularController extends Controller
{
    public function index()
    {
        $data = Extracurricular::active()->get();

        return Response::responseApi(200, 'Ekstrakurikuler berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = Extracurricular::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Ekstrakurikuler berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Ekstrakurikuler tidak ditampilkan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = ['name' => 'Nama Ekstrakurikuler'];

        $rules = ['name' => 'required'];

        $messages = ['required' => ':attribute harus diisi.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $extracurricular = Extracurricular::where('key', $request->key)->first();

        if (empty($request->person_responsible)) {
            if (empty($extracurricular)) {
                $person_responsible = '-';
            } else {
                $person_responsible = $extracurricular->person_responsible;
            }
        } else {
            $person_responsible = $request->person_responsible;
        }

        if (empty($request->student_classes)) {
            if (empty($extracurricular)) {
                $student_classes = '-';
            } else {
                $student_classes = $extracurricular->student_classes;
            }
        } else {
            $student_classes = $request->student_classes;
        }

        $data = Extracurricular::updateOrCreate(
            [
                'key' => $request->key
            ],
            [
                'slug' => $request->slug, 
                'name' => $request->name, 
                'person_responsible' => $person_responsible
            ]);

        return Response::responseApi(200, 'Ekstrakurikuler berhasil diperbarui.', $data->data());
    }
}
