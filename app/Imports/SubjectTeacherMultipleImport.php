<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class SubjectTeacherMultipleImport implements WithMultipleSheets
{
    protected $slug_course;

    public function __construct($slug_course)
    {
        $this->slug_course = $slug_course;
    }

    public function sheets(): array
    {
        return [
            new SubjectTeacherImport($this->slug_course)
        ];
    }
}
