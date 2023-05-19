<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\StudyClass;
use App\Models\Teacher;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\WithStartRow;

class TeacherImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow
{
    use Importable;

    public function startRow(): int
    {
        return 12;
    }

    public function model(array $row)
    {
        // Menerapkan transformasi pada data sebelum disimpan
        $type = $this->transformType($row['type']);
        $codeClass = $this->transformCodeClass($row['type'], $row['code_class']);
        $gender = $this->transformGender($row['gender']);

        // Simpan data ke dalam database
        $teacher = new Teacher([
            'type' => $type,
            'id_class' => $codeClass,
            'nip' => $row['nip'],
            'nik' => $row['nik'],
            'nuptk' => $row['nuptk'],
            'name' => $row['name'],
            'email' => $row['email'],
            'phone' => $row['phone'],
            'gender' => $gender,
            'religion' => $row['religion'],
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
            'type' => 'required|in:Wali kelas,Pelajar,Lainnya',
            'code_class' => 'nullable|required_if:*.type,Wali kelas',
            'nip' => 'required|numeric',
            'nik' => 'required|string',
            'nuptk' => 'nullable',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'gender' => 'required|in:l,p',
            'religion' => 'required|string',
            'place_of_birth' => 'required|string',
            'date_of_birth' => 'nullable',
            'address' => 'nullable',
        ];
    }

    public function customValidationMessages(): array
    {
        return [
            'type.required' => 'Tipe guru harus diisi.',
            'type.in' => 'Tipe guru tidak valid.',
            'code_class.required_if' => 'Kode Rombel wajib diisi jika tipe guru adalah Wali kelas.',
            'nip.required' => 'NIP harus diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nik.required' => 'NIK harus diisi.',
            'name.required' => 'Nama harus diisi.',
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Format email tidak valid.',
            'phone.required' => 'Nomor telepon harus diisi.',
            'gender.required' => 'Jenis kelamin harus diisi.',
            'gender.in' => 'Jenis kelamin tidak valid.',
            'religion.required' => 'Agama harus diisi.',
            'place_of_birth.required' => 'Tempat lahir harus diisi.',
        ];
    }

    private function transformType($type)
    {
        $lowercaseType = strtolower($type);
        if ($lowercaseType === 'wali kelas') {
            return 'homeroom';
        } elseif ($lowercaseType === 'pelajar') {
            return 'teacher';
        } else {
            return 'other';
        }
    }

    private function transformCodeClass($type, $codeClass)
    {
        if (strtolower($type) === 'wali kelas') {
            $study_class = StudyClass::where('slug', $codeClass)->first();
            return $study_class->id;
        }

        return null;
    }

    private function transformGender($gender)
    {
        return $gender === 'l' ? 'male' : 'female';
    }
}
