<?php

namespace App\PaymentTypes;

use App\Enums\PaymentTypes;
use App\PaymentTypes\Concerns\PaymentType;
use RuntimeException;

class HourlyRate extends PaymentType
{
    public function type(): string
    {
        return PaymentTypes::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        throw_if($this->employee->hourly_rate === null, new RuntimeException('Hourly rate cannot be null'));
        return $this->employee->hourly_rate;
    }

    public function monthlyAmount(): int
    {
        return 1;
    }
}
