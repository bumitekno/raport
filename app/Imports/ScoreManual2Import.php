<?php

namespace App\Imports;

use App\Helpers\Helper;
use App\Models\PredicatedScore;
use App\Models\ScoreManual2;
use App\Models\StudentClass;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\SkipsOnError;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithValidation;

class ScoreManual2Import implements ToModel, WithHeadingRow, WithValidation, WithStartRow, SkipsOnError
{
    use Importable;

    public function startRow(): int
    {
        return 7;
    }

    public function model(array $row)
    {
        $studentClass = StudentClass::where('slug', $row['code'])->first();

        if (!$studentClass) {
            throw new \Exception("Kode siswa tidak valid untuk baris ke-{$this->getRowCount()}");
        }

        $id_student_class = $studentClass->id;
        $score = ScoreManual2::where([
            ['id_student_class', $id_student_class],
            ['id_study_class', session('teachers.id_study_class')],
            ['id_teacher', Auth::guard('teacher')->user()->id],
            ['id_course', session('teachers.id_course')],
            ['id_school_year', session('id_school_year')]
        ])->first();

        $predicate_assegment = $row['predicate_assegment'] ?? null;
        if (!$predicate_assegment) {
            $final_assegment = $row['final_assegment'];
            $predicatedAssegment = PredicatedScore::where('score', '<=', $final_assegment)
                ->orderBy('score', 'DESC')
                ->first();

            if ($predicatedAssegment) {
                $predicate_assegment = $predicatedAssegment->name;
            }
        }

        $predicate_skill = $row['predicate_skill'] ?? null;
        if (!$predicate_skill) {
            $final_skill = $row['final_skill'];
            $predicatedSkill = PredicatedScore::where('score', '<=', $final_skill)
                ->orderBy('score', 'DESC')
                ->first();

            if ($predicatedSkill) {
                $predicate_skill = $predicatedSkill->name;
            }
        }

        return ScoreManual2::updateOrCreate(
            [
                'id_student_class' => $id_student_class,
                'id_teacher' => Auth::guard('teacher')->user()->id,
                'id_study_class' => session('teachers.id_study_class'),
                'id_course' => session('teachers.id_course'),
                'id_school_year' => session('id_school_year'),
            ],
            [
                'final_assegment' => $row['final_assegment'],
                'final_skill' => $row['final_skill'],
                'predicate_skill' => $predicate_skill ?? $score->predicate_skill,
                'predicate_assegment' => $predicate_assegment
            ]
        );
    }

    public function rules(): array
    {
        return [
            'code' => 'required|min:1',
            'kkm' => 'nullable|min:1',
            'final_assegment' => 'required',
            'final_skill' => 'required',
            'predicate_assegment' => 'nullable',
            'predicate_skill' => 'nullable',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'code.required' => 'Kode diperlukan.',
            'code.min' => 'Kode harus minimal :min karakter.',
            'kkm.min' => 'KKM harus minimal :min karakter.',
            'final_assegment.required' => 'Nilai penilaian akhir pengetahuan diperlukan.',
            'final_skill.required' => 'Nilai penilaian akhir ketrampilan diperlukan.',
            'predicate_assegment.required' => 'Predikat penilaian akhir pengetahuan diperlukan.',
            'final_skill.required' => 'Predikat penilaian akhir ketrampilan diperlukan.',
        ];
    }

    public function onError(\Throwable $e)
    {
        echo "Terjadi kesalahan pada baris ke-{$e->skippedCount}: " . $e->getMessage() . PHP_EOL;
    }
}
