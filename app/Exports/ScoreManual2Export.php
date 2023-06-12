<?php

namespace App\Exports;

use App\Models\Config;
use App\Models\Kkm;
use App\Models\ScoreManual2;
use App\Models\StudentClass;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ScoreManual2Export implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        $students = StudentClass::join('users', 'student_classes.id_student', '=', 'users.id')
            ->select('student_classes.id', 'student_classes.slug', 'student_classes.id_student', 'student_classes.status',  'student_classes.year', 'users.name', 'users.gender', 'users.file', 'users.email', 'users.nis')
            ->where([
                ['id_study_class', session('teachers.id_study_class')],
                ['year', session('year')],
                ['student_classes.status', 1],
            ])->get();
        $config = Config::where([
            ['id_school_year', session('id_school_year')],
            ['status', 1]
        ])->first();
        $status_form = true;
        if (!empty($config) && $config->closing_date != null) {
            $closing_date = Carbon::parse($config->closing_date)->startOfDay();
            if ($closing_date < now()->startOfDay()) {
                $status_form = false;
            }
        }
        $kkm = Kkm::where([
            ['id_study_class', session('teachers.id_study_class')],
            ['id_course', session('teachers.id_course')],
            ['id_school_year', session('id_school_year')],
        ])->first();

        $result = [];
        foreach ($students as $student) {
            $score = ScoreManual2::where([
                ['id_student_class', $student->id],
                ['id_study_class', session('teachers.id_study_class')],
                ['id_teacher', Auth::guard('teacher')->user()->id],
                ['id_course', session('teachers.id_course')],
                ['id_school_year', session('id_school_year')]
            ])->first();

            $result[] = [
                'code' => $student->slug,
                'name' => $student->name,
                'nis' => $student->nis,
                'id_school_year' => session('id_school_year'),
                'kkm' => $kkm ? $kkm->score : null,
                'final_assegment' => $score ? $score->final_assegment : null,
                'final_skill' => $score ? $score->final_skill : null,
                'predicate_assegment' => $score ? $score->predicate_assegment : null,
                'predicate_skill' => $score ? $score->predicate_skill : null,
            ];
        }
        // dd($result);
        return view('export.v_ex_scorev2', compact('result'));
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 50,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:h2');
        $sheet->mergeCells('A3:h3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text");
        $sheet->mergeCells('A4:h4')->setCellValue('A4', "2. Isi pada tabel yang sudah disediakan.");
        $sheet->mergeCells('A5:h5');
        $sheet->getStyle('A6:H6')->getFont()->setBold(true);

        $sheet->getStyle('A6:C6')->getFont()->setBold(true)->getColor()->setARGB('000000');
        $sheet->getStyle('D6:H6')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        // style cells
        $sheet->getStyle('A6:H40')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:H5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
    }
}
