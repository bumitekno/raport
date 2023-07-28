<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Helpers\StatusHelper;
use App\Http\Requests\SchoolYear\SchoolYearRequest;
use App\Models\SchoolYear;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

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
                ->addColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] == 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" data-id="' . $row['id'] . '" class="active-year" value="1" ' . $check . '>
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->addColumn('school_year', function ($row) {
                    return substr($row['name'], 0, 9);
                })
                ->addColumn('semester', function ($row) {
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
        $merge_data = array_merge($request->toArray(), array('key' => Helper::str_random(5)));
        SchoolYear::create($merge_data);
        Helper::toast('Berhasil menambah tahun ajar', 'success');
        $this->sync_post_schoolyear();
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
        $school_year->fill(array_merge($request->input(), array('sync_date' => null)))->save();
        Helper::toast('Berhasil mengupdate tahun ajar', 'success');
        $this->sync_post_schoolyear();
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
        $this->sync_delete_schoolyear();
        Helper::toast('Berhasil menghapus tahun ajaran', 'success');
        return redirect()->route('school-years.index');
    }

    public function activated(Request $request)
    {
        SchoolYear::where('status', 1)->update(['status' => 0]);
        $school_year = SchoolYear::find($request->id);
        $school_year->update(['status' => $request->value, 'sync_date' => null]);
        if ($request->value == 1) {
            session()->put('id_school_year', $school_year->id);
            session()->put('slug_year', $school_year->slug);
            session()->put('school_year', substr($school_year->name, 0, 9));
            session()->put('semester', substr($school_year->name, -1));
            session()->put('year', substr($school_year->name, 0, 4));
        }
        $this->sync_post_schoolyear();
        return response()->json('Data berhasil diaktivasi');
    }

    /** sync post schoolyear  */
    public function sync_post_schoolyear()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $post_schoolYear = SchoolYear::whereNull('sync_date')->get();
            if (!empty($post_schoolYear)) {
                $url_post_schoolYear = env('API_BUKU_INDUK') . '/api/master/school_years';
                foreach ($post_schoolYear as $keyx => $post) {
                    $formpost = array(
                        'key' => $post->key,
                        'name' => $post->name,
                        'status' => $post->status
                    );

                    $response_post_schoolyear = Http::post($url_post_schoolYear, $formpost);
                    if ($response_post_schoolyear->ok()) {
                        $post_studkelas = SchoolYear::where('id', $post->id)->update(['sync_date' => \Carbon\Carbon::now()]);
                    }

                    if ($keyx > 0 && $keyx % 10 == 0) {
                        sleep(5);
                    }

                }
            }
        }

        return;
    }

    /** sync delete  */
    public function sync_delete_schoolyear()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $delete_schoolyear = SchoolYear::onlyTrashed()->get();
            if (!empty($delete_schoolyear)) {
                $url_delete_schoolyear = env('API_BUKU_INDUK') . '/api/master/school_years';
                foreach ($delete_schoolyear as $key => $tx) {
                    $response_schoolyear_delete = Http::delete($url_delete_schoolyear . '/' . $tx->key);
                    if ($key > 0 && $key % 10 == 0) {
                        sleep(5);
                    }
                }
            }
        }

        return;
    }

    public function getProgess()
    {
        return response()->json(array(session()->get('progress')), 200);
    }

    /** 
     * get sync data school year 
     */

    public function sync_data_schoolYear()
    {

        $this->sync_post_schoolyear();
        $this->sync_delete_schoolyear();

        session()->put('progress', 0);

        $ind = 0;

        if (!empty(env('API_BUKU_INDUK'))) {

            $url_api_school_year = env('API_BUKU_INDUK') . '/api/master/school_years';
            $response_api_school_year = Http::get($url_api_school_year);
            $resposnse_collection_school_year = $response_api_school_year->collect();
            $collection_api_school_year = collect($resposnse_collection_school_year);

            if (!empty($collection_api_school_year['data'])) {
                $check_school_year_sync = SchoolYear::whereNull('sync_date')->get()->count();
                if ($check_school_year_sync == 0) {

                    foreach ($collection_api_school_year['data'] as $key => $data_school_years) {

                        $ind = intval($key) + 1;
                        //$drop_schoolyear = SchoolYear::where('id', $data_school_years['id'])->forceDelete();
                        $create_school_years = SchoolYear::withoutGlobalScopes()->updateOrCreate([
                            'id' => $data_school_years['id'],
                            'key' => $data_school_years['uid'],
                            'slug' => \Illuminate\Support\Str::replace('/', '', $data_school_years['name']) . $data_school_years['semester_number'] . '-' . $data_school_years['uid'],
                        ], [
                            'id' => $data_school_years['id'],
                            'key' => $data_school_years['uid'],
                            'name' => $data_school_years['name'] . $data_school_years['semester_number'],
                            'status' => $data_school_years['status'],
                            'slug' => \Illuminate\Support\Str::replace('/', '', $data_school_years['name']) . $data_school_years['semester_number'] . '-' . $data_school_years['uid'],
                            'sync_date' => \Carbon\Carbon::now(),
                            'deleted_at' => isset($data_school_years['deleted_at']) ? $data_school_years['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_school_years['deleted_at']) : null
                        ]);

                        session()->put('progress', intval($ind / count($collection_api_school_year['data']) * 100));
                    }
                }
            } else {
                session()->put('progress', 100);
            }

        } else {
            session()->put('progress', 100);
        }
        $response = response()->make();
        $response->header('Content-Type', 'application/json');
        return $response;
    }
}