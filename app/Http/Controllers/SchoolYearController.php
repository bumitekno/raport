<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\StatusHelper;
use App\Http\Requests\SchoolYear\SchoolYearRequest;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class SchoolYearController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Daftar Tahun Ajaran');
        if ($request->ajax()) {
            $data = SchoolYear::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('school-years.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('school-years.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] == 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" data-id="' . $row['id'] . '" class="active-year" value="1" ' . $check . '>
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->editColumn('school_year', function ($row) {
                    return substr($row['name'], 0, 9);
                })
                ->editColumn('semester', function ($row) {
                    return StatusHelper::semester(substr($row['name'], -1));
                })
                ->rawColumns(['action', 'status', 'school_year', 'semester'])
                ->make(true);
        }
        return view('content.school_years.v_school_year');
    }

    public function create()
    {
        session()->put('title', 'Tambah Tahun Ajaran');
        return view('content.school_years.v_form_school_year');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SchoolYearRequest $request)
    {
        SchoolYear::create($request->toArray());
        Helper::toast('Berhasil menambah tahun ajar', 'success');
        return redirect()->route('school-years.index');
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Tahun ajaran');
        $school_year = SchoolYear::where('slug', $slug)->firstOrFail();
        return view('content.school_years.v_form_school_year', compact('school_year'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function update(SchoolYearRequest $request, $slug)
    {
        $school_year = SchoolYear::where('slug', $slug)->firstOrFail();
        $school_year->fill($request->input())->save();
        Helper::toast('Berhasil mengupdate tahun ajar', 'success');
        return redirect()->route('school-years.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\SchoolYear  $schoolYear
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $school_year = SchoolYear::where('slug', $slug)->firstOrFail();
        $school_year->delete();
        Helper::toast('Berhasil menghapus tahun ajaran', 'success');
        return redirect()->route('school-years.index');
    }

    public function activated(Request $request)
    {
        SchoolYear::where('status', 1)->update(['status' => 0]);
        $school_year = SchoolYear::find($request->id);
        $school_year->update(['status' => $request->value]);
        if ($request->value == 1) {
            session()->put('id_school_year', $school_year->id);
            session()->put('slug_year', $school_year->slug);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
            session()->put('year', substr($school_year->name, 0, 4));
        }
        return response()->json('Data berhasil diaktivasi');
    }
}
