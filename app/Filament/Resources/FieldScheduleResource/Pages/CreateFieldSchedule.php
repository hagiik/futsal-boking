<?php

namespace App\Filament\Resources\FieldScheduleResource\Pages;

use App\Filament\Resources\FieldScheduleResource;
use App\Models\FieldSchedule;
use Carbon\Carbon;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Filament\Notifications\Notification;

class CreateFieldSchedule extends CreateRecord
{
    protected static string $resource = FieldScheduleResource::class;
    protected function handleRecordCreation(array $data): FieldSchedule
    {
        $start = \Carbon\Carbon::createFromTimeString($data['start_time']);
        $end = \Carbon\Carbon::createFromTimeString($data['end_time']);

        if ($start->gte($end)) {
            Notification::make()
                ->title('Jam buka harus lebih kecil dari jam tutup')
                ->danger()
                ->send();
            throw new \Exception('Jam buka harus lebih kecil dari jam tutup.');
        }

        if (empty($data['days'])) {
            throw new \Exception('Pilih minimal satu hari.');
        }

        $createdSchedules = [];

        foreach ($data['days'] as $day) {
            $slotStart = $start->copy();

            while ($slotStart->lt($end)) {
                $createdSchedules[] = \App\Models\FieldSchedule::create([
                    'field_id' => $data['field_id'],
                    'day_of_week' => $day,
                    'start_time' => $slotStart->format('H:i:s'),
                    'end_time' => $slotStart->copy()->addHour()->format('H:i:s'),
                    'price_per_hour' => $data['price_per_hour'],
                    'is_active' => true,
                ]);

                $slotStart->addHour();
            }
        }

        if (count($createdSchedules) === 0) {
            throw new \Exception('Tidak ada jadwal yang berhasil dibuat. Cek kembali inputnya.');
        }

        // Kembalikan satu record agar redirect tidak error
        return $createdSchedules[0];
    }

}
