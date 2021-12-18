<?php

use App\Models\Department;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

use function Pest\Laravel\postJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should return 422 if name is invalid', function (?string $name) {
    Department::factory([
        'name' => 'Development',
    ])->create();

    postJson(route('departments.store'), [
        'name' => $name,
        'description' => 'description'
    ])->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
})->with([
    '',
    null,
    'Development'
]);

it('should store a department', function () {
    $department= postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Description'
    ])->json('data');

    expect($department)
        ->attributes->name->toBe('Development')
        ->attributes->description->toBe('Description');
});
