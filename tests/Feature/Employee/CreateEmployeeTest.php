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

it('should return 422 if payment type is salary but salary is missing', function (string $paymentType, ?int $salary, ?int $hourlyRate) {
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
    ['paymentType' => 'hourlyRate', 'hourlyRate' => null, 'salary' => 75000 * 100],
    ['paymentType' => 'hourlyRate', 'hourlyRate' => 0, 'salary' => null],
]);
