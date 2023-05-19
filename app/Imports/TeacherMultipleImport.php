<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class TeacherMultipleImport implements WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            new TeacherImport()
        ];
    }
}
