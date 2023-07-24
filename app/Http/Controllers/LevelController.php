<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Level\LevelRequest;
use App\Models\Level;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;

class LevelController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Daftar Tingkat');
        if ($request->ajax()) {
            $data = Level::select('*');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('levels.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('levels.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
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
        return view('content.levels.v_level');
    }

    public function create()
    {
        session()->put('title', 'Tambah Tingkat');
        return view('content.levels.v_form_level');
    }

    public function store(LevelRequest $request)
    {
        $postdata = array_merge($request->toArray(), array('key' => str::random(5)));
        Level::create($postdata);
        $this->sync_post_level();
        Helper::toast('Berhasil menambah tingkat', 'success');
        return redirect()->route('levels.index');
    }

    public function edit(Level $level, $slug)
    {
        session()->put('title', 'Edit Tingkat');
        $level = Level::where('slug', $slug)->firstOrFail();
        return view('content.levels.v_form_level', compact('level'));
    }

    public function update(LevelRequest $request, $slug)
    {
        $level = Level::where('slug', $slug)->firstOrFail();
        $input_merge = array_merge($request->input(), array('sync_date' => null));
        $level->fill($input_merge)->save();
        $this->sync_post_level();
        Helper::toast('Berhasil mengupdate tingkat', 'success');
        return redirect()->route('levels.index');
    }

    public function update_status(Request $request)
    {

        $major = Level::find($request->id);
        $major->status = $request->value;
        $major->sync_date = null;
        $major->save();

        $this->sync_post_level();

        return response()->json('Data berhasil disimpan');
    }

    public function destroy($slug)
    {
        $level = Level::where('slug', $slug)->firstOrFail();
        $level->delete();
        $this->sync_delete_level();
        Helper::toast('Berhasil menghapus tingkat', 'success');
        return redirect()->route('levels.index');
    }

    /**
     * sync post  level
     */

    public function sync_post_level()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $post_level = Level::whereNull('sync_date')->get();
            if (!empty($post_level)) {

                $url_post_levels = env('API_BUKU_INDUK') . '/api/master/levels';
                foreach ($post_level as $key => $level) {
                    $form_level = array(
                        'key' => $level->key,
                        'name' => $level->name,
                        'status' => $level->status,
                        'fase' => $level->fase,
                    );

                    $response_levels = Http::post($url_post_levels, $form_level);
                    if ($response_levels->ok()) {
                        $post_levels = Level::where('id', $level->id)->update(['sync_date' => \Carbon\Carbon::now()]);
                    }

                    if ($key > 0 && $key % 10 == 0) {
                        sleep(5);

                    }
                }

            }

        }
        return;
    }

    /** sync delete level */
    public function sync_delete_level()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $delete_levels = Level::onlyTrashed()->get();
            if (!empty($delete_levels)) {

                $url_delete_levels = env('API_BUKU_INDUK') . '/api/master/level';
                foreach ($delete_levels as $key => $level) {
                    $response_level_delete = Http::delete($url_delete_levels . '/' . $level->key);
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

    /** sync get data */
    public function sync_getdata()
    {
        $this->sync_post_level();
        $this->sync_delete_level();
        session()->put('progress', 0);
        $ind = 0;
        if (!empty(env('API_BUKU_INDUK'))) {

            $url_api_levels = env('API_BUKU_INDUK') . '/api/master/levels';
            $response_api_level = Http::get($url_api_levels);
            $resposnse_collection_levels = $response_api_level->collect();
            $collection_api_level = collect($resposnse_collection_levels);

            if (!empty($collection_api_level['data'])) {

                $check_level_sync = Level::whereNull('sync_date')->get()->count();

                if ($check_level_sync == 0) {

                    foreach ($collection_api_level['data'] as $key => $data_levels) {

                        $ind = intval($key) + 1;

                        $create_level = Level::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_levels['uid'],
                            'slug' => $data_levels['name'] . '-' . $data_levels['uid'],
                        ], [
                            'key' => $data_levels['uid'],
                            'name' => $data_levels['name'],
                            'fase' => $data_levels['fase'] ?? '-',
                            'sync_date' => \Carbon\Carbon::now(),
                            'status' => $data_levels['status'],
                            'slug' => $data_levels['name'] . '-' . $data_levels['uid'],
                            'deleted_at' => isset($data_levels['deleted_at']) ? $data_levels['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_levels['deleted_at']) : null
                        ]);

                        session()->put('progress', intval($ind / count($collection_api_level['data']) * 100));
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