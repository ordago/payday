<?php

namespace App\Actions;

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\Paycheck;

class PaydayAction
{
    public function execute(): void
    {
        foreach (Employee::all() as $employee) {
            Paycheck::create([
                'employee_id' => $employee->id,
                'net_amount' => $employee->payment_type->monthlyAmount(),
                'payed_at' => now(),
            ]);
        }
    }
}
