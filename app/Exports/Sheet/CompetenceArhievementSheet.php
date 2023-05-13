<?php

namespace App\Exports\Sheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class CompetenceArhievementSheet implements FromView, WithStyles, ShouldAutoSize
{
    public function view(): View
    {
        return view('export.v_ex_competence_archievement');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 40,
            'B' => 30,
            'C' => 50,
            'D' => 50,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text.");
        $sheet->mergeCells('A4:M4')->setCellValue('A4', "2. Isi pada kolom yang disediakan.");
        $sheet->mergeCells('A5:M5')->setCellValue('A5', "3. Isi warna ungu dengan inputan anda.");
        $sheet->mergeCells('A6:M6')->setCellValue('A6', "4. Isi Kode Tipe Kompetensi bisa dilihat pada Sheet Tipe Kompetensi.");
        $sheet->mergeCells('A8:M8')->setCellValue('A8', "6. Pastikan Kode Tipe Kompetensi, terdaftar pada sekolah.");
        $sheet->mergeCells('A10:M10');
        $sheet->getStyle('A11:N11')->getFont()->setBold(true);

        $sheet->getStyle('A11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        $sheet->getStyle('B11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        $sheet->getStyle('C11')->getFont()->setBold(true)->getColor()->setARGB('99004C');
        $sheet->getStyle('D11')->getFont()->setBold(true)->getColor()->setARGB('000000');

        $sheet->getStyle('A11:D100')->applyFromArray([
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
