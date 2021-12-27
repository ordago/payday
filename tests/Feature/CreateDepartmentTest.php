<?php

use App\Models\User;

use function Pest\Laravel\postJson;

it('should create a new department', function () {
    $user = User::factory()->create();
    $this->actingAs($user);

    $department = postJson(route('departments.store'), [
        'name' => 'Development',
        'description' => 'Some description',
    ])->json('data');

    // Expect
    expect($department)
        ->name->toBe('Development')
        ->description->toBe('Some description');
});
