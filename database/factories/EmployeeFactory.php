<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Department;
use App\Models\Employee;
use App\PaymentTypes\HourlyRate;
use App\PaymentTypes\Salary;

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
        $paymentTypeClass = collect([Salary::class, HourlyRate::class])->random();
        $isSalary = $paymentTypeClass === Salary::class;
        $salary = $isSalary ? rand(48000, 120000) * 100 : null;
        $hourlyRate = !$isSalary ? rand(15, 150) * 100 : null;

        $jobTitles = collect([
            'Full stack developer',
            'Frontend developer',
            'Backend developer',
        ]);

        return [
            'uuid' => $this->faker->uuid,
            'full_name' => $this->faker->name(),
            'email' => $this->faker->safeEmail,
            'department_id' => Department::factory(),
            'job_title' => $jobTitles->random(),
            'payment_type_class' => $paymentTypeClass,
            'salary' => $salary,
            'hourly_rate' => $hourlyRate,
        ];
    }
}
