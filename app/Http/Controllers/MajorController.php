<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Major\MajorRequest;
use App\Models\Major;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class MajorController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'LIST JURUSAN');
        if ($request->ajax()) {
            $data = Major::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('majors.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('majors.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] == 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" value="1" ' . $check . '>
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('content.majors.v_major');
    }

    public function create()
    {
        session()->put('title', 'Tambah Jurusan');
        return view('content.majors.v_form_major');
    }

    public function store(MajorRequest $request)
    {
        Major::create($request->toArray());
        Helper::toast('Berhasil menambah jurusan', 'success');
        return redirect()->route('majors.index');
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Jurusan');
        $major = Major::where('slug', $slug)->firstOrFail();
        return view('content.majors.v_form_major', compact('major'));
    }

    public function update(MajorRequest $request, $slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();
        $major->fill($request->input())->save();
        Helper::toast('Berhasil mengupdate jurusan', 'success');
        return redirect()->route('majors.index');
    }

    public function destroy($slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();
        $major->delete();
        Helper::toast('Berhasil menghapus jurusan', 'success');
        return redirect()->route('majors.index');
    }
}
