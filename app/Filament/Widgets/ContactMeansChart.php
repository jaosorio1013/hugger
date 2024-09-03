<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\CrmFont;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContactMeansChart extends ChartWidget
{
    use ChartsTrait;

    protected static ?string $heading = 'Medios de Contacto';
    protected static ?string $description = 'Cantidad de clientes nuevos que nos han contactado por cada medio.';
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
        $data = $this->getBaseChartStructure();
        $clientsByContactMeans = $this->getClientsByContactMean();

        foreach ($this->getContactMeans() as $contactMeanId => $contactMeanName) {
            $dataSet = $this->getDataSetStructure($contactMeanName);

            foreach ($this->months as $month) {
                $dataSet['data'][] = $clientsByContactMeans[$contactMeanId][$month]['count'] ?? 0;
            }

            $data['datasets'][] = $dataSet;
            unset($clientsByContactMeans[$contactMeanId]);
        }

        return $data;
    }

    private function getContactMeans()
    {
        return Cache::rememberForever('crm_fonts', function () {
            return CrmFont::pluck('name', 'id');
        });
    }

    private function getClientsByContactMean()
    {
        return Cache::rememberForever('getClientsByOwnerAndContactMean', function () {
            return Client::query()
                ->where('created_at', '>=', Carbon::now()->subMonths(self::CHART_MONTHS))
                ->groupBy('date_mont', 'crm_font_id')
                ->get([
                    'crm_font_id',
                    DB::raw('COUNT(id) AS count'),
                    DB::raw("DATE_FORMAT(created_at, '%Y-%m') AS date_mont")
                ])
                ->groupBy('crm_font_id')
                ->map(function (Collection $clientsOfOwner) {
                    return $clientsOfOwner->keyBy('date_mont')->toArray();
                });
        });
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
