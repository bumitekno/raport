<?php

namespace App\Exports\Sheet;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TemplateTeacherSheet implements FromView, ShouldAutoSize, WithStyles, WithColumnWidths
{
    public function view(): View
    {
        // dd("ping");
        return view('export.v_ex_teacher');
    }

    public function columnWidths(): array
    {
        return [
            'A' => 30,
            'B' => 30,
            'C' => 30,
            'D' => 30,
            'E' => 30,
            'F' => 30,
            'G' => 30,
            'H' => 30,
            'I' => 30,
            'J' => 30,
            'K' => 30,
            'L' => 30,
            'M' => 30,
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A2:M2');
        $sheet->mergeCells('A3:M3')->setCellValue('A3', "1. Semua cell diwajibkan menggunakan format text.");
        $sheet->mergeCells('A4:M4')->setCellValue('A4', "2. Isi pada kolom yang disediakan.");
        $sheet->mergeCells('A5:M5')->setCellValue('A5', "3. Isi jam pada kolom yang sudah disediakan.");
        $sheet->mergeCells('A6:M6')->setCellValue('A6', "4. Isi Tipe Guru dengan Pelajar, Wali kelas atau Lainnya.");
        $sheet->mergeCells('A7:M7')->setCellValue('A7', "5. Jika Tipe Guru adalah wali kelas, maka Kode Rombel wajib diisi dan bisa dilihat di sheet Rombel.");
        $sheet->mergeCells('A8:M8')->setCellValue('A8', "6. Password default untuk user adalah 123456");
        $sheet->mergeCells('A10:M10');
        $sheet->getStyle('A11:N11')->getFont()->setBold(true);

        $sheet->getStyle('A11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        $sheet->getStyle('B11')->getFont()->setBold(true)->getColor()->setARGB('D2691E');
        $sheet->getStyle('F11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');
        $sheet->getStyle('G11')->getFont()->setBold(true)->getColor()->setARGB('80ff0000');

        $sheet->getStyle('A11:M100')->applyFromArray([
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
