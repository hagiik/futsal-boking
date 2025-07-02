<?php

namespace App\Filament\Resources\BookingResource\Pages;

use App\Filament\Resources\BookingResource;
use App\Filament\Widgets\Statistic;
use App\Models\Booking;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\ListRecords\Tab;

class ListBookings extends ListRecords
{
    protected static string $resource = BookingResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }

    protected function getHeaderWidgets(): array
    {
        return [
            Statistic::class,
        ];
    }
    public function getTabs(): array
    {   
        return [
            
            'All' => Tab::make('All')->badge(Booking::count()),

            'pending' => Tab::make('Menunggu')
                ->badge(Booking::where('status', 'pending')->count())
                ->query(fn ($query) => $query->where('status', 'pending')),

            'Processed' => Tab::make('Diproses')
                ->badge(Booking::where('status', 'confirmed')->count())
                ->query(fn ($query) => $query->where('status', 'confirmed')),

            'Completed' => Tab::make('Selesai')
                ->badge(Booking::where('status', 'completed')->count())
                ->query(fn ($query) => $query->where('status', 'completed')),

            'cancelled' => Tab::make('Dibatalkan')
                ->badge(Booking::where('status', 'cancelled')->count())
                ->query(fn ($query) => $query->where('status', 'cancelled')),
        ];
    }
}
