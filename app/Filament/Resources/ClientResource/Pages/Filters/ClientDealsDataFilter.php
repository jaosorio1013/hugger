<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\Deal;
use App\Models\Product;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientDealsDataFilter
{
    private function getDealsDataFilter()
    {
        $products = Product::pluck('name', 'id');

        return Filter::make('Datos Compra')
            ->form([
                TextInput::make('number_purchases')
                    ->label('Cantidad de compras')
                    ->suffix(' o más')
                    ->numeric(),

                TextInput::make('amount_purchases')
                    ->label('Monto comprado')
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
                        $clientsIds ?? null,
                        fn(Builder $query) => $query->whereIn('id', $clientsIds),
                    );
            })
            ->indicateUsing(function (array $data) use ($products): array {
                $indicators = [];
                $this->filterIndicatorForMultipleSelection($data, $indicators, $products, 'products_bought', 'Productos Comprados');
                $this->filterIndicatorForMultipleSelection($data, $indicators, $products, 'products_not_bought', 'Productos NO Comprados');

                return $indicators;
            });
    }
}