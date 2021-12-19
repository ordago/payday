<?php

namespace App\Http\Resources;

use App\ValueObjects\Money;
use Illuminate\Http\Resources\Json\JsonResource;

class PaycheckResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->uuid,
            'type' => 'paychecks',
            'attributes' => [
                'payedAt' => $this->payed_at,
                'netAmount' => [
                    'cents' => $this->net_amount,
                    'dollars' => Money::from($this->net_amount)->toDollars(),
                ],
            ],
            'included' => [
                'employee' => new EmployeeResource($this->whenLoaded('employee')),
            ],
        ];
    }
}
