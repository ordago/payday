<?php

namespace App\Http\Resources;

use App\ValueObjects\Amount;
use Illuminate\Http\Resources\Json\JsonResource;

class PaycheckResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'type' => 'paychecks',
            'attributes' => [
                'payedAt' => $this->payed_at->format('Y-m-d'),
                'netAmount' => Amount::from($this->net_amount)->toArray(),
            ],
            'included' => [
                'employee' => new EmployeeResource($this->whenLoaded('employee')),
            ],
        ];
    }
}
