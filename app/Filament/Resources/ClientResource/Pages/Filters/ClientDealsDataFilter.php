<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\Deal;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientDealsDataFilter
{
    private function getDealsDataFilter(): Filter
    {
        return Filter::make('Datos Venta')
            ->form([
                TextInput::make('number_purchases')
                    ->label('Cantidad de Ventas')
                    ->suffix(' o más')
                    ->numeric(),

                TextInput::make('amount_purchases')
                    ->label('Monto Vendido')
                    ->suffix(' o más')
                    ->prefix('$')
                    ->numeric(),
            ])
            ->query(function (Builder $query, array $data): Builder {
                $clientsIds = Deal::query()
                    ->groupBy('client_id')
                    ->when(
                        $data['number_purchases'] ?? null,
                        fn(Builder $query) => $query->havingRaw('count(id) >= ' . $data['number_purchases'])
                    )
                    ->when(
                        $data['amount_purchases'] ?? null,
                        fn(Builder $query) => $query->havingRaw('sum(total) >= ' . $data['amount_purchases'])
                    )
                    ->pluck('client_id');

                return $query
                    ->when(
                        !empty($data['number_purchases']) || !empty($data['amount_purchases']),
                        fn(Builder $query) => $query->whereIn('id', $clientsIds),
                    );
            })
            ->indicateUsing(function (array $data): array {
                $indicators = [];

                if ($data['number_purchases'] ?? null) {
                    $indicators['number_purchases'] = $data['number_purchases'] . ' o más Ventas';
                }

                if ($data['amount_purchases'] ?? null) {
                    $indicators['amount_purchases'] = '$ ' . number_format($data['amount_purchases'], 0, ',', '.') . ' COP o más en Ventas';
                }

                return $indicators;
            });
    }
}
