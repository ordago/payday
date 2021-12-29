<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return 422 if the email is invalid', function (?string $email) {
    Employee::factory([
        'email' => 'taken@gmail.com',
    ])->create();

    postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => $email,
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 50000 * 100,
    ])->assertInvalid(['email']);
})->with([
    '',
    null,
    'taken@gmail.com',
    'invalid',
]);

it('should return 422 if the payment type is invalid', function () {
    postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'email@email.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'invalid',
        'salary' => 50000 * 100,
    ])->assertInvalid(['paymentType']);
});

it('should store an employee with salary', function () {
    $employee = postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'email@email.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 50000 * 100,
    ])->json('data');

    expect($employee)
        ->full_name->toBe('Test Employee')
        ->email->toBe('email@email.com')
        ->job_title->toBe('BE Developer')
        ->payment_type->toBe('salary')
        ->salary->toBe(50000 * 100);
});

it('should store an employee with hourly rate', function () {
    $employee = postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'email@email.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'hourlyRate',
        'hourlyRate' => 30 * 100,
    ])->json('data');

    expect($employee)
        ->full_name->toBe('Test Employee')
        ->email->toBe('email@email.com')
        ->job_title->toBe('BE Developer')
        ->payment_type->toBe('hourlyRate')
        ->hourly_rate->toBe(30 * 100);
});
