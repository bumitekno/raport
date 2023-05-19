<?php

namespace App\Exports;

use App\Exports\Sheet\StudyClassSheet;
use App\Exports\Sheet\TemplateStudentSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullStudentExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new TemplateStudentSheet();
        $sheets[] = new StudyClassSheet();

        return $sheets;
    }
}
