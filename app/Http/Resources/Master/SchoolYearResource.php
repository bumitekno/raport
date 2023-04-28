<?php

namespace App\Http\Resources\Master;

use App\Helpers\StatusHelper;
use Illuminate\Http\Resources\Json\JsonResource;

class SchoolYearResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'school_year' => substr($this->name, 0, 9),
            'semester' => [
                'number' => substr($this->name, -1),
                'name' => StatusHelper::semester(substr($this->name, -1)),
            ],
        ];
    }


    public function toCollection($request)
    {
        return $this->collection->map(function ($item) use ($request) {
            return $item->toArray($request);
        });
    }
}
