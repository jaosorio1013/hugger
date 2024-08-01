<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use App\Models\User;
use Filament\Support\Colors\Color;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Facades\DB;

class SalesQuantityChart extends ChartWidget
{
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
        // SELECT
        //   DATE_FORMAT(production_timestamp, ‘%m-%Y’) AS production_month,
        //   COUNT(id) AS count
        // FROM hoodie
        // GROUP BY
        //   MONTH(production_timestamp),
        //   YEAR(production_timestamp);

        // $data = [];
        // $users = User::pluck('name', 'id');
        // Deal::query()
        //     ->groupBy([
        //         'owner_id',
        //
        //     ])
        //     ->select([
        //         'DATE_FORMAT(date, ‘%Y-%m’) AS date',
        //     ]);

        // DB::table('deals')
        //     ->
        // foreach ($users as $user) {
        //     dd($user);
        // }

        return [
            'datasets' => [
                [
                    'label' => 'Abundancia',
                    'data' => [3, 2, 3, 5, 1],
                    'borderColor' => config('hugger.colors')[0],
                    'backgroundColor' => config('hugger.colors')[0],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Alegria',
                    'data' => [2, 1, 1, 5, 3],
                    'borderColor' => config('hugger.colors')[1],
                    'backgroundColor' => config('hugger.colors')[1],
                    'borderRadius' => 5,
                ],
                [
                    'label' => 'Hope',
                    'data' => [1, 2, 3, 5, 1],
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
