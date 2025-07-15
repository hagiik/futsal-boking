<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Models\Payment;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateBooking extends CreateRecord
{
    protected static string $resource = BookingResource::class;
    protected function getFormActions(): array
    {
        return [
            // Ambil tombol "Create" bawaan dari Filament,
            // lalu kita ubah labelnya sesuai keinginan.
            $this->getCreateFormAction()->label('Simpan Booking'),

            // Karena kita tidak menyertakan getCreateAndContinueFormAction()
            // dan getCancelFormAction(), maka kedua tombol itu akan hilang.
        ];
    }

     protected function afterCreate(): void
    {
        // Ambil data booking yang baru saja dibuat
        $booking = $this->record;
        
        // Ambil data "virtual" dari form yang kita buat tadi
        $paymentMethod = $this->data['payment_method'];
        $paymentStatus = $this->data['payment_status'];
        $paidAt = $this->data['paid_at'] ?? null;

        // Jika metode pembayaran diisi, buat record pembayaran
        if ($paymentMethod) {
            
            // Buat transaction_id unik sesuai format yang Anda minta
            $transactionId = 'TR-' . now()->format('Ymd') . '-' . Str::ulid();

            Payment::create([
                'booking_id' => $booking->id,
                'transaction_id' => $transactionId,
                'amount' => $booking->total_price,
                'method' => $paymentMethod,
                'status' => $paymentStatus,
                'paid_at' => ($paymentStatus === 'confirmed') ? ($paidAt ?? now()) : null,
            ]);
        }
    }

}
