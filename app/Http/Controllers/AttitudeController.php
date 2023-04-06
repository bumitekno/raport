<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\K16\AttitudeRequest;
use App\Models\Attitude;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class AttitudeController extends Controller
{
    public function index(Request $request, $type)
    {
        session()->put('title', 'Sikap ' . $type);
        $attitudes = Attitude::select('*')->where('type', $type)->get();
        return view('content.attitudes.v_attitude', compact('attitudes', 'type'));
    }

    public function storeOrUpdate(AttitudeRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        $name = $data['name'];

        for ($i = 0; $i < count($name); $i++) {
            $id = isset($request['id']) ? $request['id'][$i] : null;
            $result = Attitude::updateOrCreate(
                [
                    'id' => $id
                ],
                [
                    'name' => $name[$i],
                    'type' => $data['type'],
                ]
            );
        }

        $deletedIds = $request->deleted_id;
        if (!empty($deletedIds)) {
            foreach ($deletedIds as $id) {
                Attitude::destroy($id);
            }
        }
        Helper::toast('Berhasil mengupdate bobot sikap ' . $data['type'], 'success');
        return redirect()->back();
    }
}
