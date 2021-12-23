<?php

namespace App\PaymentTypes;

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\PaymentTypes\Concerns\PaymentType;
use RuntimeException;

class Salary extends PaymentType
{
    public function __construct(Employee $employee)
    {
        throw_if($employee->salary === null, new RuntimeException('Hourly rate cannot be null'));
        parent::__construct($employee);
    }

    public function type(): string
    {
        return PaymentTypes::SALARY->value;
    }

    public function amount(): int
    {
        return $this->employee->salary;
    }

    public function monthlyAmount(): int
    {
        return $this->employee->salary / 12;
    }
}
