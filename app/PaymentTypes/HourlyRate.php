<?php

namespace App\PaymentTypes;

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\Timelog;
use App\PaymentTypes\Concerns\PaymentType;
use RuntimeException;

class HourlyRate extends PaymentType
{
    public function __construct(Employee $employee)
    {
        throw_if($employee->hourly_rate === null, new RuntimeException('Hourly rate cannot be null'));
        parent::__construct($employee);
    }

    public function type(): string
    {
        return PaymentTypes::HOURLY_RATE->value;
    }

    public function amount(): int
    {
        return $this->employee->hourly_rate;
    }

    public function monthlyAmount(): int
    {
        $hoursWorked = Timelog::query()
            ->whereBetween('stopped_at', [now()->startOfMonth(), now()->endOfMonth()])
            ->sum('minutes') / 60;

        return $hoursWorked * $this->employee->hourly_rate;
    }
}
