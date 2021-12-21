<?php

namespace App\Http\Resources;

use App\ValueObjects\Amount;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class EmployeeResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'fullName' => $this->full_name,
            'email' => $this->email,
            'jobTitle' => $this->job_title,
            'payment' => [
                'type' => $this->payment_type->type(),
                'amount' => Amount::from($this->payment_type->amount())->toArray(),
            ],
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'department' => fn () => new DepartmentResource($this->department),
            'paychecks' => fn () => PaycheckResource::collection($this->paychecks),
        ];
    }

    public function toLinks(Request $request): array
    {
        return [
            'self' => route('employees.show', ['employee' => $this->uuid]),
        ];
    }
}
