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
        $data = [];

        $rombel = DB::table('master_rombels as mr')
            ->join('master_kelas as mk', 'mk.id', '=', 'mr.id_kelas')
            ->where('mr.id_sekolah', $this->id_sekolah)
            ->where('mr.deleted_at', '=', null)
            ->select('mr.*', 'mk.nama as kelas', 'mk.id_jurusan as jurusan_id')
            ->get();

        $jurusans = DB::table('master_jurusans')
            ->where('id_sekolah', $this->id_sekolah)
            ->where('deleted_at', '=', null)
            ->select('*')
            ->get();

        foreach ($rombel as $rom) {
            $jurusan = collect($jurusans)->where('id', $rom->jurusan_id)->first();

            $data[] = [
                'id' => $rom->id,
                'nama' => $rom->nama,
                'kelas' => $rom->kelas,
                'jurusan' => empty($jurusan) ? null : $jurusan->nama,
            ];
        }

        return view('ekport.example.master.jadwal.rombel', ['data' => $data]);
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
