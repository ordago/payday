<?php

namespace App\PaymentTypes\Concerns;

use App\Models\Employee;

abstract class PaymentType
{
    public function __construct(protected readonly Employee $employee)
    {
    }

    abstract public function type(): string;
    abstract public function amount(): int;
    abstract public function monthlyAmount(): int;
}
