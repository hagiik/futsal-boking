<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Field;
use App\Models\User;
use Carbon\Carbon;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
public function definition(): array
    {
        $startTime = Carbon::createFromTime(fake()->numberBetween(8, 21), 0, 0);
        $endTime = $startTime->copy()->addHour();

        return [
            'user_id' => User::where('id', '!=', 1)->inRandomOrder()->first()->id,
            'field_id' => Field::inRandomOrder()->first()->id,
            'booking_date' => fake()->dateTimeBetween('+1 days', '+1 month')->format('Y-m-d'),
            'start_time' => $startTime->format('H:i:s'),
            'end_time' => $endTime->format('H:i:s'),
            'status' => fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']),
            'total_price' => fake()->randomElement([100000, 150000, 200000, 250000]),
            'verification_sent' => fake()->boolean(20),
        ];
    }
}
