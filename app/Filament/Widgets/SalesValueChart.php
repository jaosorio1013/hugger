<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesValueChart extends ChartWidget
{
    protected static ?string $heading = 'Valor Ventas';
    protected static ?int $sort = 2;
    protected static ?array $options = [
        'scales' => [
            'x' => [
                'stacked' => true,
            ],
            'y' => [
                'stacked' => true,
            ],
        ],
    ];

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => 'Abundancia',
                    'data' => [300000, 200000, 300000, 50000, 1000000],
                    'borderColor' => config('hugger.colors')[0],
                    'backgroundColor' => config('hugger.colors')[0],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Alegria',
                    'data' => [200000, 100000, 100000, 50000, 3000000],
                    'borderColor' => config('hugger.colors')[1],
                    'backgroundColor' => config('hugger.colors')[1],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Hope',
                    'data' => [100000, 200000, 300000, 150000, 1000000],
                    'borderColor' => config('hugger.colors')[2],
                    'backgroundColor' => config('hugger.colors')[2],
                    'borderRadius' => 5,
                ],
            ],
            'labels' => ['2004-1', '2004-2', '2004-3', '2004-4', '2004-5'],
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
