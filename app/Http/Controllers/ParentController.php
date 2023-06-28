<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Parent\FormParentRequest;
use App\Http\Requests\User\ParentRequest;
use App\Models\UserParent;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ParentController extends Controller
{
    public function index(Request $request)
    {
        // dd(session()->all());
        session()->put('title', 'Data Keluarga');
        $data = UserParent::where([
            ['id_user', session('id_student')],
            ['status', 1],
        ])->get();
        // dd($data);
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('families.change', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('families.trash', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.families.v_family');
    }

    public function create()
    {
        // dd('create parent');
        return view('content.families.v_form_family');
    }


    public function edit(Request $request)
    {
        $parent = UserParent::find($request->id);
        return response()->json($parent);
    }

    public function change($slug)
    {
        $parent = UserParent::where([
            ['slug', $slug],
            ['status', 1]
        ])->first();
        return view('content.families.v_form_family', compact('parent'));
    }

    public function update(ParentRequest $request)
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
            'slug' => str_slug($data['name']) . '-' . Helper::str_random(5),
        ]);

        if (!$request->id && $request->has('password')) {
            $userParent->password = $data['password'];
        }

        $userParent->save();

        return response()->json(['success' => 'Keluarga berhasil terupdate.']);
    }

    public function updateOrCreate(FormParentRequest $request, $id = null)
    {
        $data = $request->validated();

        // jika ada $id, cari user_parent yang sesuai, jika tidak buat instance baru
        $userParent = UserParent::findOrNew($id);

        $userParent->name = $data['name'];
        $userParent->nik = $data['nik'];
        $userParent->email = $data['email'];
        $userParent->religion = $data['religion'];
        $userParent->type = $data['type'];
        $userParent->phone = $data['phone'];
        $userParent->job = $data['job'];
        $userParent->id_user = $data['id_user'];
        $userParent->address = $data['address'];
        $userParent->slug = str_slug($data['name']) . '-' . Helper::str_random(5);

        // jika password diisi, hash password
        if ($data['password']) {
            $userParent->password = $data['password'];
        }

        $userParent->save();
        Helper::toast('Berhasil mengupdate Keluarga', 'success');
        return redirect()->route('families.index');
    }

    public function destroy(Request $request)
    {
        $user_parent = UserParent::find($request['id']);
        $user_parent->delete();
        return response()->json(['success' => 'Keluarga berhasil dihapus.']);
    }

    public function trash($slug)
    {
        UserParent::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus keluarga', 'success');
        return redirect()->route('families.index');
    }
}
