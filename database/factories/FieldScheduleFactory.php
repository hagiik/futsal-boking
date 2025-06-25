<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Field;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FieldSchedule>
 */
class FieldScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $startTime = Carbon::createFromTime(fake()->numberBetween(8, 20), 0, 0);
        $endTime = $startTime->copy()->addHours(fake()->numberBetween(1, 2));

        return [
            'field_id' => Field::inRandomOrder()->first()->id,

            'day_of_week' => fake()->randomElement(['Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday', 'Sunday']),

            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),

            'price_per_hour' => fake()->randomElement([100000, 125000, 150000, 175000]),

            'is_active' => fake()->boolean(90),
        ];
    }
}
