<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Employee;
use App\Models\Timelog;
use Carbon\Carbon;

class TimelogFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Timelog::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $minutes = rand(1, 8) * 60;
        $startedAt = Carbon::now()->subDays(rand(1, 30));
        $stoppedAt = $startedAt->addMinutes($minutes);

        return [
            'uuid' => $this->faker->uuid(),
            'employee_id' => Employee::factory(),
            'started_at' => $startedAt,
            'stopped_at' => $stoppedAt,
            'minutes' => $minutes,
        ];
    }
}
