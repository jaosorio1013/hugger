<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Filament\Resources\ClientResource\Pages\CreateClient;
use App\Models\Client;
use App\Models\CrmFont;
use App\Models\Tag;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;
use Nnjeim\World\Models\City;

trait ClientDataFilter
{
    private function getClientDataFilter(): Filter
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

    private function getClientDataFilter2(): Filter
    {
        $cities = CreateClient::getColombiaCities();
        $fonts = CrmFont::pluck('name', 'id');

        return Filter::make('Datos Cliente 2')
            ->form([
                Select::make('crm_font_id')
                    ->label('Fuente')
                    ->options($fonts),

                Select::make('city')
                    ->multiple()
                    ->label('Ciudad')
                    ->options($cities),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['city'] ?? null,
                        fn(Builder $query) => $query->whereIn('location_city_id', $data['city']),
                    )
                    ->when(
                        $data['crm_font_id'] ?? null,
                        fn(Builder $query) => $query->where('crm_font_id', $data['crm_font_id']),
                    )
                    ;
            })
            ->indicateUsing(function (array $data) use ($cities, $fonts): array {
                $indicators = [];
                $this->filterIndicatorForMultipleSelection($data, $indicators, $cities, 'city', 'Ciudad');
                $this->filterIndicatorForMultipleSelection($data, $indicators, $fonts, 'crm_font_id', 'Fuente');

                return $indicators;
            });
    }
}