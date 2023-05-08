<?php

namespace App\Exports\Sheet;

use App\Models\Course;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CourseSheet implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        $courses = Course::where('status', 1)->get();
        return view('export.sheets.v_course_sheet', ['data' => $courses]);
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "Daftar Pelajaran yang ada di sekolah.");
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A3:K3')->getFont()->setBold(true);
        $sheet->getStyle('A5:K5')->getFont()->setBold(true);

        // style cells
        $sheet->getStyle('A5:C300')->applyFromArray([
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
