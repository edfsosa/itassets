<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class AssetStatsWidget extends StatsOverviewWidget
{
    protected static ?int $sort = 1;

    protected int | string | array $columnSpan = 'full';

    protected function getStats(): array
    {
        $total       = Asset::count();
        $available   = Asset::where('status', 'available')->count();
        $stock       = Asset::where('status', 'stock')->count();
        $assigned    = Asset::where('status', 'assigned')->count();
        $maintenance = Asset::where('status', 'maintenance')->count();
        $retired     = Asset::where('status', 'retired')->count();
        $lost        = Asset::where('status', 'lost')->count();

        return [
            Stat::make('Total de activos', $total)
                ->icon('heroicon-o-computer-desktop')
                ->color('gray'),

            Stat::make('Disponibles', $available)
                ->description("{$stock} en stock / almacén")
                ->descriptionIcon('heroicon-m-arrow-trending-up')
                ->icon('heroicon-o-check-circle')
                ->color('success'),

            Stat::make('Asignados', $assigned)
                ->icon('heroicon-o-user')
                ->color('primary'),

            Stat::make('En mantenimiento', $maintenance)
                ->icon('heroicon-o-wrench-screwdriver')
                ->color('warning'),

            Stat::make('Dados de baja', $retired)
                ->description("{$lost} perdidos / robados")
                ->icon('heroicon-o-archive-box-x-mark')
                ->color('danger'),
        ];
    }
}
