<?php

namespace App\Http\Resources;

use App\ValueObjects\Amount;
use Illuminate\Http\Request;
use TiMacDonald\JsonApi\JsonApiResource;

class PaycheckResource extends JsonApiResource
{
    public function toAttributes(Request $request): array
    {
        return [
            'payedAt' => $this->payed_at->format('Y-m-d'),
            'netAmount' => Amount::from($this->net_amount)->toArray(),
        ];
    }

    public function toRelationships(Request $request): array
    {
        return [
            'employee' => fn () => new EmployeeResource($this->employee),
        ];
    }
}
