<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function pay(Request $request)
    {
        $validated = $request->validate([
            'field_id' => 'required|exists:fields,id',
            'booking_date' => 'required|date',
            'start_time' => 'required',
            'end_time' => 'required',
            'total_price' => 'required|numeric|min:1',
        ]);

        try {
            $expiryDuration = 2; // Durasi dalam menit

            $usernameSlug = Str::slug(Auth::user()->name);
            $today = now()->format('Ymd');
            $bookingCountToday = Booking::whereDate('created_at', now())->count() + 1;
            $bookingSequence = str_pad($bookingCountToday, 5, '0', STR_PAD_LEFT);
            $randomUnique = Str::random(8);
            $bookingNumber = "BK-{$today}-{$bookingSequence}-{$usernameSlug}-{$randomUnique}";


            $booking = Booking::create([
                'booking_number' => $bookingNumber,
                'user_id' => Auth::id(),
                'field_id' => $validated['field_id'],
                'booking_date' => $validated['booking_date'],
                'start_time' => $validated['start_time'],
                'end_time' => $validated['end_time'],
                'total_price' => $validated['total_price'],
                'status' => 'pending',
                'expires_at' => now()->addMinutes($expiryDuration),
            ]);
            
            \Midtrans\Config::$serverKey = config('midtrans.server_key');
            \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
            \Midtrans\Config::$isSanitized = true;
            \Midtrans\Config::$is3ds = true;

            $params = [
                'transaction_details' => [
                    'order_id' => $booking->booking_number,
                    'gross_amount' => $booking->total_price,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                ],
                'expiry' => [
                    'unit' => 'minute',
                    'duration' => $expiryDuration,
                ],
                'callbacks' => [
                    'finish' => route('booking.success', ['booking_number' => $booking->booking_number]),
                ]
            ];

            $snapToken = \Midtrans\Snap::getSnapToken($params);

            Payment::create([
                'booking_id' => $booking->id,
                'amount' => $booking->total_price,
                'method' => 'transfer',
                'status' => 'pending',
                'payment_url' => $snapToken, // Menggunakan kolom yang benar
            ]);
            
            return response()->json(['snap_token' => $snapToken]);

        } catch (\Exception $e) {
            Log::error('Error saat membuat pembayaran: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memproses permintaan pembayaran.'], 500);
        }
    }

    public function webhook(Request $request)
    {
        Log::info('--- Webhook dari Midtrans Diterima ---');

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        
        try {
            $notification = new \Midtrans\Notification();

        } catch (\Exception $e) {
            Log::error('Gagal membuat objek notifikasi Midtrans. Error: ' . $e->getMessage());
            return response()->json(['error' => 'Notifikasi tidak valid.'], 400);
        }
        
        // Ambil data penting
        $transactionStatus = $notification->transaction_status;
        $orderId = $notification->order_id;
        $fraudStatus = $notification->fraud_status;

        Log::info("Mencoba memproses Order ID: {$orderId} dengan status transaksi: '{$transactionStatus}'");

        $booking = Booking::where('booking_number', $orderId)->first();

        if (!$booking) {
            Log::warning("Webhook diterima, tapi Booking dengan nomor {$orderId} tidak ditemukan.");
            return response()->json(['message' => 'Booking tidak ditemukan.']);
        }
        
        if ($booking->status === 'pending') {
            if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                $booking->update(['status' => 'confirmed']);
                $booking->payment()->update(['status' => 'confirmed', 'paid_at' => now()]);
                Log::info("SUKSES: Booking #{$booking->booking_number} diupdate menjadi 'confirmed'.");
            } 
            else if ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                $booking->update(['status' => 'cancelled']);
                $booking->payment()->update(['status' => 'cancelled']);
                Log::info("GAGAL/BATAL: Booking #{$booking->booking_number} diupdate menjadi 'cancelled'.");
            }
        } else {
             Log::info("Booking #{$booking->booking_number} sudah diproses sebelumnya (status saat ini: '{$booking->status}'). Webhook diabaikan.");
        }
        
        return response()->json(['message' => 'Webhook berhasil diproses.']);
    }

    public function retryPayment(Booking $booking)
    {
        // Pastikan hanya pemilik booking yang bisa mencoba bayar lagi
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        // Ambil Snap Token yang sudah disimpan dari relasi payment
        $snapToken = $booking->payment?->payment_url;

        if (!$snapToken) {
            // Jika karena suatu alasan token tidak ada, buat token baru (opsional)
            // Atau tampilkan error
            return response()->json(['error' => 'Token pembayaran tidak ditemukan.'], 404);
        }

        return response()->json(['snap_token' => $snapToken]);
    }

    public function success($booking_number)
    {
        $booking = Booking::where('booking_number', $booking_number)
            ->where('user_id', Auth::id())
            ->with(['field.category', 'payment'])
            ->firstOrFail();

        return view('pages.lapangan.success-payment', compact('booking'));
    }

}