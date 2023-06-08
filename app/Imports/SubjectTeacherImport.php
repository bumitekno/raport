<?php

namespace App\Imports;

use App\Models\Course;
use App\Models\StudyClass;
use App\Models\SubjectTeacher;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class SubjectTeacherImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    use Importable;

    protected $slug_course;

    public function __construct($slug_course)
    {
        $this->slug_course = $slug_course;
    }

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        $study_class = StudyClass::where('slug', $row['code_study_class'])->first();
        $teacher = Teacher::where('slug', $row['code_teacher'])->first();
        $course = Course::where('slug', $this->slug_course)->first();


        $subjectTeacher = SubjectTeacher::where('id_teacher', $teacher->id)
            ->where('id_course', $course->id)
            ->where('id_school_year', session('id_school_year'))
            ->where('status', 1)
            ->first();

        if ($subjectTeacher) {
            $studyClassIds = json_decode($subjectTeacher->id_study_class, true) ?? [];

            // Cek apakah id_study_class sudah ada di dalam array
            if (!in_array(strval($study_class->id), $studyClassIds)) {
                // Tambahkan id_study_class ke dalam array
                $studyClassIds[] = strval($study_class->id);

                // Update data SubjectTeacher dengan id_study_class baru
                $subjectTeacher->update([
                    'id_study_class' => json_encode($studyClassIds),
                ]);
            }
        } else {
            // Buat data baru di tabel SubjectTeacher
            $subjectTeacher = SubjectTeacher::create([
                'id_teacher' => $teacher->id,
                'id_course' => $course->id,
                'id_school_year' => session('id_school_year'),
                'id_study_class' => json_encode([strval($study_class->id)]),
                'status' => 1,
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'code_teacher' => 'required|exists:teachers,slug',
            'code_study_class' => 'required|exists:study_classes,slug',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code_teacher.required' => 'Inputan Kode guru pada guru pelajaran harus diisi ',
            'code_teacher.exists' => 'Inputan Kode guru tidak terdaftar di sekolah ',
            'code_study_class.required' => 'Inputan Kode rombel pada guru pelajaran harus diisi ',
            'code_study_class.exists' => 'Inputan Kode rombel tidak terdaftar di sekolah ',
        ];
    }
}
