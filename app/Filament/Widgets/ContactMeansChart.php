<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class ContactMeansChart extends ChartWidget
{
    protected static ?string $heading = 'Medios de Contacto';
    protected static ?int $sort = 6;
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
                    'label' => 'TELÉFONO',
                    'data' => [4, 3, 7, 4, 5],
                    'borderColor' => config('hugger.colors')[0],
                    'backgroundColor' => config('hugger.colors')[0],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'WHATSAPP',
                    'data' => [2, 1, 5, 3, 3],
                    'borderColor' => config('hugger.colors')[1],
                    'backgroundColor' => config('hugger.colors')[1],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'CORREO',
                    'data' => [3, 2, 3, 4, 1],
                    'borderColor' => config('hugger.colors')[2],
                    'backgroundColor' => config('hugger.colors')[2],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'FORMULARIO PÁGINA WEB',
                    'data' => [4, 5, 3, 1, 5],
                    'borderColor' => config('hugger.colors')[3],
                    'backgroundColor' => config('hugger.colors')[3],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'REDES',
                    'data' => [1, 5, 3, 7, 5],
                    'borderColor' => config('hugger.colors')[4],
                    'backgroundColor' => config('hugger.colors')[4],
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
