<?php

namespace App\Filament\Widgets;

use App\Models\Asset;
use App\Models\AssetCategory;
use Filament\Widgets\ChartWidget;

class AssetsByCategoryChartWidget extends ChartWidget
{
    protected static ?int $sort = 4;

    protected int | string | array $columnSpan = [
        'default' => 12,
        'md' => 6,
    ];

    protected ?string $pollingInterval = '60s';

    protected ?string $heading = 'Activos por categoría';

    protected function getData(): array
    {
        $labels = [];
        $data   = [];

        foreach (AssetCategory::withCount('assets')->get() as $category) {
            $labels[] = $category->name;
            $data[]   = $category->assets_count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Cantidad',
                    'data'  => $data,
                    'backgroundColor' => '#3b82f6',
                    'borderColor'     => '#2563eb',
                    'borderWidth'     => 1,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }


}
