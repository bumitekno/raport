<?php

namespace App\Exports\Sheet;

use App\Models\Teacher;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class TeacherSheet implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        $teachers = Teacher::where('status', 1)->get();
        // dd($teachers);
        return view('export.sheets.v_teacher_sheet', ['data' => $teachers]);
    }

    public function styles(Worksheet $sheet)
    {
        // merge cells
        $sheet->mergeCells('A2:K2');
        $sheet->mergeCells('A3:K3')->setCellValue('A3', "Daftar Guru yang ada di sekolah.");
        $sheet->mergeCells('A4:K4');
        $sheet->getStyle('A3:K3')->getFont()->setBold(true);
        $sheet->getStyle('A5:K5')->getFont()->setBold(true);
        // $sheet->getStyle('G10:J10')->getFont()->setBold(true);

        // style cells
        $sheet->getStyle('A5:E300')->applyFromArray([
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
