<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\Admin\ExtracurricularRequest;
use App\Models\Extracurricular;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Http;

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
                'slug' => str_slug($data['name']) . '-' . Helper::str_random(5),
                'sync_date' => null,
                'key' => Helper::str_random(5)
            ]
        );

        $this->sync_post_extra();
        Helper::toast('Berhasil menyimpan atau mengupdate data', 'success');
        return redirect()->route('extracurriculars.index');
    }

    public function destroy($slug)
    {
        $extra = Extracurricular::where('slug', $slug)->firstOrFail();
        $extra->delete();
        $this->sync_delete_extra();
        Helper::toast('Berhasil menghapus data', 'success');
        return redirect()->route('extracurriculars.index');
    }

    /** sync post exktra kulikuler */

    public function sync_post_extra()
    {
        if (!empty(env('API_BUKU_INDUK'))) {

            $post_extra_class = Extracurricular::whereNull('sync_date')->get();
            if (!empty($post_extra_class)) {
                $url_post_extra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
                foreach ($post_extra_class as $key => $extra) {
                    $form_extra = array(
                        'key' => $extra->key,
                        'name' => $extra->name,
                        'status' => $extra->status,
                    );
                    $response_ekstra = Http::post($url_post_extra, $form_extra);
                    if ($response_ekstra->ok()) {
                        $post_extrasx = Extracurricular::where('id', $extra->id)->update(['sync_date' => \Carbon\Carbon::now()]);
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

    public function sync_delete_extra()
    {

        if (!empty(env('API_BUKU_INDUK'))) {

            $delete_extra = Extracurricular::onlyTrashed()->get();

            if (!empty($delete_extra)) {

                $url_delete_extra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
                foreach ($delete_extra as $key => $extra) {

                    $response_extra_delete = Http::delete($url_delete_extra . '/' . $extra->key);

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
        $this->sync_post_extra();
        $this->sync_delete_extra();

        session()->put('progress', 0);
        $ind = 0;

        if (!empty(env('API_BUKU_INDUK'))) {
            $url_api_ekstra = env('API_BUKU_INDUK') . '/api/master/extracurriculars';
            $response_api_ekstra = Http::get($url_api_ekstra);
            $resposnse_collection_ekstra = $response_api_ekstra->collect();
            $collection_api_ekstra = collect($resposnse_collection_ekstra);

            if (!empty($collection_api_ekstra['data'])) {
                $check_school_ekstra = Extracurricular::whereNull('sync_date')->get()->count();

                if ($check_school_ekstra == 0) {
                    foreach ($collection_api_ekstra['data'] as $key => $data_ekstra) {

                        $ind = intval($key) + 1;

                        $create_extra = Extracurricular::withoutGlobalScopes()->updateOrCreate([
                            'key' => $data_ekstra['uid'],
                            'slug' => $data_ekstra['uid'] . '-' . $data_ekstra['uid'],
                        ], [
                            'key' => $data_ekstra['uid'],
                            'name' => $data_ekstra['name'],
                            'status' => $data_ekstra['status'],
                            'slug' => $data_ekstra['uid'] . '-' . $data_ekstra['uid'],
                            'sync_date' => \Carbon\Carbon::now(),
                            'deleted_at' => isset($data_ekstra['deleted_at']) ? $data_ekstra['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_ekstra['deleted_at']) : null
                        ]);

                        session()->put('progress', intval($ind / count($collection_api_ekstra['data']) * 100));
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