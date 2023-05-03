<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Models\User;
use App\Models\UserParent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'List Siswa');
        if ($request->ajax()) {
            $data = User::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('users.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('users.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('name', function ($row) {
                    $file = asset('asset/img/90x90.jpg');
                    if ($row['file'] != null) {
                        $file = asset($row['file']);
                    }
                    return '<div class="d-flex">
                    <div class="usr-img-frame mr-2 rounded-circle">
                        <img alt="avatar" class="img-fluid rounded-circle" src="' . $file . '">
                    </div>
                    <p class="align-self-center mb-0 admin-name">' . $row['name'] . '</p>
                </div>';
                })
                ->rawColumns(['action', 'name'])
                ->make(true);
        }
        return view('content.users.v_user');
    }

    public function create()
    {
        return view('content.users.v_form_user');
    }

    public function store(StoreUserRequest $request)
    {
        // dd($request);
        $data = $request->toArray();
        if ($request->hasFile('file')) {
            $data = ImageHelper::upload_asset($request, 'file', 'profile', $data);
        }
        User::create($data);
        Helper::toast('Berhasil menambah siswa', 'success');
        return redirect()->route('users.index');
    }

    public function edit(Request $request, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        $parents = UserParent::where([
            ['id_user', $user->id],
            ['status', 1],
        ])->get();
        if ($request->ajax()) {
            return DataTables::of($parents)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item edit" href="javascript:void(0)" data-id="' . $row['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item delete" href="javascript:void(0)" data-id="' . $row['id'] . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.users.v_form_user', compact('user'));
    }

    public function update(UpdateUserRequest $request, User $user, $slug)
    {
        $user = User::where('slug', $slug)->firstOrFail();
        if ($request->password) {
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }
        $data = $request->input();
        if ($request->hasFile('file')) {
            $data = ImageHelper::upload_asset($request, 'file', 'profile', $data);
        }
        $user->fill($data)->save();
        Helper::toast('Berhasil mengupdate siswa', 'success');
        return redirect()->route('users.index');
    }

    public function destroy($slug)
    {
        User::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus siswa', 'success');
        return redirect()->route('users.index');
    }
}
