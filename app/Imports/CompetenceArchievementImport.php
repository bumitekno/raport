<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\CompetenceAchievement;
use App\Models\Course;
use App\Models\StudyClass;
use App\Models\Teacher;
use App\Models\TypeCompetenceAchievement;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class CompetenceArchievementImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    use Importable;

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

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        // dd(session()->all());
        $study_class = StudyClass::where('slug', $this->code_study_class)->first();
        $teacher = Teacher::where('slug', $this->code_teacher)->first();
        $course = Course::where('slug', $this->code_course)->first();
        $type = TypeCompetenceAchievement::where('slug', $row['code_type_competence'])->first();
        CompetenceAchievement::create([
            'id_type_competence' => $type->id,
            'id_course' => $course->id,
            'id_study_class' => $study_class->id,
            'id_teacher' => $teacher->id,
            'id_school_year' => $this->id_school_year,
            'code' => $row['code'],
            'achievement' => $row['achievement'],
            'description' => $row['description'],
            'slug' => str_slug($row['achievement']) . '-' . Helper::str_random(5),
            'status' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'code_type_competence' => 'required|exists:type_competence_achievements,slug',
            'code' => 'required',
            'achievement' => 'required',
            'description' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code_type_competence.required' => 'Inputan Kode Tipe Kompetensi pada kompetensi harus diisi ',
            'code_type_competence.exists' => 'Inputan Kode Tipe Kompetensi tidak terdaftar di sekolah ',
            'code.required' => 'Inputan Kode harus diisi ',
            'achievement.required' => 'Inputan Kompetensi harus diisi ',
        ];
    }
}
