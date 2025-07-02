<?php

namespace App\Filament\Widgets;

use App\Models\Booking;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Widget;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;

class Statistic extends BaseWidget
{
    // protected static string $view = 'filament.widgets.statistic';

    protected static bool $isLazy = false;
    protected function getStats(): array
    {
        return [
            // Total Booking per Bulan (6 bulan terakhir)
            Stat::make('Total Booking', Booking::count())
                ->description('Total Keseluruhan Booking')
                ->descriptionIcon('heroicon-o-shopping-cart', IconPosition::After)
                ->chart($this->getMonthlyBookingCounts())
                ->color('info'),

            // Total Penjualan (booking confirmed/completed)
            Stat::make('Total Sales', 'Rp ' . number_format(
                    Booking::where('status', 'confirmed')->orWhere('status', 'completed')->sum('total_price'),
                    0, ',', '.'
                ))
                ->description('Hasil Keseluruhan Booking')
                ->descriptionIcon('heroicon-o-credit-card', IconPosition::After)
                ->chart($this->getMonthlySalesTotals())
                ->color('success'),

            // Total Customer unik dari user_id
            Stat::make('Total Customer', Booking::distinct('user_id')->count('user_id'))
                ->description('Total Keseluruhan Pelanggan')
                ->descriptionIcon('heroicon-o-user', IconPosition::After)
                ->chart($this->getMonthlyCustomerCounts())
                ->color('info'),
        ];
    }

    protected function getMonthlyBookingCounts(): array
    {
        return Booking::selectRaw('COUNT(*) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();
    }

    protected function getMonthlySalesTotals(): array
    {
        return Booking::selectRaw('SUM(total_price) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->whereIn('status', ['confirmed', 'completed'])
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->map(fn($value) => (int)$value)
            ->toArray();
    }

    protected function getMonthlyCustomerCounts(): array
    {
        return Booking::selectRaw('COUNT(DISTINCT user_id) as total, DATE_FORMAT(created_at, "%Y-%m") as month')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('total')
            ->toArray();
    }


}
