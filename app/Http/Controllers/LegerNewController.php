<?php

namespace App\Http\Controllers;

use App\Exports\DknExport;
use App\Exports\LegerExport;
use App\Models\AttendanceScore;
use App\Models\AttitudeGrade;
use App\Models\Kkm;
use App\Models\PredicatedScore;
use App\Models\ScoreExtracurricular;
use App\Models\ScoreKd;
use App\Models\ScoreManual;
use App\Models\ScoreManual2;
use App\Models\ScoreMerdeka;
use App\Models\StudentClass;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use App\Models\TemplateConfiguration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PDF;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;

class LegerNewController extends Controller
{
    // Menentukan predikat nilai menggunakan algorithma binary search
    // Tidak dengan loop query disetiap nilai lalu dicari predikatnya dengan query, karena tidak efektif
    // Nilai tabel predikat ditampung pada $predicate dengan mengurutkan terbesar
    // predicateScore akan mencari nilai predikat score tersebut

    public $predicate = null;

    public function predicateScore($target){
        $data = $this->predicate;
        
        $low = 0;
        $high = count($data) - 1;
        
        while ($low <= $high) {
            $mid = floor(($low + $high) / 2);
            

            // Data predikat ditemukan ketika 'target' diantara rentan nilai
            // Misal rentang B adalah 80-90, maka akan diexplode dahulu batas bawah dan atas
            // Karena pada tabel score berupa string '80-90'
            // Lalu dicocokan dengan <= dan >=
            $datas = explode("-",$data[$mid]['score']);

            if ($datas[0] <= $target && $datas[1] >= $target ) {
                return (int) $mid; // Target ditemukan
            } else if ($data[$mid]['score'] > $target) {
                $low = $mid + 1; // Cari di bagian kanan
            } else {
                $high = $mid - 1; // Cari di bagian kiri
            }
        }
        return count($data)-1; // Target tidak ditemukan
    }

    public function byClass(Request $request, $slug)
    {
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $slug)->first();
        $setting['study_class'] = $study_class->name;
        $teacher = Teacher::where([
            ['type', 'homeroom'],
            ['id_class', $study_class->id],
        ])->first();
        $setting['teacher'] = $teacher ? $teacher->name : '-';
        $student_class = StudentClass::join('users as us', 'us.id', '=', 'student_classes.id_student')
            ->where('student_classes.year', session('year'))
            ->where('student_classes.status', 1)
            ->where('student_classes.id_study_class', $study_class->id)
            ->orderBy('us.nis', 'ASC')
            ->select('student_classes.id', 'us.nis','us.nisn','us.address','us.name','us.id as id_student')
            ->get();
        
        $student_class_id = $student_class->pluck('id');
        //dd($student_class_id);

        $attitude = AttitudeGrade::join('student_classes','student_classes.id','attitude_grades.id_student_class')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->where('study_classes.id',$study_class->id)
        ->where('student_classes.year',session('year'))
        ->select('student_classes.id_student','attitude_grades.type','attitude_grades.predicate')
        ->get();
        $attitude = collect($attitude)->groupBy('id_student')->toArray();
        //dd($attitude);

        // Kedatangan (absensi) dan keterangan catatan guru ( naik/tdk dan catatan)
        $attendance = AttendanceScore::join('student_classes','student_classes.id','attendance_scores.id_student_class')
        ->join('teacher_notes','teacher_notes.id_student_class','student_classes.id')
        ->select('attendance_scores.ill','attendance_scores.excused','attendance_scores.unexcused',
        'student_classes.id_student','attendance_scores.id_student_class',
        'teacher_notes.promotion','teacher_notes.description')
        ->whereIn('attendance_scores.id_student_class',$student_class_id)
        ->get();
        $attendance = collect($attendance)->groupBy('id_student')->toArray();

        $extras = ScoreExtracurricular::where('id_study_class',$study_class->id)
        ->get();

        $this->predicate = PredicatedScore::orderBy('score','DESC')->get()->toArray();
        //dd($this->predicate);
        
        $subject_teachers = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->whereRaw('JSON_CONTAINS(id_study_class, \'["' . $study_class->id . '"]\')')
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->select('subject_teachers.id', 'c.name', 'subject_teachers.id_course', 'subject_teachers.id_teacher')
            ->get();
        //dd($subject_teachers);
        $code_course = SubjectTeacher::join('courses as c', 'c.id', '=', 'subject_teachers.id_course')
            ->leftJoin('kkms', function ($join) use ($study_class) {
                $join->on('kkms.id_school_year', '=', 'subject_teachers.id_school_year')
                    ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
                    ->on('kkms.id_course', '=', 'subject_teachers.id_course');
            })
            ->where('subject_teachers.id_school_year', session('id_school_year'))
            ->whereRaw('JSON_CONTAINS(subject_teachers.id_study_class, \'["' . $study_class->id . '"]\')')
            ->select('subject_teachers.id', 'c.code as code','c.group as group', DB::raw('MAX(kkms.score) as score'))
            ->orderBy('c.group','ASC')
            ->groupBy('subject_teachers.id', 'c.code','c.group')
            ->get()
            ->toArray();
        //dd($code_course);
    
        $group_course = collect($code_course)->groupBy('group');
        $group_course = $group_course->map(function ($products, $category) {
            return [
                'category' => $category,
                'count' => $products->count(),
            ];
        });

        $id_subject_teacher = collect($subject_teachers)->pluck('id');

        $template = TemplateConfiguration::where([
            ['id_major', $study_class->id_major],
            ['id_school_year', session('id_school_year')],
        ])->first();
        
        if($template['template'] != 'k13'){
            session()->put('message', 'Fitur ini hanya untuk kelas yang menggunakan kurikulum 13');
           return view('pages.v_error');
        }

        $scores = [];  
        
        //dd($subject_teachers);

        if ($template['template'] == 'merdeka') {
            // dd($subject_teachers->pluck('id_course')->unique()->toArray());
            $scores = ScoreMerdeka::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } else if ($template['template'] == 'k13') {
            $scores = ScoreKd::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_subject_teacher', $subject_teachers->pluck('id')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } else if ($template['template'] == 'manual') {
            $scores = ScoreManual::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                // ->where('type', $template['template'])
                ->get();
        } elseif ($template['template'] == 'manual2') {
            $scores = ScoreManual2::whereIn('id_study_class', [$study_class->id])
                ->whereIn('id_course', $subject_teachers->pluck('id_course')->unique()->toArray())
                ->whereIn('id_teacher', $subject_teachers->pluck('id_teacher')->unique()->toArray())
                ->where('id_school_year', session('id_school_year'))
                ->get();
        }

        //dd($scores);
        
        $arr_student_class = [];
        foreach ($student_class as $student) {
            $arr_student_class[] = [
                'id' => $student->id,
                'name' => $student->name,
                'nis' => $student->nis,
                'nisn' => $student->nisn,
                'address' => $student->address,
                'score' => $subject_teachers,
                'sikap' => array_key_exists($student->id_student, $attitude) ? $attitude[$student->id_student] : [],
                'absensi' => array_key_exists($student->id_student, $attendance) ? $attendance[$student->id_student] : []
            ];
        }
        //dd($arr_student_class);

        $nilai_map = collect($arr_student_class)->map(function ($a) {
            return (array) $a;
        })->toArray();

        //dd($nilai_map);
        
        foreach ($nilai_map as $nmv => $nmmv) {
            if ($template['template'] == 'k13') {
                $scoresFiltered = collect($scores)->whereIn('id_subject_teacher', collect($nmmv['score'])->pluck('id')->unique())
                    ->where('id_student_class', $nmmv['id'])
                    ->where('id_school_year', session('id_school_year'));
            } else {
                $scoresFiltered = collect($scores)->where('id_student_class', $nmmv['id'])
                    ->where('id_school_year', session('id_school_year'));

                if (!empty($nmmv['score'])) {
                    $scoresFiltered = $scoresFiltered->whereIn('id_course', collect($nmmv['score'])->pluck('id_course')->unique())
                        ->whereIn('id_teacher', collect($nmmv['score'])->pluck('id_teacher')->unique());
                }

                //dd($scoresFiltered);
            }
            // score = pengetahuan
            $arr = [];
            $jml_score = 0;
            $jml_keterampilan = 0;
            //dd($scoresFiltered);
            foreach($nmmv['score'] as $nll){
                if ($template['template'] == 'k13') {
                    $raport_ = $scoresFiltered->where('id_subject_teacher', $nll->id)->first();
                    $pengetahuan = $raport_ ? $raport_['averege_assesment'] : 0;
                    $keterampilan = $raport_ ? $raport_['final_skill'] : 0;
                    $uts = $raport_ ? $raport_['score_uts'] : 0;
                    $uas = $raport_ ? $raport_['score_uas'] : 0;
                    $nilai_akhir = $raport_ ? $raport_['final_assesment'] : 0;

                    // if(!$raport_){

                    //     dd($raport_);
                    // }

                    //Akumulasi
                    $jml_score = $jml_score + $pengetahuan;
                    $jml_keterampilan = $jml_keterampilan + $keterampilan;
                } else {
                    $raport_ = $scoresFiltered->where('id_course', $nll->id_course)
                        ->where('id_teacher', $nll->id_teacher)
                        ->first();
                    if ($template['template'] == 'manual2') {
                        $final_score = $raport_ ? ['assigment' => $raport_['final_assegment'], 'skill' => $raport_['final_skill']] : ['assigment' => null, 'skill' => null];
                    } else {
                        $final_score = $raport_ ? ($template['template'] == 'merdeka' ? $raport_['final_score'] : $raport_['score_final']) : [];
                    }
                }
                //dd($this->predicate[0]);
                //dd($this->predicateScore(0));
                $arr[] = [
                    'id' => $nll->id,
                    'name' => $nll->name,
                    'score' => $pengetahuan,
                    'keterampilan' => $keterampilan,
                    'uts' => $uts,
                    'uas' => $uas,
                    'nilai_akhir' => $nilai_akhir,
                    'predikat_nilai_akhir' => $this->predicate[$this->predicateScore($nilai_akhir)]['name'],
                    'predikat_nilai_keterampilan' => $this->predicate[$this->predicateScore($keterampilan)]['name']
                ];
            }
            
            $nilai_map[$nmv]['score'] = $arr;
            $nilai_map[$nmv]['jml_score'] = $jml_score;
            $nilai_map[$nmv]['jml_keterampilan'] = $jml_keterampilan;
            $nilai_map[$nmv]['jml_nilai'] = $jml_keterampilan + $jml_score;
        }

        unset($nmv);
        //array_multisort(array_column($nilai_map, 'jml_nilai'), SORT_DESC, $nilai_map);
        //dd($nilai_map);
        
        $results = array(
            'score' => $nilai_map,
            'course' => $code_course,
            'setting' => $setting
        );
        
        if ($request->pdf) {
            return Excel::download(new LegerExport($slug), 'leger.xlsx');
        }
        //dd($results['score']);
        if ($template['template'] == 'manual2') {
            return view('content.leger_new.v_list_leger_skill', compact('results', 'slug'));
        } else {
            return view('content.leger_new.v_list_leger', compact('results', 'slug', 'group_course'));
        }
    }

    public function listClass()
    {
        session()->put('title', 'Daftar Kelas');
        $classes = StudyClass::where('status', 1)->get();

        $results = [];
        foreach ($classes as $class) {
            $major = $class->major;
            $level = $class->level;
            $studentCount = StudentClass::where('id_study_class', $class->id)
                ->where([
                    ['status', 1],
                    ['year', session('year')]
                ])->count();

            $results[] = [
                'slug' => $class->slug,
                'name' => $class->name,
                'major' => $major ? $major->name : '',
                'level' => $level ? $level->name : '',
                'amount' => $studentCount
            ];
        }
        // dd($result);
        return view('content.legers.v_list_classes', compact('results'));
    }

    public function allLeger(Request $request,$slug){
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $slug)->first();
        $setting['study_class'] = $study_class->name;
        $setting['teacher'] = '';
        //dd(session('year'));

        // Dapatkan siswa pada kelas tsb
        $siswa = DB::table('student_classes')
        ->where('id_study_class',$study_class->id)
        ->pluck('id_student');
 
        $student_class = DB::table('student_classes')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->whereIn('student_classes.id_student',$siswa)
        ->pluck('student_classes.id');

        //dd($student_class);

        $score_merdeka = DB::table('score_merdekas')
        ->join('student_classes','student_classes.id','score_merdekas.id_student_class')
        ->join('users','users.id','student_classes.id_student')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->join('school_years','school_years.id','score_merdekas.id_school_year')
        ->join('courses','courses.id','score_merdekas.id_course')
        ->whereIn('id_student_class',$student_class)
        ->where('score_merdekas.deleted_at',null)
        ->select(['score_merdekas.id','school_years.name as semester','courses.name as mapel','student_classes.year',
        'users.name as siswa','study_classes.name','users.nis','student_classes.id_student',
        'score_merdekas.final_score'])
        ->orderBy('school_years.name','asc')
        ->get();
        //dd($score_merdeka);

        $score_merdeka = collect($score_merdeka)->map(function ($a) {
            return (array) $a;
        })->toArray();


        //Coba
        // Original array
        // Array data awal
        $data = [
            [
                "id" => 1,
                "semester" => "2023/20241",
                "siswa" => "Alfa",
                "nis" => 123,
                "mapel" => "Tajwid",
                "final_score" => 80
            ],
            [
                "id" => 5,
                "semester" => "2023/20242",
                "siswa" => "Alfa",
                "nis" => 123,
                "mapel" => "Tajwid",
                "final_score" => 70
            ],
            [
                "id" => 6,
                "semester" => "2023/20241",
                "siswa" => "feri",
                "nis" => 1234,
                "mapel" => "Tajwid",
                "final_score" => 80
            ]
        ];

        // Inisialisasi array baru
        $dataBaru = [];

        // Looping data
        foreach ($score_merdeka as $siswa) {
            // Mencari index data yang sama
            $indexSiswa = array_search($siswa["nis"], array_column($dataBaru, "nis"));

            // Jika siswa belum ada di array baru
            if ($indexSiswa === false) {
                // Menambahkan data siswa baru
                $dataBaru[] = [
                    "nama" => $siswa["siswa"],
                    "nis" => $siswa["nis"],
                    "mapel" => []
                ];

                // Menentukan indexSiswa baru
                $indexSiswa = count($dataBaru) - 1;

                // Menambahkan data mapel dan nilai
                $dataBaru[$indexSiswa]["mapel"][] = [
                    "mapel" => $siswa["mapel"],
                    "semester" => [
                        [
                            "semester" => $siswa["semester"],
                            "nilai" => $siswa["final_score"]
                        ]
                    ]
                ];

            }else{  // Jika sudah ada nama siswa sebelumnya
                //dd($dataBaru[$indexSiswa]);
                $indexMapelSiswa = array_search($siswa["mapel"],array_column($dataBaru[$indexSiswa]["mapel"],"mapel"));
                //dd($indexMapelSiswa);

                $dataBaru[$indexSiswa]["mapel"][$indexMapelSiswa]["semester"][] = [
                    "semester" => $siswa["semester"],
                    "nilai" => $siswa["final_score"]    
                ];
                
            }
        }

        $score_merdeka = collect($score_merdeka);

        $semester = $score_merdeka->pluck('semester')->unique();
        $mapel = $score_merdeka->pluck('mapel')->unique();
        $siswas = $score_merdeka->pluck('siswa')->unique();
    
        $results = array(
            'setting' => $setting
        );

        if ($request->pdf) {
           
            $pdf = PDF::loadView('content.legers.v_print_all_leger', compact('mapel','semester',
            'results','dataBaru'));
           
            $pdf->setPaper('A4', 'landscape');
            return $pdf->stream();
        }

        return view('content.legers.v_print_all_leger', compact('mapel','semester',
        'results','dataBaru'));
        
       
    }
}
