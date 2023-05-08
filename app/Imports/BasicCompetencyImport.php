<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\BasicCompetency;
use App\Models\Course;
use App\Models\Level;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class BasicCompetencyImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    use Importable;

    // protected $slug_course;

    // public function __construct($slug_course)
    // {
    //     $this->slug_course = $slug_course;
    // }

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        // dd($row);
        $level = Level::where('slug', $row['code_level'])->first();
        $course = Course::where('slug', $row['code_course'])->first();
        $name = [
            'code' => $row['code'],
            'name' => $row['name']
        ];
        BasicCompetency::create([
            'id_level' => $level->id,
            'id_course' => $course->id,
            'name' => json_encode($name),
            'slug' => str_slug($row['name']) . '-' . Helper::str_random(5),
            'status' => 1,
        ]);
    }

    public function rules(): array
    {
        return [
            'code_level' => 'required|exists:levels,slug',
            'code_course' => 'required|exists:courses,slug',
            'code' => 'required',
            'name' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code_level.required' => 'Inputan Kode Tingkat harus diisi ',
            'code_level.exists' => 'Inputan Kode Tingkat tidak terdaftar di sekolah ',
            'code_course.required' => 'Inputan Kode Mapel harus diisi ',
            'code_course.exists' => 'Inputan Kode mapel tidak terdaftar di sekolah ',
            'code.required' => 'Inputan Kode kompetensi harus diisi ',
            'name.required' => 'Inputan Nama kompetensi harus diisi ',
        ];
    }
}
