<?php

namespace App\Exports;

use App\Exports\Sheet\StudyClassSheet;
use App\Exports\Sheet\SubjectTeacherSheet;
use App\Exports\Sheet\TeacherSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullSubjectTeacherExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new SubjectTeacherSheet();
        $sheets[] = new StudyClassSheet();
        $sheets[] = new TeacherSheet();

        return $sheets;
    }
}
