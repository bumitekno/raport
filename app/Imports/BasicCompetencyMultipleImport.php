<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class BasicCompetencyMultipleImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new BasicCompetencyImport()
        ];
    }
}
