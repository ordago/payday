<?php

use App\Models\Department;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\getJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return 404 if a department not found', function () {
    getJson(route('departments.show', ['department' => 'not-exists']))
        ->assertStatus(Response::HTTP_NOT_FOUND);
});

it('should return a department', function () {
    $department = Department::factory([
        'name' => 'Development',
        'description' => 'Best developers',
    ])->create();

    $departmentResponse = getJson(route('departments.show', compact('department')))
        ->json('data');

    expect($departmentResponse)
        ->id->toBe($department->uuid)
        ->attributes->name->toBe('Development')
        ->attributes->description->toBe('Best developers');
});

it('should return all departments', function () {
    Department::factory()
        ->sequence(
            ['name' => 'Development', 'description' => 'Best developers'],
            ['name' => 'Marketing', 'description' => 'Best marketers'],
        )
        ->count(2)
        ->create();

    $departmentResponse = getJson(route('departments.index'))
        ->json('data');

    expect($departmentResponse)->sequence(
        fn ($department) => $department->attributes->name->toBe('Development'),
        fn ($department) => $department->attributes->name->toBe('Marketing'),
    );
});
