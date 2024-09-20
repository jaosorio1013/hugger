<?php

namespace App\Filament\Widgets;

use App\Models\Client;
use App\Models\CrmFont;
use App\Models\Deal;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ContactFontChart extends ChartWidget
{
    use ChartsTrait;

    protected static ?string $heading = 'Fuentes de Contacto';
    protected static ?string $description = 'Cantidad de clientes nuevos que nos han contactado por cada fuente.';
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
        $clientsByContactFonts = $this->getClientsByContactFont();

        foreach ($this->getContactFonts() as $contactMeanId => $contactMeanName) {
            $dataSet = $this->getDataSetStructure($contactMeanName);

            foreach ($this->months as $month) {
                $dataSet['data'][] = $clientsByContactFonts[$contactMeanId][$month]['count'] ?? 0;
            }

            $data['datasets'][] = $dataSet;
            unset($clientsByContactFonts[$contactMeanId]);
        }

        return $data;
    }

    private function getContactFonts()
    {
        return Cache::rememberForever('crm_fonts', function () {
            return CrmFont::pluck('name', 'id');
        });
    }

    private function getClientsByContactFont(): \Illuminate\Database\Eloquent\Collection|Collection
    {
        // return Cache::rememberForever('getClientsByOwnerAndContactFont', function () {
            return Client::query()
                // ->where('created_at', '>=', Carbon::now()->subMonths(Deal::DEFAULT_CHART_MONTHS))
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
        // });
    }

    protected function getType(): string
    {
        return 'bar';
    }
}
