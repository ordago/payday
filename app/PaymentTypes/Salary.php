<?php

namespace App\PaymentTypes;

use App\Enums\PaymentTypes;
use App\PaymentTypes\Concerns\PaymentType;
use RuntimeException;

class Salary extends PaymentType
{
    public function type(): string
    {
        return PaymentTypes::SALARY->value;
    }

    public function amount(): int
    {
        throw_if($this->employee->salary === null, new RuntimeException('Salary cannot be null'));
        return $this->employee->salary;
    }

    public function monthlyAmount(): int
    {
        return $this->employee->salary / 12;
    }
}
