<?php

use App\Enums\PaymentTypes;
use App\Models\Employee;
use App\Models\User;

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
