<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Employee;
use App\Models\Paycheck;
use App\Models\User;
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
        User::factory([
            'name' => 'Admin',
            'email' => 'admin@payday.dev',
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ])->create();

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
