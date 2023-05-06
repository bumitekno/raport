<?php

namespace App\Exports\Sheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class SubjectTeacherSheet implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        return view('export.v_ex_subject_teacher');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text.");
        $sheet->mergeCells('A4:M4')->setCellValue('A4', "2. Isi pada kolom yang disediakan.");
        $sheet->mergeCells('A5:M5')->setCellValue('A5', "3. Isi jam pada kolom yang sudah disediakan.");
        $sheet->mergeCells('A6:M6')->setCellValue('A6', "4. Isi Kode Rombel bisa dilihat pada Sheet Rombel.");
        $sheet->mergeCells('A7:M7')->setCellValue('A7', "5. Isi Kode Guru bisa dilihat pada Sheet Guru.");
        $sheet->mergeCells('A8:M8')->setCellValue('A8', "6. Pastikan Kode Rombel, Kode Guru terdaftar pada sekolah.");
        $sheet->mergeCells('A10:M10');
        $sheet->getStyle('A11:N11')->getFont()->setBold(true);

        $sheet->getStyle('A11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        $sheet->getStyle('B11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        $sheet->getStyle('A11:B100')->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => '000000']
                ],
            ],
        ]);

        $sheet->getRowDimension(1)->setVisible(false);
        $sheet->getStyle('A2:S10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('FFFFFF00');
        $sheet->getStyle('A10:S10')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
            ->getStartColor()->setARGB('80ff0000');
        $sheet->getTabColor()->setRGB('FFFFFF00');
    }
}
