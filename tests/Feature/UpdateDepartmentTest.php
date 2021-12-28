<?php

use App\Models\Department;
use App\Models\User;

use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should update an existing department', function () {
    $department = Department::factory([
        'name' => 'Development',
        'description' => 'Description',
    ])->create();

    putJson(route('departments.update', ['department' => $department]), [
        'name' => 'Development Updated',
        'description' => 'Description Updated',
    ]);

    expect(Department::find($department->id))
        ->name->toBe('Development Updated')
        ->description->toBe('Description Updated');
});

it('should update an existing department with the same name', function () {
    $department = Department::factory([
        'name' => 'Development',
        'description' => 'Description',
    ])->create();

    putJson(route('departments.update', ['department' => $department]), [
        'name' => 'Development',
        'description' => 'Description Updated',
    ]);

    expect(Department::find($department->id))
        ->name->toBe('Development')
        ->description->toBe('Description Updated');
});
