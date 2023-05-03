<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Parent\StoreParentRequest;
use App\Http\Requests\Parent\UpdateParentRequest;
use App\Http\Requests\User\ParentRequest;
use App\Models\UserParent;
use Illuminate\Http\Request;

class ParentController extends Controller
{
    public function index()
    {
        //
    }

    public function edit(Request $request)
    {
        // dd('edit parent');
        $parent = UserParent::find($request->id);
        return response()->json($parent);
        // dd($parent);
    }

    public function updateOrCreate(ParentRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        $userParent = new UserParent;

        if ($request->id != null) {
            $userParent = UserParent::findOrFail($request->id);
        }

        $userParent->fill([
            'name' => $data['name'],
            'email' => $data['email'],
            'id_user' => $data['id_user'],
            'type' => $data['type'],
            'slug' => str_slug($data['name']) . Helper::str_random(5),
        ]);

        if (!$request->id && $request->has('password')) {
            $userParent->password = bcrypt($data['password']);
        }

        $userParent->save();

        return response()->json(['success' => 'Keluarga berhasil terupdate.']);
    }

    public function destroy(Request $request)
    {
        // dd($request);
        UserParent::find($request['id'])->delete();
        return response()->json(['success' => 'Keluarga berhasil dihapus.']);
    }
}
