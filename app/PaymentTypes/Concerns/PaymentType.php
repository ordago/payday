<?php

namespace App\PaymentTypes\Concerns;

use App\Models\Employee;

abstract class PaymentType
{
    public function __construct(protected readonly Employee $employee)
    {
    }

    // TODO: method that calculates how much is the employee's salary
}
