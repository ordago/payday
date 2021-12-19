<?php

use App\Models\Department;
use App\Models\Employee;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\deleteJson;
use function Pest\Laravel\getJson;
use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should soft delete an employee', function () {
    $employee = Employee::factory()->create();

    deleteJson(route('employees.destroy', compact('employee')))
        ->assertStatus(Response::HTTP_NO_CONTENT);

    getJson(route('employees.show', compact('employee')))
        ->assertStatus(Response::HTTP_NOT_FOUND);

    expect(Employee::withTrashed()->find($employee->id))
        ->deleted_at->not->toBeEmpty();
});
