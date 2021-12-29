<?php

use App\Models\Department;
use App\Models\User;

use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should update an existing department', function (string $name, string $description) {
    $department = Department::factory([
        'name' => 'Development',
        'description' => 'Description',
    ])->create();

    putJson(route('departments.update', ['department' => $department]), [
        'name' => $name,
        'description' => $description,
    ]);

    expect(Department::find($department->id))
        ->name->toBe($name)
        ->description->toBe($description);
})->with([
    ['name' => 'Development Updated', 'description' => 'Description Updated'],
    ['name' => 'Development', 'description' => 'Description Updated'],
]);
