<?php

namespace App\Http\Controllers;

use App\Exports\FullBasicCompetencyExport;
use App\Helpers\Helper;
use App\Http\Requests\K16\BasicCompetencyRequest;
use App\Imports\BasicCompetencyMultipleImport;
use App\Models\BasicCompetency;
use App\Models\Course;
use App\Models\Level;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Yajra\DataTables\DataTables;

class BasicCompetencyController extends Controller
{
    public function index(Request $request)
    {
        // dd('kompetensi dasar');
        session()->put('title', 'Kompetensi Dasar');
        $levels = Level::all();
        if ($request->ajax()) {
            if (Auth::guard('teacher')->check()) {
                $data = BasicCompetency::select('*')->with('course', 'level')->where([
                    ['id_course', session('teachers.id_course')],
                    ['id_level', session('teachers.id_level')],
                ]);
            } else {
                $level = isset($_GET['level']) ? Level::where('slug', $_GET['level'])->first() : null;
                $data = BasicCompetency::select('*')->with('course', 'level')
                    ->when($level, function ($query) use ($level) {
                        return $query->where('id_level', $level->id);
                    });
            }

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('basic_competencies.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('basic_competencies.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->addColumn('code', function ($row) {
                    $name = json_decode($row->name);
                    return $name->code;
                })
                ->editColumn('name', function ($row) {
                    $name = json_decode($row->name);
                    return $name->name;
                })
                ->rawColumns(['action', 'code', 'name'])
                ->make(true);
        }
        return view('content.basic_competencies.v_basic_competency', compact('levels'));
    }

    public function create()
    {
        session()->put('title', 'Tambah Kompetensi Dasar');
        $levels = Level::all();
        $courses = Course::all();
        return view('content.basic_competencies.v_form_basic_competency', compact('levels', 'courses'));
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Kompetensi Dasar');
        $basic_competency = BasicCompetency::where('slug', $slug)->first();
        $levels = Level::all();
        $courses = Course::all();
        return view('content.basic_competencies.v_form_basic_competency', compact('levels', 'courses', 'basic_competency'));
    }

    public function storeOrUpdate(BasicCompetencyRequest $request, $id = null)
    {
        $data = $request->validated();
        $name = [
            'code' => $data['code'],
            'name' => $data['name']
        ];
        BasicCompetency::updateOrCreate(
            [
                'id' => $id,
            ],
            [
                'slug' => $data['slug'],
                'id_course' => $data['id_course'],
                'id_level' => $data['id_level'],
                'name' => json_encode($name),
            ]
        );
        Helper::toast('Berhasil memperbarui nilai', 'success');
        return redirect()->route('basic_competencies.index');
    }

    public function destroy($slug)
    {
        BasicCompetency::where('slug', $slug)->delete();
        Helper::toast('Berhasil menghapus data', 'success');
        return redirect()->back();
    }

    public function export()
    {
        return Excel::download(new FullBasicCompetencyExport(), '' . Carbon::now()->timestamp . '_format_kompetensi_dasar.xls');
    }

    public function import(Request $request)
    {
        // dd($request);
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        try {
            $file = $request->file('file');
            $nama_file = $file->hashName();
            $path = $file->storeAs('public/excel/', $nama_file);
            Excel::import(new BasicCompetencyMultipleImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->back();
        } catch (\Throwable $e) {
            // dd($e['message']);
            Helper::toast($e->getMessage(), 'errror');
            return redirect()->back();
        }
    }
}
