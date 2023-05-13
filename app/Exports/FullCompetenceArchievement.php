<?php

namespace App\Exports;

use App\Exports\Sheet\CompetenceArhievementSheet;
use App\Exports\Sheet\TypeCompetenceSheet;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FullCompetenceArchievement implements WithMultipleSheets
{
    use Exportable;

    public function sheets(): array
    {
        $sheets = [];

        $sheets[] = new CompetenceArhievementSheet();
        $sheets[] = new TypeCompetenceSheet();

        return $sheets;
    }
}
