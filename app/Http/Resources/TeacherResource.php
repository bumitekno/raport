<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TeacherResource extends JsonResource
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
            'slug' => $this->slug,
            'nip' => $this->nip,
            'nik' => $this->nik,
            'nuptk' => $this->nuptk,
            'name' => $this->name,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'file' => empty($this->file) ? null : asset($this->file),
            'phone' => $this->phone,
            'email' => $this->email,
            'place_of_birth' => $this->place_of_birth,
            'date_of_birth' => $this->date_of_birth,
            'address' => $this->address,
            'type' => $this->type,
            'id_class' => $this->id_class,
            'status' => $this->status,
        ];
    }
}
