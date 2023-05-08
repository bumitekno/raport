<?php

namespace App\Exports;

use App\Exports\Sheet\BasicCompetencySheet;
use App\Exports\Sheet\CourseSheet;
use App\Exports\Sheet\LevelSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullBasicCompetencyExport implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new BasicCompetencySheet();
        $sheets[] = new CourseSheet();
        $sheets[] = new LevelSheet();

        return $sheets;
    }
}
