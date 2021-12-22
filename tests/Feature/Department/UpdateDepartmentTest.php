<?php

use App\Models\Department;
use App\Models\User;

use function Pest\Laravel\putJson;

beforeEach(function () {
    $user = User::factory()->create();
    $this->actingAs($user);
});

it('should update a department', function (string $name, string $description) {
    $department = Department::factory([
        'name' => 'Development',
    ])->create();

    putJson(route('departments.update', compact('department')), [
        'name' => $name,
        'description' => $description,
    ])->assertNoContent();

    expect(Department::find($department->id))
        ->name->toBe($name)
        ->description->toBe($description);
})->with([
    ['name' => 'Development', 'description' => 'Updated Description'],
    ['name' => 'Development New', 'description' => 'Updated Description'],
]);
