<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesQuantityChart extends ChartWidget
{
    use ChartsTrait;

    protected static ?string $heading = 'Cantidad Ventas';
    protected static ?int $sort = 1;
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
        $months = $this->getMonthsOnChart();
        $data = $this->getBaseChartStructure();

        $owners = $this->getUsersById();
        $dealsByOwner = $this->getDealsByOwner();

        foreach ($owners as $ownerId => $ownerName) {
            $ownerDeals = $dealsByOwner[$ownerId] ?? [];
            $ownerDataSet = $this->getDataSetStructure($ownerName);

            foreach ($months as $month) {
                $ownerDataSet['data'][] = $ownerDeals[$month]['number_of_deals'] ?? 0;
            }

            $data['datasets'][] = $ownerDataSet;
            unset($dealsByOwner[$ownerId]);
        }

        return $data;
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
