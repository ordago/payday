<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Paycheck;
use Carbon\Carbon;

class PaycheckFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Paycheck::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid(),
            'employee_id' => Employee::factory(),
            'net_amount' => rand(4000, 10000) * 100,
            'payed_at' => Carbon::now()->subMonth()->startOfMonth(),
        ];
    }
}
