<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;
use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should update an employee', function () {
    $development = Department::factory([
        'name' => 'Development',
    ])->create();

    $employee = Employee::factory([
        'full_name' => 'Test Employee',
        'email' => 'test@example.com',
        'department_id' => $development,
        'job_title' => 'BE Developer',
    ])->create();

    putJson(route('employees.update', ['employee' => $employee]), [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'departmentId' => $development->uuid,
        'jobTitle' => 'Senior BE Developer',
        'paymentType' => 'hourlyRate',
        'hourlyRate' => 30 * 100,
    ])->assertStatus(Response::HTTP_NO_CONTENT);

    $employee = getJson(route('employees.show', compact('employee')))
        ->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('john@example.com')
        ->attributes->jobTitle->toBe('Senior BE Developer')
        ->attributes->payment->type->toBe('hourlyRate')
        ->attributes->payment->amount->toBe(30 * 100);
});
