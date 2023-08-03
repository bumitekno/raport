<?php

namespace App\Http\Controllers;

use App\Exports\CourseExport;
use App\Helpers\Helper;
use App\Http\Requests\Course\CourseRequest;
use App\Http\Resources\Master\SchoolYearResource;
use App\Imports\CourseImport;
use App\Models\Course;
use App\Models\SchoolYear;
use App\Models\StudyClass;
use App\Models\Teacher;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\DataTables;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        session()->put('title', 'Daftar Mata Pelajaran');
        $courses = Course::with(['subjectTeacher.teacher', 'subjectTeacher.oneClass'])->get();
        $data = $courses->map(function ($course) {
            $subjectTeachers = $course->subjectTeacher;
            $kelasIds = [];
            foreach ($subjectTeachers as $subjectTeacher) {
                $kelasIds = array_merge($kelasIds, json_decode($subjectTeacher->id_study_class));
            }
            $kelasIds = array_unique($kelasIds);

            $guruPelajaransGroup = $subjectTeachers->groupBy('teacher.id');

            $gurus = [];

            foreach ($guruPelajaransGroup as $id_guru => $group) {
                $guru = $group->first()->teacher;

                $gurus[] = [
                    'id_guru' => $guru->id,
                    'nama_guru' => $guru->name,
                    'file_guru' => $guru->file
                ];
            }


            $kelass = StudyClass::whereIn('id', $kelasIds)->get()->map(function ($kelas) {
                return [
                    'id_kelas' => $kelas->id,
                    'nama_kelas' => $kelas->name,
                ];
            });

            return [
                'id' => $course->id,
                'name' => $course->name,
                'status' => $course->status,
                'code' => $course->code,
                'group' => $course->group,
                'slug' => $course->slug,
                'teachers' => $gurus,
                'class' => $kelass,
            ];
        });
        if ($request->ajax()) {
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $alert = "return confirm('Apa kamu yakin?')";
                    return '<div class="dropdown dropup  custom-dropdown-icon">
                    <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink-3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-more-vertical"><circle cx="12" cy="12" r="1"></circle><circle cx="12" cy="5" r="1"></circle><circle cx="12" cy="19" r="1"></circle></svg>
                    </a>

                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="dropdownMenuLink-3">
                        <a class="dropdown-item" href="' . route('courses.show', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><polyline points="17 11 19 13 23 9"></polyline></svg> Guru Pelajaran</a>
                        <a class="dropdown-item" href="' . route('courses.edit', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polygon points="16 3 21 8 8 21 3 21 3 16 16 3"></polygon></svg> Edit</a>
                        <a class="dropdown-item"  onclick="' . $alert . '" href="' . route('courses.destroy', $row['slug']) . '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg> Hapus</a>
                    </div>
                </div> ';
                })
                ->editColumn('name', function ($row) {
                    return '<blockquote class="my-0">
                    <p class="d-inline">' . $row['name'] . ' (' . $row['code'] . ')</p>
                     <small>Kelompok <cite title="Source Title">' . $row['group'] . '</cite></small>
                 </blockquote>';
                })
                ->addColumn('teacher', function ($row) {
                    $result = '<div class="avatar--group">';
                    foreach ($row['teachers'] as $teacher) {
                        $file = asset($teacher['file_guru']);
                        if ($teacher['file_guru'] == null) {
                            $file = asset('asset/img/90x90.jpg');
                        }
                        $result .= '<div class="avatar">
                        <img alt="avatar" src="' . $file . '" class="rounded-circle  bs-tooltip" data-original-title="' . $teacher['nama_guru'] . '">
                    </div>';
                    }
                    $result .= '</div>';
                    return $result;
                })
                ->editColumn('classes', function ($row) {
                    $classes = '';
                    foreach ($row['class'] as $class) {
                        $classes .= '<span class="badge badge-primary mx-1">' . $class['nama_kelas'] . '</span>';
                    }
                    return $classes;
                })
                ->editColumn('status', function ($row) {
                    $check = '';
                    if ($row['status'] == 1) {
                        $check = 'checked';
                    }
                    return '<label class="switch s-icons s-outline  s-outline-primary mb-0">
                    <input type="checkbox" name="status" value="1" ' . $check . '>
                    <span class="slider round my-auto"></span>
                </label>';
                })
                ->rawColumns(['action', 'status', 'name', 'teacher', 'classes'])
                ->make(true);
        }
        return view('content.courses.v_course');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        session()->put('title', 'Tambah Mata Pelajaran');
        return view('content.courses.v_form_course');
    }

    public function store(CourseRequest $request)
    {
        // dd($request);
        Course::create($request->toArray());
        Helper::toast('Berhasil menambah pelajaran', 'success');
        return redirect()->route('courses.index');
    }

    public function show($slug)
    {
        session()->put('title', 'Detail Mata Pelajaran');
        $course = Course::where('slug', $slug)->firstOrFail();
        $classes = StudyClass::where('status', 1)->get();
        $years = SchoolYear::all();
        $years = SchoolYearResource::collection($years)->toArray(request());
        $teachers = Teacher::where('status', 1)->get();
        $subjectTeachers = DB::table('subject_teachers')
            ->select('subject_teachers.*', 'teachers.name as teacher_name', 'teachers.email as teacher_email', 'teachers.file as teacher_file', 'teachers.status as teacher_status')
            ->leftJoin('teachers', 'subject_teachers.id_teacher', '=', 'teachers.id')
            ->where('subject_teachers.id_course', $course->id)
            ->whereNull('subject_teachers.deleted_at');

        $idStudyClasses = json_decode($subjectTeachers->pluck('id_study_class'), true);
        if ($idStudyClasses) {
            foreach ($idStudyClasses as $index => $idStudyClass) {
                $studyClassAlias = 'study_classes_' . $index;
                $subjectTeachers->leftJoin(DB::raw("(SELECT id, name FROM study_classes) as $studyClassAlias"), function ($join) use ($idStudyClass, $studyClassAlias, $index) {
                    $join->on(DB::raw("JSON_EXTRACT(subject_teachers.id_study_class, '$[$index]')"), '=', DB::raw("$studyClassAlias.id"));
                });
            }
        }

        $subjectTeachers = $subjectTeachers->get();

        // membuat variabel baru untuk menampung hasil akhir
        $resultTeacher = [];

        foreach ($subjectTeachers as $subjectTeacher) {
            // mengambil data class_names dari id_study_class
            $idStudyClass = json_decode($subjectTeacher->id_study_class, true);
            $classNames = [];

            foreach ($idStudyClass as $id) {
                $studyClass = DB::table('study_classes')->find($id);
                if ($studyClass) {
                    $classNames[] = $studyClass->name;
                }
            }

            // menambahkan class_names ke dalam array data yang akan di-return
            $subjectTeacher->class_names = $classNames;
            $resultTeacher[] = $subjectTeacher;
        }
        // dd($course);
        // dd($resultTeacher);
        return view('content.courses.v_info_course', compact('course', 'classes', 'teachers', 'years', 'resultTeacher'));
    }

    public function edit($slug)
    {
        session()->put('title', 'Edit Mata Pelajaran');
        $course = Course::where('slug', $slug)->firstOrFail();
        return view('content.courses.v_form_course', compact('course'));
    }

    public function update(CourseRequest $request, $slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $course->fill($request->input())->save();
        Helper::toast('Berhasil mengupdate pelajaran', 'success');
        return redirect()->route('courses.index');
    }

    public function destroy($slug)
    {
        $course = Course::where('slug', $slug)->firstOrFail();
        $course->delete();
        Helper::toast('Berhasil menghapus pelajaran', 'success');
        return redirect()->route('courses.index');
    }

    public function export()
    {
        $title = '' . Carbon::now()->timestamp . '_format_mapel.xls';
        $MAX_LENGTH = 31;

        if (mb_strlen($title) > $MAX_LENGTH) {
            $truncated_title = mb_substr($title, 0, 28) . '...';
            $title = $truncated_title;
        }

        return Excel::download(new CourseExport, $title);
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
            Excel::import(new CourseImport(), storage_path('app/public/excel/' . $nama_file));
            Storage::delete($path);
            Helper::toast('Data Berhasil Diimport', 'success');
            return redirect()->route('courses.index');
        } catch (\Throwable $e) {
            // dd($e['message']);
            Helper::toast($e->getMessage(), 'errror');
            return redirect()->route('courses.index');
        }
    }
}
