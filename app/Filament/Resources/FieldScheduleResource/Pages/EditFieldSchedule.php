<?php

namespace App\Filament\Resources\FieldScheduleResource\Pages;

use App\Filament\Resources\FieldScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditFieldSchedule extends EditRecord
{
    protected static string $resource = FieldScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
