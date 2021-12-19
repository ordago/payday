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
                'payment' => [
                    'type' => $this->payment_type->type(),
                    'amount' => $this->payment_type->amount(),
                ],
            ],
            'included' => [
                'department' => new DepartmentResource($this->whenLoaded('department')),
            ],
        ];
    }
}
