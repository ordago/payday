<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DepartmentResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'type' => 'departments',
            'attributes' => [
                'name' => $this->name,
                'description' => $this->description,
            ],
        ];
    }
}
