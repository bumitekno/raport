<?php

namespace App\Http\Controllers;

use App\Exports\FullTeacherExport;
use App\Helpers\Helper;
use App\Helpers\ImageHelper;
use App\Http\Requests\Teacher\StoreTeacherRequest;
use App\Http\Requests\Teacher\UpdateTeacherRequest;
use App\Imports\TeacherMultipleImport;
use App\Models\StudyClass;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class TeacherController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'LIST GURU');
        if ($request->ajax()) {
            $data = Teacher::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('teachers.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('teachers.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
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
        return view('content.teachers.v_teacher');
    }

    public function create()
    {
        $classes = StudyClass::where('status', 1)->get();
        return view('content.teachers.v_form_teacher', compact('classes'));
    }

    public function store(StoreTeacherRequest $request)
    {
        // dd($request);
        $data = $request->validated();
        // dd($data);
        if ($request->hasFile('file')) {
            $image = ImageHelper::upload_asset($request, 'file', 'profile', $data);
            $data['file'] = $image['file'];
        }
        Teacher::create($data);
        Helper::toast('Berhasil menambah guru', 'success');
        return redirect()->route('teachers.index');
    }

    public function edit(Teacher $teacher, $slug)
    {
        $teacher = Teacher::where('slug', $slug)->firstOrFail();
        $classes = StudyClass::where('status', 1)->get();
        return view('content.teachers.v_form_teacher', compact('teacher', 'classes'));
    }

    public function update(UpdateTeacherRequest $request, $slug)
    {
        // dd($request);
        $data = $request->validated();
        // dd($data);
        $teacher = Teacher::where('slug', $slug)->firstOrFail();
        if ($request->hasFile('file')) {
            $data = ImageHelper::upload_asset($request, 'file', 'profile', $data);
            // dd($data);
            $teacher->file = $data['file'];
        }
        $teacher->name = $data['name'];
        $teacher->email = $data['email'];
        $teacher->phone = $data['phone'];
        $teacher->gender = $data['gender'];
        $teacher->address = $data['address'];
        $teacher->place_of_birth = $data['place_of_birth'];
        $teacher->date_of_birth = $data['date_of_birth'];
        $teacher->slug = $data['slug'];
        $teacher->type = $data['type'];
        if ($data['password']) {
            $teacher->password = $data['password'];
        }
        if ($data['id_class']) {
            $teacher->id_class = $data['id_class'];
        }
        // dd($teacher);
        $teacher->save();
        Helper::toast('Berhasil mengupdate guru', 'success');
        return redirect()->route('teachers.index');
    }

    public function destroy($slug)
    {
        $teacher = Teacher::where('slug', $slug)->firstOrFail();
        $teacher->delete();
        Helper::toast('Berhasil menghapus guru', 'success');
        return redirect()->route('teachers.index');
    }

    public function export()
    {
        return Excel::download(new FullTeacherExport(), '' . Carbon::now()->timestamp . '_format_guru.xls');
    }

    public function import(Request $request)
    {
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $nama_file = $file->hashName();
            $path = $file->storeAs('public/excel/', $nama_file);
            Excel::import(new TeacherMultipleImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->route('teachers.index');
        } catch (\Throwable $e) {
            Helper::toast($e->getMessage(), 'errror');
            return redirect()->route('teachers.index');
        }
    }
}
