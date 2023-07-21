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
use Illuminate\Support\Facades\Http;
use DateTime;

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
        $postdata = array_merge($data, array('key' => Helper::str_random(5)));
        Teacher::create($postdata);
        $this->sync_post_user();
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

        if ($data['password'] != null) {
            $teacher->password = $data['password'];
        }
        if ($data['id_class']) {
            $teacher->id_class = $data['id_class'];
        }
        // dd($teacher);
        $teacher->sync_date = null;
        $teacher->save();

        $this->sync_post_user();

        Helper::toast('Berhasil mengupdate guru', 'success');
        return redirect()->route('teachers.index');
    }

    public function destroy($slug)
    {
        $teacher = Teacher::where('slug', $slug)->firstOrFail();
        $teacher->delete();
        $this->sync_delete_user();
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
            $this->sync_post_user();
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->route('teachers.index');
        } catch (\Throwable $e) {
            Helper::toast($e->getMessage(), 'errror');
            return redirect()->route('teachers.index');
        }
    }

    /** post or update sync */
    public function sync_post_user()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $datetime = new DateTime();
            $timestamp = $datetime->format('Y-m-d H:i:s');
            $post_user_teacher = Teacher::whereNull('sync_date')->get();
            if (!empty($post_user_teacher)) {

                $url_post_user_teacher = env('API_BUKU_INDUK') . '/api/users/teachers/updateorcreate';
                foreach ($post_user_teacher as $key => $user_teacher) {
                    $form_user_teacher = array(
                        'key' => $user_teacher->key,
                        'name' => $user_teacher->name,
                        'status' => $user_teacher->status,
                        'nik' => $user_teacher->nik,
                        'nip' => $user_teacher->nip,
                        'nuptk' => $user_teacher->nuptk,
                        'gender' => $user_teacher->gender == 'male' ? 'L' : 'P',
                        'religion' => $user_teacher->religion == 'lainnya' ? 'protestan' : $user_teacher->religion,
                        'email' => $user_teacher->email,
                        'birth_day' => $user_teacher->date_of_birth,
                        'birth_place' => $user_teacher->place_of_birth,
                        'contact' => $user_teacher->phone,
                        'address' => $user_teacher->address,
                    );

                    $response_user_teacher = Http::post($url_post_user_teacher, $form_user_teacher);
                    if ($response_user_teacher->ok()) {
                        $post_userteacher = Teacher::where('id', $user_teacher->id)->update(['sync_date' => $timestamp]);
                    }
                }
            }
        }
        return;
    }


    /** delete sync */
    public function sync_delete_user()
    {
        if (!empty(env('API_BUKU_INDUK'))) {
            $delete_user_teacher = Teacher::onlyTrashed()->get();
            if (!empty($delete_user_teacher)) {
                $url_delete_user_teacher = env('API_BUKU_INDUK') . '/api/users/teachers';
                foreach ($delete_user_teacher as $key => $user) {
                    $response_user_delete = Http::delete($url_delete_user_teacher . '/' . $user->key);
                    if ($key > 0 && $key % 10 == 0) {
                        sleep(5);
                    }
                }
            }
        }
        return;
    }

    /** session progress */
    public function getProgess()
    {
        return response()->json(array(session()->get('progress')), 200);
    }

    /** sync get data user */
    public function sync_get_user()
    {
        session()->put('progress', 0);

        $ind = 0;

        if (!empty(env('API_BUKU_INDUK'))) {
            $url_api_teacher = env('API_BUKU_INDUK') . '/api/users/teachers/data/all';
            $response_api_teacher = Http::get($url_api_teacher);
            $resposnse_collection_student = $response_api_teacher->collect();
            $collection_api_teacher = collect($resposnse_collection_student);
            if (!empty($collection_api_teacher['data'])) {
                $datetime = new DateTime();
                $timestamp = $datetime->format('Y-m-d H:i:s');
                $check_school_usert_teacher = Teacher::whereNull('sync_date')->get()->count();
                if ($check_school_usert_teacher == 0) {
                    foreach ($collection_api_teacher['data'] as $key => $data_user) {

                        $ind = intval($key) + 1;

                        $check_password = Teacher::where('key', $data_user['uid'])->first();

                        if (!empty($check_password) && !empty($check_password->password)) {

                            $create_user = Teacher::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                            ], [
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'name' => $data_user['name'],
                                'gender' => $data_user['gender'] == 'L' ? 'male' : 'female',
                                'email' => $data_user['email'],
                                'nip' => $data_user['nip'],
                                'nik' => $data_user['nik'],
                                'nuptk' => $data_user['nuptk'],
                                'place_of_birth' => $data_user['birth_place'],
                                'date_of_birth' => \Carbon\Carbon::parse($data_user['birth_day']),
                                'address' => $data_user['address'],
                                'type' => 'teacher',
                                'phone' => $data_user['contact'],
                                'sync_date' => $timestamp,
                                'status' => $data_user['status'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null
                            ]);

                        } else {

                            //drop duplicated user 
                            $drop_user = Teacher::where('id', $data_user['id'])->forceDelete();

                            $create_user = Teacher::withoutGlobalScopes()->updateOrCreate([
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                            ], [
                                'id' => $data_user['id'],
                                'key' => $data_user['uid'],
                                'name' => $data_user['name'],
                                'gender' => $data_user['gender'] == 'L' ? 'male' : 'female',
                                'email' => $data_user['email'],
                                'nip' => $data_user['nip'],
                                'nik' => $data_user['nik'],
                                'nuptk' => $data_user['nuptk'],
                                'place_of_birth' => $data_user['birth_place'],
                                'date_of_birth' => \Carbon\Carbon::parse($data_user['birth_day']),
                                'address' => $data_user['address'],
                                'type' => 'teacher',
                                'phone' => $data_user['contact'],
                                'sync_date' => $timestamp,
                                'status' => $data_user['status'],
                                'slug' => $data_user['name'] . '-' . $data_user['uid'],
                                'password' => '12345678',
                                'deleted_at' => isset($data_user['deleted_at']) ? $data_user['deleted_at'] == null ? null : \Carbon\Carbon::parse($data_user['deleted_at']) : null
                            ]);
                        }

                        session()->put('progress', intval($ind / count($collection_api_teacher['data']) * 100));

                    }
                }
            } else {
                session()->put('progress', 100);
            }
        }

        $response = response()->make();
        $response->header('Content-Type', 'application/json');
        return $response;
    }

}