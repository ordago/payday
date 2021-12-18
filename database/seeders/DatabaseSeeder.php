<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Paycheck;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Department::factory(5)
            ->sequence(
                ['name' => 'Development'],
                ['name' => 'Marketing'],
                ['name' => 'Sales'],
                ['name' => 'Finance'],
                ['name' => 'Administration'],
            )
            ->has(Employee::factory()->count(50)
                ->has(Paycheck::factory()->count(12))
            )
            ->create();
    }
}
