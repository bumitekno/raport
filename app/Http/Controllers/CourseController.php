<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Course\CourseRequest;
use App\Models\Course;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        session()->put('title', 'Daftar Mata Pelajaran');
        if ($request->ajax()) {
            $data = Course::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('courses.show', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="69" height="69" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="16" x2="12" y2="12"></line><line x1="12" y1="8" x2="12.01" y2="8"></line></svg> Detail</a>
                        <a class="dropdown-item" href="' . route('courses.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('courses.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('name', function ($row) {
                    return '<blockquote class="my-0">
                    <p class="d-inline">' . $row['name'] . ' (' . $row['code'] . ')</p>
                     <small>Kelompok <cite title="Source Title">' . $row['group'] . '</cite></small>
                 </blockquote>';
                })
                ->addColumn('teacher', function ($row) {
                    return '<div class="avatar--group">
                    <div class="avatar">
                        <img alt="avatar" src="' . asset('asset/img/90x90.jpg') . '" class="rounded-circle  bs-tooltip" data-original-title="Judy Holmes">
                    </div>
                    <div class="avatar">
                        <img alt="avatar" src="' . asset('asset/img/90x90.jpg') . '" class="rounded-circle  bs-tooltip" data-original-title="Judy Holmes">
                    </div>
                    <div class="avatar">
                        <img alt="avatar" src="' . asset('asset/img/90x90.jpg') . '" class="rounded-circle  bs-tooltip" data-original-title="Judy Holmes">
                    </div>
                    <div class="avatar">
                        <span class="avatar-title rounded-circle  bs-tooltip" data-original-title="Alan Green">AG</span>
                    </div>
                </div>';
                })
                ->editColumn('classes', function ($row) {
                    return '<span class="badge badge-primary mx-1">XII MOA</span><span class="badge badge-primary mx-1">XII MOA</span>';
                })
                ->editColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] === 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" value="1" ' . $check . '>
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->rawColumns(['action', 'status', 'name', 'teacher', 'classes'])
                ->make(true);
        }
        return view('content.courses.v_course');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->put('title', 'Tambah Mata Pelajaran');
        return view('content.courses.v_form_course');
    }

    public function store(CourseRequest $request)
    {
        // dd($request);
        Course::create($request->toArray());
        Helper::toast('Berhasil menambah pelajaran', 'success');
        return redirect()->route('courses.index');
    }

    public function show($slug)
    {
        session()->put('title', 'Detail Mata Pelajaran');
        $course = Course::where('slug', $slug)->firstOrFail();
        // dd($course);
        return view('content.courses.v_info_course', compact('course'));
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Mata Pelajaran');
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('content.courses.v_form_course', compact('course'));
    }

    public function update(CourseRequest $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $course->fill($request->input())->save();
        Helper::toast('Berhasil mengupdate pelajaran', 'success');
        return redirect()->route('courses.index');
    }

    public function destroy($slug)
    {
        Course::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus pelajaran', 'success');
        return redirect()->route('courses.index');
    }
}
