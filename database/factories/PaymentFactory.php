<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'confirmed', 'cancelled', 'completed']);
 
        $paid_at = in_array($status, ['confirmed', 'completed']) ? now() : null;

        return [
            'amount' => fake()->numberBetween(100000, 500000),
            
            'method' => fake()->randomElement(['qris', 'transfer', 'cash']),
            
            'status' => $status,
            'payment_url' => $status === 'pending' ? fake()->url() : null,
            'paid_at' => $paid_at,
        ];
    }
}
