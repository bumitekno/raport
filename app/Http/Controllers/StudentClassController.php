<?php

namespace App\Http\Controllers;

use App\Helpers\Helper;
use App\Http\Requests\StudentClass\StudentActionRequest;
use App\Models\SchoolYear;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class StudentClassController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Kelola Siswa');
        $classes = StudyClass::where('status', 1)->get();
        $years = SchoolYear::select(DB::raw("SUBSTRING(name, 1, 9) as school_year"))
            ->groupBy('school_year')
            ->orderBy('school_year', 'ASC')
            ->get()
            ->toArray();

        if ($request->ajax()) {
            if ($_GET['origin'] == 'user') {
                $data = User::select('id', 'name', 'gender', 'file', 'email', 'place_of_birth', 'date_of_birth', DB::raw("'user' as type"))
                    ->whereNotIn('id', function ($query) {
                        $query->select('id_student')->from('student_classes')->distinct();
                    })
                    ->get();
            } else {
                $get_class = StudyClass::where('slug', $_GET['class'])->first();
                $data = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
                    ->select('student_classes.id', 'student_classes.id_student',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.place_of_birth', 'users.date_of_birth',  DB::raw("IF(student_classes.status = 1, 'siswa', 'alumni') as type"))
                    ->where([
                        ['id_study_class', $get_class->id],
                        ['year', $_GET['year']],
                    ])->get();
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
                        <a class="dropdown-item" href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href=""><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('name', function ($row) {
                    $file = asset('asset/img/90x90.jpg');
                    if ($row['file'] != null) {
                        $file = asset($row['file']);
                    }
                    $class = $row['type'] == 'user' ? 'primary' : ($row['type'] == 'siswa' ? 'success' : 'warning');
                    return '<div class="d-flex">
                    <div class="usr-img-frame mr-2 rounded-circle my-auto">
                        <img alt="avatar" class="img-fluid rounded-circle" src="' . $file . '">
                    </div>
                    <div>
                    <p class="align-self-center mb-0 admin-name">' . $row['name'] . '</p>
                    <span class="badge badge-' . $class . '">' . ucwords($row['type']) . '</span>
                    </div>
                </div>';
                })
                ->addColumn('checkbox', function ($row) {
                    return '<label class="switch s-icons s-outline s-outline-primary my-auto">
                    <input type="checkbox" value="' . $row['id'] . '">
                    <span class="slider round"></span>
                </label>';
                })
                ->rawColumns(['action', 'name', 'checkbox'])
                ->make(true);
        }
        return view('content.student_classes.v_student_class', compact('classes', 'years'));
    }

    public function storeOrUpdate(StudentActionRequest $request)
    {
        // dd($request);
        $action = $request->action;
        $selectedSiswa = explode(',', $request->selected_siswa);;
        $dataOrigin = $request->data_origin;

        if ($action == 'delete') {
            if ($dataOrigin == 'student') {
                StudentClass::whereIn('id', $selectedSiswa)->delete();
            } else {
                User::whereIn('id', $selectedSiswa)->delete();
            }
        } else if ($action == 'alumni') {
            StudentClass::whereIn('id', $selectedSiswa)->update(['status' => 0]);
        } else if ($action == 'move') {

            $idStudyClass = $request->id_study_class;
            $year = substr($request->year, 0, 4);
            if ($dataOrigin == 'student') {
                $siswaData = StudentClass::whereIn('id', $selectedSiswa)->get();
            } else {
                $siswaData = User::whereIn('id', $selectedSiswa)->get();
            }
            // dd($siswaData);
            $siswaIds = $siswaData->pluck('id')->toArray();
            // dd($siswaIds);

            $existingData = StudentClass::where(function ($query) use ($siswaIds, $dataOrigin) {
                if ($dataOrigin === 'student') {
                    return $query->whereIn('id', $siswaIds);
                } else if ($dataOrigin === 'user') {
                    return $query->whereIn('id_student', $siswaIds);
                }
            })
                ->get();

            if ($dataOrigin == 'student') {
                $existingData->each(function ($data) use ($idStudyClass, $year) {
                    $newData = $data->replicate();
                    $newData->id_study_class = $idStudyClass;
                    $newData->year = $year;
                    $newData->save();

                    $data->status = 2;
                    $data->save();
                });
            } else if ($dataOrigin == 'user') {
                // Check if user is not already in student class
                $existingStudentIds = $existingData->pluck('id_student')->toArray();
                $newSiswaData = $siswaData->reject(function ($siswa) use ($existingStudentIds) {
                    return in_array($siswa->id, $existingStudentIds);
                });

                // Create new data
                $newSiswaData->each(function ($siswa) use ($idStudyClass, $year) {
                    StudentClass::create([
                        'id_student' => $siswa->id,
                        'id_study_class' => $idStudyClass,
                        'year' => $year,
                        'slug' => $siswa->id . $idStudyClass . $year . '-' . Helper::str_random(5)
                    ]);
                });
            }
        }

        return redirect()->back();
    }
}
