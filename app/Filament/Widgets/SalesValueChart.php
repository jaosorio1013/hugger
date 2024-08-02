<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;

class SalesValueChart extends ChartWidget
{
    use ChartsTrait;

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
        $data = $this->getBaseChartStructure();
        $dealsByOwner = $this->getDealsByOwner();

        foreach ($this->getUsersById() as $ownerId => $ownerName) {
            $ownerDeals = $dealsByOwner[$ownerId] ?? [];
            $ownerDataSet = $this->getDataSetStructure($ownerName);

            foreach ($this->months as $month) {
                $ownerDataSet['data'][] = $ownerDeals[$month]['total_on_deals'] ?? 0;
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
