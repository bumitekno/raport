<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubjectTeacherWithJoinResource extends JsonResource
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
            'uid_guru' => $this->uid_guru,
            'uid_ta_sm' => $this->uid_ta_sm,
            'uid_rombel' => $this->uid_rombel,
            'uid_mapel' => $this->uid_mapel,
            'nama_guru' => $this->nama_guru,
            'nama_ta' => substr($this->ta_sm, 0, 9),
            'semester' => substr($this->ta_sm, -1),
            'nama_rombel' => $this->nama_rombel,
            'nama_mapel' => $this->nama_mapel,
            'kode_mapel' => $this->kode_mapel,
        ];
    }
}
