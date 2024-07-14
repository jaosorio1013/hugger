<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\Client;
use App\Models\Tag;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientDataFilter
{
    private function getClientDataFilter()
    {
        $clientTypes = collect(Client::TYPES);
        $tags = Tag::pluck('name', 'id');

        return Filter::make('Datos Cliente')
            ->form([
                TextInput::make('name')
                    ->label('Nombre'),

                Select::make('type')
                    ->label('Tipo Empresa')
                    ->multiple()
                    ->options($clientTypes),

                Select::make('tags')
                    ->multiple()
                    ->options($tags),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['name'] ?? null,
                        fn(Builder $query) => $query->where('name', 'like', '%' . $data['name'] . '%'),
                    )
                    ->when(
                        $data['type'] ?? null,
                        fn(Builder $query) => $query->whereIn('type', $data['type']),
                    )
                    ->when(
                        $data['tags'] ?? null,
                        fn(Builder $query) => $query->whereHas('tags', function (Builder $query) use ($data) {
                            $query->whereIn('id', $data['tags']);
                        }),
                    );
            })
            ->indicateUsing(function (array $data) use ($clientTypes, $tags): array {
                $indicators = [];
                if ($data['name'] ?? null) {
                    $indicators['name'] = 'Nombre contiene: "' . $data['name'] . '"';
                }
                $this->filterIndicatorForMultipleSelection($data, $indicators, $clientTypes, 'type', 'Tipo empresa');
                $this->filterIndicatorForMultipleSelection($data, $indicators, $tags, 'tags', 'Tags');

                return $indicators;
            });
    }
}