<?php

namespace App\Actions;

use App\Models\Employee;
use Illuminate\Support\Facades\DB;

class PaydayAction
{
    public function execute(): void
    {
        DB::transaction(function () {
            foreach (Employee::all() as $employee) {
                $employee->paychecks()->create([
                    'net_amount' => $employee->payment_type->monthlyAmount(),
                    'payed_at' => now(),
                ]);
            }
        });
    }
}
