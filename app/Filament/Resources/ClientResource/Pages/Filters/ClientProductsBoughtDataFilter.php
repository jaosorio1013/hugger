<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\DealDetail;
use App\Models\Product;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientProductsBoughtDataFilter
{
    private function getProductsBoughtDataFilter()
    {
        $products = Product::pluck('name', 'id');

        return Filter::make('Datos Producto')
            ->form([
                Select::make('products_bought')
                    ->label('Productos Comprados')
                    ->multiple()
                    ->options($products),

                Select::make('products_not_bought')
                    ->label('Productos NO Comprados')
                    ->multiple()
                    ->options($products),
            ])
            ->query(function (Builder $query, array $data): Builder {
                $clientsIds = DealDetail::query()
                    ->when(
                        $data['products_bought'] ?? null,
                        fn(Builder $query) => $query->whereIn('product_id', $data['products_bought']),
                    )
                    ->when(
                        $data['products_bought'] ?? null,
                        fn(Builder $query) => $query->whereNotIn('product_id', $data['products_not_bought']),
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