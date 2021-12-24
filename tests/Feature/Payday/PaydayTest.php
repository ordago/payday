<?php

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\Timelog;
use App\Models\User;
use Carbon\Carbon;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should create paychecks for salary employees', function () {
    $employees = Employee::factory()
        ->count(2)
        ->sequence(
            ['salary' => 50000 * 100, 'payment_type' => PaymentTypes::SALARY->value],
            ['salary' => 70000 * 100, 'payment_type' => PaymentTypes::SALARY->value],
        )
        ->create();

    postJson(route('payday.store'))
        ->assertNoContent();

    $this->assertDatabaseHas('paychecks', [
        'employee_id' => $employees[0]->id,
        'net_amount' => 416666,
    ]);
    $this->assertDatabaseHas('paychecks', [
        'employee_id' => $employees[1]->id,
        'net_amount' => 583333,
    ]);
});

it('should create paychecks for hourly rate employees', function () {
    $this->travelTo(Carbon::parse('2022-02-10'), function () {
        $employee = Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        $dayBeforeYesterday = now()->subDays(2);
        $yesterday = now()->subDay();
        $today = now();

        Timelog::factory()
            ->count(3)
            ->sequence(
                ['employee_id' => $employee, 'minutes' => 90, 'started_at' => $dayBeforeYesterday, 'stopped_at' => $dayBeforeYesterday->copy()->addMinutes(90)],
                ['employee_id' => $employee, 'minutes' => 15, 'started_at' => $yesterday, 'stopped_at' => $yesterday->copy()->addMinutes(15)],
                ['employee_id' => $employee, 'minutes' => 51, 'started_at' => $today, 'stopped_at' => $today->copy()->addMinutes(51)],
            )
            ->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        $this->assertDatabaseHas('paychecks', [
            'employee_id' => $employee->id,
            'net_amount' => 30 * 100,
        ]);
    });
});

it('should create paychecks for hourly rate employees only for current month', function () {
    $this->travelTo(Carbon::parse('2022-02-10'), function () {
        $employee = Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        Timelog::factory()
            ->count(2)
            ->sequence(
                ['employee_id' => $employee, 'minutes' => 60, 'started_at' => now()->subMonth(), 'stopped_at' => now()->subMonth()->addMinutes(60)],
                ['employee_id' => $employee, 'minutes' => 60, 'started_at' => now(), 'stopped_at' => now()->addMinutes(60)],
            )
            ->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        $this->assertDatabaseHas('paychecks', [
            'employee_id' => $employee->id,
            'net_amount' => 10 * 100,
        ]);
    });
});

it('should not create paychecks for hourly rate employees without time logs', function () {
    $this->travelTo(Carbon::parse('2022-02-10'), function () {
        Employee::factory([
            'hourly_rate' => 10 * 100,
            'payment_type' => PaymentTypes::HOURLY_RATE->value,
        ])->create();

        postJson(route('payday.store'))
            ->assertNoContent();

        $this->assertDatabaseCount('paychecks', 0);
    });
});
