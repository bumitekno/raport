<?php

namespace App\Exports;

use App\Models\StudyClass;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Sheet;
use PhpOffice\PhpSpreadsheet\Style\Border;


class AllLeger implements FromView
{
    public $slug;

    public function __construct($slug)
    {
        $this->slug = $slug;
    }

    public function view(): View
    {
        $slug = $this->slug;
        $setting = json_decode(Storage::get('settings.json'), true);
        $study_class = StudyClass::where('slug', $slug)->first();
        $setting['study_class'] = $study_class->name;
        $setting['teacher'] = '';
        //dd($study_class);

        // Dapatkan siswa pada kelas tsb
        $siswa = DB::table('student_classes')
        ->where('id_study_class',$study_class->id)
        ->pluck('id_student');
 
        $student_class = DB::table('student_classes')
        ->join('study_classes','study_classes.id','student_classes.id_study_class')
        ->whereIn('student_classes.id_student',$siswa)
        ->pluck('student_classes.id');

        $score_merdeka = DB::table('users as u')
        ->select('sm.id','y.name as semester','c.name as mapel',
        'u.name as siswa','u.nis','u.id as id_student',
        'sc.year','sm.final_score')
        
        ->crossJoin('courses as c')
        ->join('student_classes as sc','sc.id_student','u.id')
        ->leftJoin('score_merdekas as sm', function($join){
            $join->on('sm.id_student_class','sc.id')
            ->on('sm.id_course','c.id');
        })
        ->join('school_years as y','y.id','sm.id_school_year')
        //->where('sc.id_study_class',$study_class->id)
        ->whereIn('u.id', function($query) use ($study_class) {
            $query->select('id_student')
                    ->from('student_classes')
                    ->where('id_study_class', $study_class->id);
        })
        ->orderBy('u.name','asc')
        ->orderBy('c.name','asc')
        //->orderBy('c.name','asc')
        ->get();

        //dd($score_merdeka);

        $score_merdeka = collect($score_merdeka);
        $semester = $score_merdeka->pluck('semester')->unique()->values();
        $mapel = $score_merdeka->pluck('mapel')->unique();
        $siswas = $score_merdeka->pluck('siswa')->unique();

        $score_merdeka = $score_merdeka->groupBy('siswa')->map(function ($group) {
            return $group->groupBy('mapel');
        });


        // Inisialisasi array baru
        $dataBaru = [];
        $dataBaru = $score_merdeka;

        $results = array(
            'setting' => $setting
        );

        return view('content.legers.v_print_all_leger', compact('mapel','semester',
        'results','dataBaru'));

    }

    public function styles(Worksheet $sheet)
    {
        // Menetapkan gaya border untuk seluruh sel dalam tabel
        $sheet->getStyle('A7:' . $sheet->getHighestColumn() . $sheet->getHighestRow())
              ->getBorders()->getAllBorders()->setBorderStyle('thin');

        // $sheet->getStyle('B7:H40')->applyFromArray([
        //     'borders' => [
        //         'allBorders' => [
        //             'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
        //             'color' => ['argb' => '000000']
        //         ],
        //     ],
        // ]);

    }
}
