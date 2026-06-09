<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use Filament\Widgets\ChartWidget;

class AssetsByStatusChartWidget extends ChartWidget
{
    protected static ?int $sort = 2;

    protected int | string | array $columnSpan = 1;

    protected ?string $heading = 'Activos por estado';

    protected function getData(): array
    {
        $data = [];
        $labels = [];

        foreach (Asset::STATUSES as $key => $label) {
            $count = Asset::where('status', $key)->count();
            if ($count > 0) {
                $data[]   = $count;
                $labels[] = $label;
            }
        }

        return [
            'datasets' => [
                [
                    'data' => $data,
                    'backgroundColor' => [
                        '#10b981', // success - available
                        '#3b82f6', // primary - assigned
                        '#f59e0b', // warning - maintenance
                        '#6b7280', // gray - retired
                        '#9ca3af', // gray - stock
                        '#ef4444', // danger - lost
                    ],
                    'borderColor' => '#ffffff',
                    'borderWidth' => 2,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }
}
