<?php

namespace App\Http\Controllers\API;

use App\Helpers\Response;
use App\Http\Controllers\Controller;
use App\Models\Level;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LevelController extends Controller
{
    public function index()
    {
        $data = Level::active()->get();

        return Response::responseApi(200, 'Tingkat berhasil ditampilkan.', $data);
    }

    public function show($key)
    {
        $data = Level::where('key', $key)->first();

        if ($data) {
            return Response::responseApi(200, 'Tingkat berhasil ditampilkan.', $data->data());
        } else {
            return Response::responseApi(400, 'Tingkat tidak ditampilkan.');
        }
    }

    public function store(Request $request)
    {
        $customAttributes = ['name' => 'Nama Tingkat'];

        $rules = ['name' => 'required'];

        $messages = ['required' => ':attribute harus diisi.'];

        $validator = Validator::make($request->all(), $rules, $messages, $customAttributes);

        if ($validator->fails()) {
            return Response::responseApi(302, $validator->messages()->first());
        }

        $data = Level::updateOrCreate(['key' => $request->key], ['code' => $request->code, 'name' => $request->name, 'fase' => $request->fase]);

        return Response::responseApi(200, 'Tingkat berhasil diperbarui.', $data->data());
    }

    public function destroy($key)
    {
        $data = Level::where('key', $key)->first();

        if ($data) {
            $data->delete();

            return Response::responseApi(200, 'Tingkat berhasil dihapus.');
        } else {
            return Response::responseApi(400, 'Tingkat tidak ditampilkan.');
        }
    }
}
