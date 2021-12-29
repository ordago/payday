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
