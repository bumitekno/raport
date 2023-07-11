<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectTeacherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'uid' => $this->key,
            'uid_guru' => empty($this->teacher) ? null : $this->teacher->key,
            'uid_ta_sm' => empty($this->school_year) ? null : $this->school_year->key,
            'uid_rombel' => empty($this->study_class) ? null : $this->study_class->key,
            'uid_mapel' => empty($this->course) ? null : $this->course->key,
            'nama_guru' => empty($this->teacher) ? null : $this->teacher->name,
            'nama_ta' => empty($this->school_year) ? null : substr($this->school_year->name, 0, 9),
            'semester' => empty($this->school_year) ? null : substr($this->school_year->name, -1),
            'nama_rombel' => empty($this->study_class) ? null : $this->study_class->name,
            'nama_mapel' => empty($this->course) ? null : $this->course->name,
            'kode_mapel' => empty($this->course) ? null : $this->course->code,
        ];
    }
}
