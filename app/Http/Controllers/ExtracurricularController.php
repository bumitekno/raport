<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Admin\ExtracurricularRequest;
use App\Models\Extracurricular;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ExtracurricularController extends Controller
{
    public function index(Request $request)
    {
        // dd('ekstrakurikuler');
        session()->put('title', 'Kelola Ekstrakulikuler');
        if ($request->ajax()) {
            $data = Extracurricular::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('extracurriculars.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('extracurriculars.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('content.extracurriculars.v_extracurricular');
    }

    public function create()
    {
        session()->put('title', 'Buat Ekstrakurikuler');
        return view('content.extracurriculars.v_form_extracurricular');
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Ekstrakurikuler');
        $extra = Extracurricular::where('slug', $slug)->firstOrFail();
        return view('content.extracurriculars.v_form_extracurricular', compact('extra'));
    }

    public function updateOrCreate(ExtracurricularRequest $request, $id = null)
    {
        $data = $request->validated();
        Extracurricular::updateOrCreate(
            ['id' => $id],
            [
                'name' => $data['name'],
                'person_responsible' => $data['person_responsible'],
                'slug' => str_slug($data['name']) . '-' . Helper::str_random(5)
            ]
        );
        Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        return redirect()->route('extracurriculars.index');
    }

    public function destroy($slug)
    {
        $extra = Extracurricular::where('slug', $slug)->firstOrFail();
        $extra->delete();
        Helper::toast('Berhasil menghapus data', 'success');
        return redirect()->route('extracurriculars.index');
    }
}
