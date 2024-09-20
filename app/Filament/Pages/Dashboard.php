<?php

namespace App\Filament\Pages;

use App\Models\Deal;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Pages\Dashboard as BasePage;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class Dashboard extends BasePage
{
    use HasFiltersForm;

    protected ?string $subheading = 'Aquí encuentras las graficas de estado de la empresa';

    protected static ?string $navigationIcon = 'heroicon-o-chart-bar';

    protected static ?string $navigationLabel = 'Dashboard';

    protected static ?string $title = 'Dashboard';

    public function filtersForm(Form $form): Form
    {
        $monthsToFilter = $this->getMonthsToFilter();

        return $form
            ->schema([
                Section::make()
                    ->schema([
                        Select::make('from')
                            ->options($monthsToFilter)
                            ->placeholder('Últimos 5 meses')
                            ->label('Desde'),

                        Select::make('until')
                            ->options($monthsToFilter)
                            ->label('Hasta')
                            ->placeholder('Hoy'),
                    ])
                    ->columns(2),
            ]);
    }

    public function getMonthsToFilter(): array
    {
        $totalMonthsToRemove = Deal::getMonthsFromFirstDealToNow();

        $monthsToFilter = [];
        for ($monthsToRemove = 1; $monthsToRemove <= $totalMonthsToRemove; $monthsToRemove++) {
            $monthsToFilter[$monthsToRemove] = Carbon::now()->subMonths($monthsToRemove)->format('Y-m');
        }

        return $monthsToFilter;
    }
}