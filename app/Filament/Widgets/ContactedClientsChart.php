<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ContactedClientsChart extends ChartWidget
{
    protected static ?string $heading = 'Clientes Contactados';
    protected static ?int $sort = 4;
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
                    'data' => [3, 2, 3, 3, 1],
                    'borderColor' => config('hugger.colors')[0],
                    'backgroundColor' => config('hugger.colors')[0],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Alegria',
                    'data' => [2, 1, 1, 3, 3],
                    'borderColor' => config('hugger.colors')[1],
                    'backgroundColor' => config('hugger.colors')[1],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Hope',
                    'data' => [1, 2, 3, 1, 1],
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
