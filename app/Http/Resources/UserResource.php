<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
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
            'name' => $this->name,
            'email' => $this->email,
            'nis' => $this->nis,
            'nisn' => $this->nisn,
            'gender' => $this->gender,
            'religion' => $this->religion,
            'file' => empty($this->file) ? null : asset($this->file),
            'phone' => $this->phone,
            'date_of_birth' => $this->date_of_birth,
            'place_of_birth' => $this->place_of_birth,
            'address' => $this->address,
            'family_status' => $this->family_status,
            'child_off' => $this->child_off,
            'school_from' => $this->school_from,
            'accepted_grade' => $this->accepted_grade,
            'accepted_date' => $this->accepted_date,
            'entry_year' => $this->entry_year,
            'status' => $this->status,
        ];
    }
}
