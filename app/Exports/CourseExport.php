<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class CourseExport implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    // public function __construct()
    // {
    //     $this->sheet_title = 'Data Mapel';
    // }

    public function view(): View
    {
        return view('export.v_ex_course');
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
        $sheet->mergeCells('A2:c2');
        $sheet->mergeCells('A3:c3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text");
        $sheet->mergeCells('A4:c4')->setCellValue('A4', "2. Isi pada tabel yang sudah disediakan.");
        $sheet->mergeCells('A5:c5');
        $sheet->getStyle('A6:C6')->getFont()->setBold(true);

        $sheet->getStyle('A6:C6')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        // style cells
        $sheet->getStyle('A6:C40')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:c5')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
    }
}
