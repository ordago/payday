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

    $employee = postJson(route('employees.store'), [
        'fullName' => 'John Doe',
        'email' => 'john@example.com',
        'departmentId' => $development->uuid,
        'jobTitle' => 'Senior BE Developer',
        'paymentType' => 'salary',
        'salary' => 75000 * 100,
    ])->json('data');

    expect($employee)
        ->attributes->fullName->toBe('John Doe')
        ->attributes->email->toBe('john@example.com')
        ->attributes->jobTitle->toBe('Senior BE Developer');
});
