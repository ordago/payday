<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class EmployeeResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'type' => 'employees',
            'attributes' => [
                'fullName' => $this->full_name,
                'email' => $this->email,
                'jobTitle' => $this->job_title,
            ],
            'included' => [
                'department' => new DepartmentResource($this->whenLoaded('department')),
            ],
        ];
    }
}
