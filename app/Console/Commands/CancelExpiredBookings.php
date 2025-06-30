<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Booking;
use Illuminate\Support\Facades\Log;

class CancelExpiredBookings extends Command
{
    protected $signature = 'bookings:cancel-expired';

    protected $description = 'Cancel bookings that expired but are still pending';

    public function handle()
    {
        $expiredBookings = Booking::where('status', 'pending')
            ->where('expires_at', '<', now())
            ->get();

        foreach ($expiredBookings as $booking) {
            $booking->update(['status' => 'cancelled']);
            $booking->payment()->update(['status' => 'cancelled']);
            Log::info("Auto-cancel: Booking #{$booking->booking_number} expired and marked as cancelled.");
        }

        $this->info("Cancelled " . count($expiredBookings) . " expired bookings.");
    }
}
