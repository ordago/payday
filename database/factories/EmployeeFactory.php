<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Department;
use App\Models\Employee;

class EmployeeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Employee::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $hasSalary = !!rand(0, 1);
        $salary = $hasSalary ? rand(48000, 120000) * 100 : null;
        $hourlyRate = !$hasSalary ? rand(15, 150) * 100 : null;

        return [
            'uuid' => $this->faker->uuid,
            'full_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail,
            'department_id' => Department::factory(),
            'job_title' => $this->faker->words(2, true),
            'payment_type_class' => $this->faker->regexify('[A-Za-z0-9]{70}'),
            'salary' => $salary,
            'hourly_rate' => $hourlyRate,
        ];
    }
}
