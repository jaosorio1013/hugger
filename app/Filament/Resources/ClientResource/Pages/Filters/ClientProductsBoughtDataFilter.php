<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\Client;
use App\Models\DealDetail;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

trait ClientProductsBoughtDataFilter
{
    private function getProductsBoughtDataFilter()
    {
        $products = Product::pluck('name', 'id');

        return Filter::make('Datos Producto')
            ->form([
                Select::make('products_bought')
                    ->label('Productos Ventados')
                    ->multiple()
                    ->options($products),

                Select::make('products_not_bought')
                    ->label('Productos NO Ventados')
                    ->multiple()
                    ->options($products),
            ])
            ->query(function (Builder $query, array $data): Builder {
                $clientsIds = DealDetail::query()
                    ->when(
                        $data['products_not_bought'] ?? null,
                        fn(Builder $query) => $query->whereNotIn('product_id', $data['products_not_bought']),
                    )
                    ->pluck('client_id')
                    ->merge(
                        Client::whereDoesntHave('deals')->pluck('id')
                    )
                    ->when(
                        $data['products_bought'] ?? null,
                        fn(Collection $ids) => DealDetail::whereIn('product_id', $data['products_bought'])
                            ->whereIn('client_id', $ids)
                            ->pluck('client_id')
                    );

                return $query
                    ->when(
                        !empty($data['products_bought']) || !empty($data['products_not_bought']),
                        fn(Builder $query) => $query->whereIn('id', $clientsIds),
                    );
            })
            ->indicateUsing(function (array $data) use ($products): array {
                $indicators = [];
                $this->filterIndicatorForMultipleSelection($data, $indicators, $products, 'products_bought', 'Productos Ventados');
                $this->filterIndicatorForMultipleSelection($data, $indicators, $products, 'products_not_bought', 'Productos NO Ventados');

                return $indicators;
            });
    }
}
