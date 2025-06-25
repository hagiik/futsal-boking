<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\BookingReward;
use App\Models\Payment;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Booking::factory()
            ->count(50)
            ->has(
                Payment::factory()->state(function (array $attributes, Booking $booking) {
                    return ['amount' => $booking->total_price];
                }),
                'payment' 
            )
            ->has(
                BookingReward::factory(),
                'reward' 
            )
            ->create();
    }
}
