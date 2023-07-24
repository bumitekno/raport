<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Major\MajorRequest;
use App\Models\Major;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

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
                    <input type="checkbox" name="status" value="1" ' . $check . '  class="active-status" data-id="' . $row['id'] . '" >
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

        $postdata = array_merge($request->toArray(), array('key' => str::random(5)));
        Major::create($postdata);
        $this->sync_post_major();
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
        $input_merge = array_merge($request->input(), array('sync_date' => null));
        $major->fill($input_merge)->save();
        $this->sync_post_major();
        Helper::toast('Berhasil mengupdate jurusan', 'success');
        return redirect()->route('majors.index');
    }

    public function update_status(Request $request)
    {

        $major = Major::find($request->id);
        $major->status = $request->value;
        $major->sync_date = null;
        $major->save();

        $this->sync_post_major();

        return response()->json('Data berhasil disimpan');
    }

    public function destroy($slug)
    {
        $major = Major::where('slug', $slug)->firstOrFail();
        $major->delete();
        $this->sync_delete_major();
        Helper::toast('Berhasil menghapus jurusan', 'success');
        return redirect()->route('majors.index');
    }

    /** 
     * sync post major 
     */

    public function sync_post_major()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $post_major = Major::whereNull('sync_date')->get();
            if (!empty($post_major)) {

                $url_post_major = env('API_BUKU_INDUK') . '/api/master/majors';
                foreach ($post_major as $key => $major) {
                    $form_major = array(
                        'key' => $major->key,
                        'name' => $major->name,
                        'status' => $major->status,
                    );

                    $response_major = Http::post($url_post_major, $form_major);
                    if ($response_major->ok()) {
                        $post_major = Major::where('id', $major->id)->update(['sync_date' => \Carbon\Carbon::now()]);

                    }

                    if ($key > 0 && $key % 10 == 0) {
                        sleep(5);

                    }
                }

            }
        }

        return;
    }

    /** sync delete major */

    public function sync_delete_major()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $delete_major = Major::onlyTrashed()->get();
            if (!empty($delete_major)) {

                $url_delete_major = env('API_BUKU_INDUK') . '/api/master/majors';
                foreach ($delete_major as $key => $major) {

                    $response_major_delete = Http::delete($url_delete_major . '/' . $major->key);

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

    public function sync_getdata()
    {

        $this->sync_post_major();
        $this->sync_delete_major();

        session()->put('progress', 0);
        $ind = 0;
        if (!empty(env('API_BUKU_INDUK'))) {

            $url_api_major = env('API_BUKU_INDUK') . '/api/master/majors';
            $response_api_major = Http::get($url_api_major);
            $resposnse_collection_major = $response_api_major->collect();
            $collection_api_major = collect($resposnse_collection_major);

            if (!empty($collection_api_major['data'])) {
                $check_school_major = Major::whereNull('sync_date')->get()->count();
                if ($check_school_major == 0) {

                    foreach ($collection_api_major['data'] as $key => $data_major) {

                        $ind = intval($key) + 1;

                        $create_major = Major::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_major['uid'],
                            'slug' => $data_major['name'] . '-' . $data_major['uid'],
                        ], [
                            'key' => $data_major['uid'],
                            'name' => $data_major['name'],
                            'sync_date' => \Carbon\Carbon::now(),
                            'status' => $data_major['status'],
                            'slug' => $data_major['name'] . '-' . $data_major['uid'],
                            'deleted_at' => isset($data_major['deleted_at']) ? $data_major['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_major['deleted_at']) : null
                        ]);

                        session()->put('progress', intval($ind / count($collection_api_major['data']) * 100));

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