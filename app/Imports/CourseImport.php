<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\Course;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Contracts\Validation\Validator;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class CourseImport implements ToModel, WithHeadingRow, WithValidation, WithStartRow, SkipsOnError
{
    use Importable;

    public function startRow(): int
    {
        return 7;
    }

    public function model(array $row)
    {
        return new Course([
            'code' => $row['code'],
            'name' => $row['name'],
            'group' => $row['group'],
            'slug' => str_slug($row['name']) . '-' . Helper::str_random(5)
        ]);
    }

    public function rules(): array
    {
        return [
            'code' => 'required|min:1',
            'name' => 'required|min:3',
            'group' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'name.min' => 'Inputan nama mata pelajaran minimal 3 karakter ',
            'code.min' => 'Inputan kode mata pelajaran minimal 1 karakter ',
            'code.required' => 'Inputan kode mata pelajaran harus diisi ',
            'name.required' => 'Inputan nama pelajaran harus diisi ',
            'group.required' => 'Inputan kelompok pelajaran harus diisi ',
        ];
    }

    public function onError(\Throwable $e)
    {
        echo "Terjadi kesalahan pada baris ke-{$e->skippedCount}: " . $e->getMessage() . PHP_EOL;
    }
}
