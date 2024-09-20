<?php

namespace App\Filament\Widgets;

use App\Models\ClientAction;
use App\Models\Deal;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class ContactedClientsChart extends ChartWidget
{
    use ChartsTrait;

    protected static ?string $heading = 'Clientes Contactados';
    protected static ?string $description = 'Cantidad de clientes a los que se les ha realizado algún seguimiento durante cada mes.';
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
        $data = $this->getBaseChartStructure();
        $clientsContacted = $this->getClientsContacted();

        foreach ($this->getUsersById() as $ownerId => $ownerName) {
            $dataSet = $this->getDataSetStructure($ownerName);

            foreach ($this->months as $month) {
                $dataSet['data'][] = $clientsContacted[$ownerId][$month]['count'] ?? 0;
            }

            $data['datasets'][] = $dataSet;
            unset($clientsContacted[$ownerId]);
        }

        return $data;
    }

    private function getClientsContacted(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        // return Cache::rememberForever('getClientsContacted', function () {
        return ClientAction::query()
            // ->where('created_at', '>=', Carbon::now()->subMonths(Deal::DEFAULT_CHART_MONTHS))
            ->groupBy('date_mont', 'user_id')
            ->get([
                'user_id',
                DB::raw('COUNT(id) AS count'),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS date_mont")
            ])
            ->groupBy('user_id')
            ->map(function (Collection $clientsContactedByUser) {
                return $clientsContactedByUser->keyBy('date_mont')->toArray();
            });
        // });
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
