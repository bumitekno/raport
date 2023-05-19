<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class StudentMultipleImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new StudentImport()
        ];
    }
}
