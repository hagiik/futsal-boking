<?php

namespace App\Filament\Resources\FieldScheduleResource\Pages;

use App\Filament\Resources\FieldScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListFieldSchedules extends ListRecords
{
    protected static string $resource = FieldScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
                ->label('Tambah Jadwal Lapangan')
                ->icon('heroicon-o-plus-circle')
                ->color('primary'),
        ];
    }
}
