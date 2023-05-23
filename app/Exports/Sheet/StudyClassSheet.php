<?php

namespace App\Exports\Sheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class StudyClassSheet implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        $studyClasses = DB::table('study_classes')
            ->select('study_classes.id', 'study_classes.slug', 'study_classes.name', 'majors.name as major', 'levels.name as level', 'study_classes.status')
            ->join('majors', 'study_classes.id_major', '=', 'majors.id')
            ->join('levels', 'study_classes.id_level', '=', 'levels.id')
            ->whereNull('study_classes.deleted_at')
            ->where('study_classes.status', '=', 1)
            ->get();

        return view('export.sheets.v_study_class_sheet', ['data' => $studyClasses]);
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "Daftar Rombel yang ada di sekolah.");
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A3:K3')->getFont()->setBold(true);
        $sheet->getStyle('A5:K5')->getFont()->setBold(true);

        // style cells
        $sheet->getStyle('A5:D300')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:K4')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $sheet->getTabColor()->setRGB('FF0000');
    }
}
