<?php

namespace App\Filament\Widgets;

use App\Filament\Pages\Dashboard;
use App\Models\Deal;
use App\Models\User;
use Filament\Resources\Pages\Concerns\InteractsWithRecord;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

trait ChartsTrait
{
    use InteractsWithRecord;
    use InteractsWithPageFilters;

    private array $months;
    private int $iteration = 0;

    private function hasFilters(): bool
    {
        return !empty($this->filters['from']) || !empty($this->filters['until']);
    }

    private function getMonthsOnChart(): void
    {
        $totalMonthsToRemove = Deal::orderBy('date')->take(1)
            ->value(DB::raw('PERIOD_DIFF( EXTRACT(YEAR_MONTH FROM CURRENT_DATE), EXTRACT(YEAR_MONTH FROM date) )'));

        if ($this->hasFilters()) {
            $this->months = [];
            $from = (int)$this->filters['from'] ?? $totalMonthsToRemove;
            $until = (int)$this->filters['until'] ?? 0;

            for ($monthsToRemove = $from; $monthsToRemove >= $until; $monthsToRemove--) {
                $this->months[] = Carbon::now()->subMonths($monthsToRemove)->format('Y-m');
            }

            return;
        }

        Cache::remember('months_on_chart', 86400, function () {
            $this->months = [];
            for ($monthsToRemove = Deal::DEFAULT_CHART_MONTHS; $monthsToRemove > 0; $monthsToRemove--) {
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
        $baseQuery = Deal::select([
            'owner_id',
            DB::raw('COUNT(id) AS number_of_deals'),
            DB::raw('SUM(total) AS total_on_deals'),
            DB::raw("DATE_FORMAT(date, '%Y-%m') AS date_mont"),
        ])
            ->groupBy('owner_id', 'date_mont');

        if ($this->hasFilters()) {
            return $baseQuery
                ->when(!empty($this->filters['from']), function ($query) {
                    return $query->where('date', '>=', Carbon::now()->subMonths($this->filters['from'])->firstOfMonth());
                })
                ->when(!empty($this->filters['until']), function ($query) {
                    return $query->where('date', '<=', Carbon::now()->subMonths($this->filters['until'])->lastOfMonth());
                })
                ->get()
                ->groupBy('owner_id')
                ->map(function (Collection $ownerDeals) {
                    return $ownerDeals->keyBy('date_mont')->toArray();
                });
        }

        return Cache::remember('deals_by_owner', 86400, function () use ($baseQuery) {
            return $baseQuery
                ->where('date', '>=', Carbon::now()->subMonths(Deal::DEFAULT_CHART_MONTHS))
                ->get()
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
