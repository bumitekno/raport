<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SchoolController extends Controller
{
    public function index()
    {
        $data = School::all()->first();

        if ($data) {
            return Response::responseApi(200, 'Sekolah berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Sekolah tidak ditampilkan.');
        }
    }

    public function store(Request $request)
    {
        $school = School::all()->first();

        $customAttributes = [
            'key' => 'UID Sekolah',
            'nama' => 'Nama Sekolah',
            'image' => 'Gambar',
        ];

        $rules = ['key' => 'required', 'name' => 'required', 'image' => 'nullable|mimes:jpeg,jpg,png',];

        $messages = ['required' => ':attribute harus diisi.', 'mimes' => 'Format :attribute jpg, jpeg atau png.',];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        if ($school) {
            $file = empty($request->file('image')) ? $school->image : $request->file('image')->store('images');
        } else {
            $file = empty($request->file('image')) ? null : $request->file('image')->store('images');
        }

        $data = School::updateOrCreate(
            [
                'key' => $request->key
            ],
            [
                'name' => $request->name,
                'address' => $request->address,
                'image' => $file,
                'city' => $request->city,
                'country' => $request->country,
                'phone_number' => $request->phone_number,
                'email' => $request->email,
            ]
        );

        return Response::responseApi(200, 'Sekolah berhasil ditampilkan.', $data->data());
    }
}
