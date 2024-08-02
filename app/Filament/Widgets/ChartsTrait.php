<?php

namespace App\Filament\Widgets;

use App\Models\Deal;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ChartsTrait
{
    private array $months;
    private int $iteration = 0;
    private const CHART_MONTHS = 5;

    private function getMonthsOnChart()
    {
        return Cache::remember('months_on_chart', 86400, function () {
            $this->months = [];
            for ($monthsToRemove = self::CHART_MONTHS; $monthsToRemove > 0; $monthsToRemove--) {
                $this->months[] = Carbon::now()->subMonths($monthsToRemove)->format('Y-m');
            }
        });
    }

    private function getUsersById(): Collection
    {
        return Cache::rememberForever('user_by_id_for_charts', function () {
            return User::where('show_on_charts', true)->pluck('name', 'id');
        });
    }

    private function getDealsByOwner()
    {
        return Cache::remember('deals_by_owner', 86400, function () {
            return Deal::query()
                ->where('date', '>=', Carbon::now()->subMonths(self::CHART_MONTHS))
                ->groupBy('owner_id', 'date_mont')
                ->get([
                    'owner_id',
                    DB::raw('COUNT(id) AS number_of_deals'),
                    DB::raw('SUM(total) AS total_on_deals'),
                    DB::raw("DATE_FORMAT(date, '%Y-%m') AS date_mont")
                ])
                ->groupBy('owner_id')
                ->map(function (Collection $ownerDeals) {
                    return $ownerDeals->keyBy('date_mont')->toArray();
                });
        });
    }

    private function getBaseChartStructure(): array
    {
        $this->getMonthsOnChart();

        return [
            'datasets' => [],
            'labels' => $this->months,
        ];
    }

    private function getDataSetStructure(string $label): array
    {
        $iteration = $this->iteration;
        $this->iteration++;

        return [
            'data' => [],
            'label' => $label,
            'borderRadius' => 5,
            'borderColor' => config('hugger.colors')[$iteration],
            'backgroundColor' => config('hugger.colors')[$iteration],
        ];
    }
}
