<?php

use App\Models\Employee;
use App\Models\User;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return all employees', function () {
    Employee::factory()->count(5)->create();

    $employees = getJson(route('employees.index'))
        ->json('data');

    expect($employees)->toHaveCount(5);
});

it('should filter employees', function () {
    Employee::factory()->count(4)->create();

    $john = Employee::factory([
        'full_name' => 'Test John Doe',
    ])->create();

    $employees = getJson(
        route('employees.index', [
            'filter' => [
                'full_name' => 'Test',
            ]
        ]))
        ->json('data');

    expect($employees)->toHaveCount(1);
    expect($employees[0])->id->toBe($john->uuid);
});
