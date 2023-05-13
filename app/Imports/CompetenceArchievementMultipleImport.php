<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class CompetenceArchievementMultipleImport implements WithMultipleSheets
{
    protected $code_course;
    protected $code_study_class;
    protected $code_teacher;
    protected $id_school_year;

    public function __construct($code_course, $code_study_class, $code_teacher, $id_school_year)
    {
        $this->code_course = $code_course;
        $this->code_study_class = $code_study_class;
        $this->code_teacher = $code_teacher;
        $this->id_school_year = $id_school_year;
    }

    public function sheets(): array
    {
        return [
            new CompetenceArchievementImport($this->code_course, $this->code_study_class, $this->code_teacher, $this->id_school_year)
        ];
    }
}
