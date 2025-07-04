<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'payment_method' => 'required|in:cash,midtrans',
        ]);

        $cartItems = session('cart', []);

        if (empty($cartItems)) {
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Keranjang Anda kosong.'], 400);
            }
            return redirect()->route('cart.index')->with('error', 'Keranjang Anda kosong.');
        }

        try {
            $createdBookings = [];
            $totalPrice = 0;
            $transactionId = 'TR-' . now()->format('Ymd') . '-' . Str::ulid();
            
            $expiryDurationInMinutes = 15; // Contoh: 15 menit. Ubah sesuai kebutuhan.

            DB::transaction(function () use ($validated, $cartItems, &$createdBookings, &$totalPrice, $transactionId, $expiryDurationInMinutes) {
                
                foreach ($cartItems as $item) {
                    $booking = Booking::create([
                        'booking_number' => 'BK-' . now()->format('Ymd') . '-' . Str::ulid(),
                        'user_id' => Auth::id(),
                        'field_id' => $item['field_id'],
                        'booking_date' => $item['booking_date'],
                        'start_time' => $item['start_time'],
                        'end_time' => $item['end_time'],
                        'total_price' => $item['price'],
                        'status' => $validated['payment_method'] == 'cash' ? 'confirmed' : 'pending',
                        'expires_at' => $validated['payment_method'] == 'midtrans' ? now()->addMinutes($expiryDurationInMinutes) : null, 
                    ]);

                    $totalPrice += $item['price'];
                    $createdBookings[] = $booking;
                }

                if ($validated['payment_method'] == 'cash') {
                    foreach ($createdBookings as $booking) {
                        Payment::create([
                            'transaction_id' => $transactionId,
                            'booking_id' => $booking->id,
                            'amount' => $booking->total_price,
                            'method' => 'cash',
                            'status' => 'ditempat', 
                            'payment_url' => null, 
                            'paid_at' => now(), 
                        ]);
                    }
                }
            });

            session()->forget('cart');

            if ($validated['payment_method'] == 'cash') {
                $lastBookingNumber = end($createdBookings)->booking_number;
                return redirect()->route('booking.success', ['booking_number' => $lastBookingNumber])
                                ->with('success', 'Booking Anda telah dikonfirmasi!');
            } 
            else { 
                \Midtrans\Config::$serverKey = config('midtrans.server_key');
                \Midtrans\Config::$isProduction = config('midtrans.is_production', false);
                \Midtrans\Config::$isSanitized = true;
                \Midtrans\Config::$is3ds = true;
                
                $firstBookingNumber = $createdBookings[0]->booking_number;
                $params = [
                    'transaction_details' => [
                        'order_id' => $transactionId,
                        'gross_amount' => $totalPrice,
                    ],
                    'customer_details' => [
                        'first_name' => Auth::user()->name,
                        'email' => Auth::user()->email,
                        'phone' => Auth::user()->phone ?? '081234567890',
                    ],
                    'expiry' => [
                        'unit' => 'minute',
                        'duration' => $expiryDurationInMinutes,
                    ],
                    'callbacks' => [
                        'finish' => route('booking.success', ['booking_number' => $firstBookingNumber])
                    ],
                ];

                $snapToken = \Midtrans\Snap::getSnapToken($params);
                
                foreach ($createdBookings as $booking) {
                    Payment::create([
                        'transaction_id' => $transactionId,
                        'booking_id' => $booking->id,
                        'amount' => $booking->total_price,
                        'method' => 'midtrans',
                        'status' => 'pending',
                        'payment_url' => $snapToken,
                    ]);
                }

                $redirectUrl = route('booking.success', ['booking_number' => $firstBookingNumber]);

                return response()->json([
                    'snap_token' => $snapToken,
                    'redirect_url' => $redirectUrl
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Error saat checkout: ' . $e->getMessage() . ' Trace: ' . $e->getTraceAsString());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json(['error' => 'Gagal memproses checkout.'], 500);
            }
            return redirect()->route('cart.index')->with('error', 'Terjadi kesalahan saat memproses booking.');
        }
    }

    public function webhook(Request $request)
    {
        Log::info('--- Webhook dari Midtrans Diterima ---');

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        
        try {
            $notification = new \Midtrans\Notification();
        } catch (\Exception $e) {
            Log::error('Gagal membuat objek notifikasi Midtrans: ' . $e->getMessage());
            return response()->json(['error' => 'Notifikasi tidak valid.'], 400);
        }
        
        $transactionStatus = $notification->transaction_status;
        $transactionId = $notification->order_id; 
        $fraudStatus = $notification->fraud_status;

        Log::info("Mencoba memproses Transaction ID: {$transactionId} dengan status: '{$transactionStatus}'");

        $payments = Payment::where('transaction_id', $transactionId)->get();

        if ($payments->isEmpty()) {
            Log::warning("Webhook diterima, tapi tidak ada Payment dengan transaction_id {$transactionId} ditemukan.");
            return response()->json(['message' => 'Transaksi tidak ditemukan.']);
        }
        
        foreach ($payments as $payment) {
            $booking = $payment->booking; 
            
            if ($booking && $booking->status === 'pending') {
                if ($transactionStatus == 'settlement' || ($transactionStatus == 'capture' && $fraudStatus == 'accept')) {
                    $booking->update(['status' => 'confirmed']);
                    $payment->update(['status' => 'completed', 'paid_at' => now()]);
                    
                    Log::info("SUKSES: Booking #{$booking->booking_number} dan Payment #{$payment->id} diupdate.");
                } 
                else if ($transactionStatus == 'expire' || $transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                    $booking->update(['status' => 'cancelled']);
                    $payment->update(['status' => 'cancelled']);
                    Log::info("GAGAL/BATAL: Booking #{$booking->booking_number} dan Payment #{$payment->id} diupdate.");
                }
            }
        }
        
        return response()->json(['message' => 'Webhook berhasil diproses.']);
    }

    public function retryPayment(Booking $booking)
    {
        if ($booking->user_id !== Auth::id()) {
            abort(403);
        }

        $snapToken = $booking->payment?->payment_url;

        if (!$snapToken) {

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