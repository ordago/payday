<?php

use App\Models\Department;
use App\Models\User;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should create a new department', function () {
    $department = postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Some description',
    ])->json('data');

    expect($department)
        ->attributes->name->toBe('Development')
        ->attributes->description->toBe('Some description');
});

it('should return 422 if name is invalid', function (?string $name) {
    Department::factory([
        'name' => 'Developemt',
    ])->create();

    postJson(route('departments.store'), [
        'name' => $name,
        'description' => 'Some description',
    ])->assertInvalid(['name']);
})->with([
    '',
    null,
    'Developemt'
]);
