<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class StudentClassResource extends JsonResource
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
            'uid' => $this->student_classes_key,
            'uid_siswa' => $this->key,
            'uid_rombel' => $this->sc_key,
            'nama_siswa' => $this->name,
            'nis' => $this->nis,
            'nisn' => $this->nisn,
            'rombel' => $this->sc_name,
            'tahun' => $this->year,
        ];
    }
}
