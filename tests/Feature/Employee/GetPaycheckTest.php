<?php

use App\Models\Employee;
use App\Models\Paycheck;
use App\Models\User;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return all paychecks for an employee', function () {
    $thisMonth = now()->startOfMonth();
    $lastMonth = now()->subMonth()->startOfMonth();

    $employee = Employee::factory()->create();
    Paycheck::factory()
        ->sequence(
            [
                'employee_id' => $employee,
                'net_amount' => 3000 * 100,
                'payed_at' => $thisMonth,
            ],
            [
                'employee_id' => $employee,
                'net_amount' => 2800 * 100,
                'payed_at' => $lastMonth,
            ],
        )
        ->count(2)
        ->create();

    $paychecks = getJson(route('employee-paychecks.index', compact('employee')))
        ->json('data');

    expect($paychecks)->sequence(
        fn ($paycheck) => $paycheck
            ->attributes->payedAt->toBe($thisMonth->format('Y-m-d'))
            ->attributes->netAmount->cents->toBe(3000 * 100)
            ->attributes->netAmount->dollars->toBe('$3,000.00'),

        fn ($paycheck) => $paycheck
            ->attributes->payedAt->toBe($lastMonth->format('Y-m-d'))
            ->attributes->netAmount->cents->toBe(2800 * 100)
            ->attributes->netAmount->dollars->toBe('$2,800.00')
    );
});
