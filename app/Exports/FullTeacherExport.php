<?php

namespace App\Exports;

use App\Exports\Sheet\StudyClassSheet;
use App\Exports\Sheet\TemplateTeacherSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullTeacherExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new TemplateTeacherSheet();
        $sheets[] = new StudyClassSheet();

        return $sheets;
    }
}
