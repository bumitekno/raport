<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Helpers\StatusHelper;
use App\Http\Controllers\Controller;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolYearController extends Controller
{
    public function index()
    {
        $data = [];

        $school_years = SchoolYear::orderBy('name', 'ASC')->get();

        foreach ($school_years as $school_year){
            $data[] = [
                'uid' => $school_year->key,
                'name' => substr($school_year->name, 0, 9),
                'semester_number' => substr($school_year->name, -1),
                'semester' => StatusHelper::semester(substr($school_year->name, -1)),
                'status' => $school_year->status
            ];
        }

        return Response::responseApi(200, 'Tahun ajaran berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = SchoolYear::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Tahun ajaran berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Tahun ajaran tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = [
            'key' => 'UID Tahun Ajaran',
            'name' => 'Nama Tahun Ajaran',
        ];

        $rules = ['key' => 'required','name' => 'required|unique:school_years,name,'.$request->key.',key'];

        $messages = ['required' => ':attribute harus diisi.', 'unique' => ':attribute sudah terdaftar.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        if ($request->status == 1) {
            SchoolYear::where('status', 1)->update(['status' => 0]);
        }

        $data = SchoolYear::updateOrCreate(
            [
                'key' => $request->key
            ],
            [
                'name' => $request->name,
                'status' => $request->status
            ]
        );

        return Response::responseApi(200, 'Tahun ajaran berhasil diperbarui.', $data->data());
    }

    public function setActive($key)
    {
        $data = SchoolYear::where('key', $key)->first();

        if ($data) {
            SchoolYear::where('status', 1)->update(['status' => 0]);

            $data->update(['status' => 1]);

            return Response::responseApi(200, 'Tahun ajaran berhasil diperbarui.', $data->data());
        } else {
            return Response::responseApi(400, 'Tahun ajaran tidak ditemukan.');
        }
    }
}
