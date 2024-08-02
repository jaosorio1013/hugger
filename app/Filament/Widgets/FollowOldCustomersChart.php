<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class FollowOldCustomersChart extends ChartWidget
{
    use ChartsTrait;

    protected static ?string $heading = 'Seguimiento Clientes Viejos';
    protected static ?int $sort = 3;
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

    public static function canView(): bool
    {
        return false;
    }

    protected function getData(): array
    {
        // $data = $this->getBaseChartStructure();
        // $dealsByOwner = $this->getDealsByOwner();
        //
        // foreach ($this->getUsersById() as $ownerId => $ownerName) {
        //     $ownerDeals = $dealsByOwner[$ownerId] ?? [];
        //     $ownerDataSet = $this->getDataSetStructure($ownerName);
        //
        //     foreach ($this->months as $month) {
        //         $ownerDataSet['data'][] = $ownerDeals[$month]['total_on_deals'] ?? 0;
        //     }
        //
        //     $data['datasets'][] = $ownerDataSet;
        //     unset($dealsByOwner[$ownerId]);
        // }
        //
        // return $data;


        // return [
        //     'datasets' => [
        //         [
        //             'label' => 'Abundancia',
        //             'data' => [3, 2, 3, 5, 1],
        //             'borderColor' => config('hugger.colors')[0],
        //             'backgroundColor' => config('hugger.colors')[0],
        //             'borderRadius' => 5,
        //         ],
        //         [
        //             'label' => 'Alegria',
        //             'data' => [2, 1, 1, 5, 3],
        //             'borderColor' => config('hugger.colors')[1],
        //             'backgroundColor' => config('hugger.colors')[1],
        //             'borderRadius' => 5,
        //         ],
        //         [
        //             'label' => 'Hope',
        //             'data' => [1, 2, 3, 0, 1],
        //             'borderColor' => config('hugger.colors')[2],
        //             'backgroundColor' => config('hugger.colors')[2],
        //             'borderRadius' => 5,
        //         ],
        //     ],
        //     'labels' => ['2004-1', '2004-2', '2004-3', '2004-4', '2004-5'],
        // ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
