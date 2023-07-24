<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Classx\ClassRequest;
use App\Models\Level;
use App\Models\Major;
use App\Models\StudyClass;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

class StudyClassController extends Controller
{

    public function index(Request $request)
    {
        session()->put('title', 'Daftar Kelas');
        if ($request->ajax()) {
            $data = StudyClass::select('*')->with('major', 'level')->where('id_level', '<>', 0)->where('id_major', '<>', 0);
            // dd($data);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('classes.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('classes.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->addColumn('level.name', function ($row) {
                    return empty($row->level->name) ? '-' : $row->level->name;
                })
                ->addColumn('major.name', function ($row) {
                    return empty($row->major->name) ? '-' : $row->major->name;
                })
                ->editColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] == 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" value="1" ' . $check . ' class="active-status" data-id="' . $row['id'] . '">
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->rawColumns(['action', 'status'])
                ->make(true);
        }
        return view('content.classes.v_class');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->put('title', 'Tambah Kelas');
        $majors = Major::where('status', 1)->get();
        $levels = Level::where('status', 1)->get();
        return view('content.classes.v_form_class', compact('majors', 'levels'));
    }

    public function store(Request $request)
    {
        foreach ($request->name as $name) {
            $classes = new StudyClass();
            $classes->name = $name;
            $classes->id_major = $request->id_major;
            $classes->id_level = $request->id_level;
            $classes->slug = str_slug($name) . '-' . Helper::str_random(5);
            $classes->key = Helper::str_random(5);
            $classes->save();
        }

        $this->sync_post_rombel();
        Helper::toast('Berhasil menambah kelas', 'success');
        return redirect()->route('classes.index');
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Kelas');
        $majors = Major::where('status', 1)->get();
        $levels = Level::where('status', 1)->get();
        $class = StudyClass::where('slug', $slug)->firstOrFail();
        return view('content.classes.v_form_class', compact('class', 'majors', 'levels'));
    }

    public function update(Request $request, $slug)
    {
        // dd($slug);
        $class = StudyClass::where('slug', $slug)->firstOrFail();
        $data = $request->input();
        $data['name'] = $request->name[0];
        $data['sync_date'] = null;
        $class->fill($data)->save();
        $this->sync_post_rombel();
        Helper::toast('Berhasil mengupdate kelas', 'success');
        return redirect()->route('classes.index');
    }

    public function update_status(Request $request)
    {

        $major = StudyClass::find($request->id);
        $major->status = $request->value;
        $major->sync_date = null;
        $major->save();
        $this->sync_post_rombel();
        return response()->json('Data berhasil disimpan');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\StudyClass  $studyClass
     * @return \Illuminate\Http\Response
     */
    public function destroy($slug)
    {
        $study_class = StudyClass::where('slug', $slug)->firstOrFail();
        $study_class->delete();
        $this->sync_delete();
        Helper::toast('Berhasil menghapus kelas', 'success');
        return redirect()->route('classes.index');
    }

    /** sync post rombel */

    public function sync_post_rombel()
    {
        if (!empty(env('API_BUKU_INDUK'))) {

            $post_studi_kelas = StudyClass::whereNull('sync_date')->get();
            if (!empty($post_studi_kelas)) {

                $url_post_studi_kelas = env('API_BUKU_INDUK') . '/api/master/study_classes';
                foreach ($post_studi_kelas as $key => $studikelas) {
                    $form_studi_kelas = array(
                        'key' => $studikelas->key,
                        'name' => $studikelas->name,
                        'major_id' => $studikelas->id_major,
                        'level_id' => $studikelas->id_level,
                        'status' => $studikelas->status,
                    );
                    $response_studi_kelas = Http::post($url_post_studi_kelas, $form_studi_kelas);
                    if ($response_studi_kelas->ok()) {
                        $post_studikelas = StudyClass::where('id', $studikelas->id)->update(['sync_date' => \Carbon\Carbon::now()]);

                    }

                    if ($key > 0 && $key % 10 == 0) {
                        sleep(5);

                    }
                }

            }

        }
        return;
    }

    /** sync delete  */
    public function sync_delete()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $delete_studi_kelas = StudyClass::onlyTrashed()->get();
            if (!empty($delete_studi_kelas)) {

                $url_delete_studi = env('API_BUKU_INDUK') . '/api/master/study_classes';
                foreach ($delete_studi_kelas as $key => $studi) {

                    $response_studi_delete = Http::delete($url_delete_studi . '/' . $studi->key);

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


    /** get data sync */

    public function sync_getdata()
    {

        $this->sync_post_rombel();
        $this->sync_delete();

        session()->put('progress', 0);
        $ind = 0;

        if (!empty(env('API_BUKU_INDUK'))) {

            $url_api_rombel = env('API_BUKU_INDUK') . '/api/master/study_classes';
            $response_api_rombel = Http::get($url_api_rombel);
            $resposnse_collection_rombel = $response_api_rombel->collect();
            $collection_api_rombel = collect($resposnse_collection_rombel);

            if (!empty($collection_api_rombel['data'])) {
                $check_school_rombel = StudyClass::whereNull('sync_date')->get()->count();
                if ($check_school_rombel == 0) {

                    foreach ($collection_api_rombel['data'] as $key => $data_rombel) {

                        $ind = intval($key) + 1;

                        $create_rombel = StudyClass::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_rombel['key'],
                            'slug' => $data_rombel['name'] . '-' . $data_rombel['key'],
                        ], [
                            'key' => $data_rombel['key'],
                            'name' => $data_rombel['name'],
                            'id_major' => $data_rombel['major_id'] == null ? 0 : $data_rombel['major_id'],
                            'id_level' => $data_rombel['level_id'] == null ? 0 : $data_rombel['level_id'],
                            'sync_date' => \Carbon\Carbon::now(),
                            'status' => $data_rombel['status'],
                            'slug' => $data_rombel['name'] . '-' . $data_rombel['key'],
                            'deleted_at' => isset($data_rombel['deleted_at']) ? $data_rombel['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_rombel['deleted_at']) : null
                        ]);

                        session()->put('progress', intval($ind / count($collection_api_rombel['data']) * 100));
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