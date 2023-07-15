<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Major;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MajorController extends Controller
{
    public function index()
    {
        $data = Major::active()->get();

        return Response::responseApi(200, 'Jurusan berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = Major::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Jurusan berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Jurusan tidak ditemukan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = ['name' => 'Nama Jurusan'];

        $rules = ['name' => 'required'];

        $messages = ['required' => ':attribute harus diisi.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $data = Major::updateOrCreate(['key' => $request->key], ['slug' => $request->slug, 'name' => $request->name]);

        return Response::responseApi(200, 'Jurusan berhasil diperbarui.', $data->data());
    }

    public function destroy($key)
    {
        $data = Major::where('key', $key)->first();

        if ($data) {
            $data->delete();
            
            return Response::responseApi(200, 'Jurusan berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Jurusan tidak ditampilkan.');
        }
    }
}
