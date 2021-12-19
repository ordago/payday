<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return 422 if email is invalid', function (?string $email) {
    Employee::factory([
        'email' => 'taken@example.com',
    ])->create();

    postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => $email,
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
})->with([
    'taken@example.com',
    'invalid',
    null,
    '',
]);

it('should return 422 if payment type is invalid', function () {
    postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'invalid',
        'salary' => 75000 * 100,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
});

it('should return 422 if salary or hourly rate missing', function (string $paymentType, ?int $salary, ?int $hourlyRate) {
    postJson(route('employees.store'), [
        'fullName' => 'Test Employee',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => $paymentType,
        'salary' => $salary,
        'hourlyRate' => $hourlyRate,
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
})->with([
    ['paymentType' => 'salary', 'salary' => null, 'hourlyRate' => 30 * 100],
    ['paymentType' => 'salary', 'salary' => 0, 'hourlyRate' => null],
    ['paymentType' => 'hourlyRate', 'salary' => 75000 * 100, 'hourlyRate' => null],
    ['paymentType' => 'hourlyRate', 'salary' => null, 'hourlyRate' => 0],
]);

it('should store an employee with payment type salary', function () {
    $employee = postJson(route('employees.store'), [
        'fullName' => 'John Doe',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ])->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('test@example.com')
        ->attributes->jobTitle->toBe('BE Developer')
        ->attributes->payment->type->toBe('salary')
        ->attributes->payment->amount->toBe(75000 * 100);
});

it('should store an employee with payment type hourly rate', function () {
    $employee = postJson(route('employees.store'), [
        'fullName' => 'John Doe',
        'email' => 'test@example.com',
        'departmentId' => Department::factory()->create()->uuid,
        'jobTitle' => 'BE Developer',
        'paymentType' => 'hourlyRate',
        'hourlyRate' => 30 * 100,
    ])->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('test@example.com')
        ->attributes->jobTitle->toBe('BE Developer')
        ->attributes->payment->type->toBe('hourlyRate')
        ->attributes->payment->amount->toBe(30 * 100);
});
