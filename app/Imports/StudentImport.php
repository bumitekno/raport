<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\StudyClass;
use App\Models\User;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class StudentImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        $study_class = StudyClass::where('slug', $row['accepted_grade'])->first();
        $gender = $this->transformGender($row['gender']);

        // Simpan data ke dalam database
        $teacher = new User([
            'accepted_grade' => $study_class->id,
            'name' => $row['name'],
            'email' => $row['email'],
            'nis' => $row['nis'],
            'nisn' => $row['nisn'],
            'gender' => $gender,
            'religion' => $row['religion'],
            'phone' => $row['phone'],
            'place_of_birth' => $row['place_of_birth'],
            'date_of_birth' => $row['date_of_birth'],
            'address' => $row['address'],
            'password' => 123456,
            'slug' => str_slug($row['name']) . '-' . Helper::str_random(5)
        ]);

        return $teacher;
    }

    public function rules(): array
    {
        return [
            'accepted_grade' => 'required',
            'name' => 'required|string',
            'email' => 'required|email',
            'nis' => 'required|numeric',
            'nisn' => 'required|string',
            'gender' => 'required|in:l,p',
            'religion' => 'required|string',
            'phone' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'nullable',
            'address' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'accepted_grade.required' => 'Kelas diterima harus diisi.',
            'name.required' => 'Nama harus diisi.',
            'nis.required' => 'NIS harus diisi.',
            'nis.numeric' => 'NIS harus berupa angka.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'nisn.required' => 'NISN harus diisi.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'religion.required' => 'Agama harus diisi.',
            'place_of_birth.required' => 'Tempat lahir harus diisi.',
        ];
    }

    private function transformGender($gender)
    {
        return $gender === 'l' ? 'male' : 'female';
    }
}
