<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

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

}
