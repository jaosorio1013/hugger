<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\Cache;
use Nnjeim\World\Models\City;
use Nnjeim\World\Models\Country;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [];
    }

    private static function getColombiaCities()
    {
        return Cache::rememberForever('colombia-countries', function () {
            $colombiaId = Country::where('name', 'Colombia')->value('id');
            return City::with('state:id,name')
                ->where('country_id', $colombiaId)
                ->get([
                    'state_id',
                    'name',
                    'id',
                ])
                ->map(function (City $city) {
                    $city->name = $city->name . ', ' . $city->state->name;

                    return $city;
                })
                ->pluck('name', 'id');
        });
    }

    public static function getFormFields(): array
    {
        return [
            Select::make('type')
                ->options(Client::TYPES)
                ->label('Tipo')
                ->required(),

            TextInput::make('name')
                ->label('Nombre')
                ->required(),

            TextInput::make('nit')
                ->label('Número Identificación'),

            TextInput::make('phone')
                ->label('Teléfono'),

            TextInput::make('email')
                ->label('Email'),

            TextInput::make('address')
                ->label('Dirección'),

            Select::make('user_id')
                ->label('Responsable')
                ->relationship('user', 'name')
                ->searchable(),

            Select::make('location_city_id')
                ->label('Ciudad')
                ->options(self::getColombiaCities())
                ->preload()
                ->searchable(),

            Select::make('tags')
                ->relationship('tags', 'name')
                ->createOptionForm([
                    TextInput::make('name')->required(),
                ])
                ->multiple(),

            // ------

            Select::make('crm_font_id')
                ->label('Fuente de contacto')
                ->relationship('font', 'name'),

            Select::make('crm_pipeline_stage_id')
                ->label('Estado Pipeline')
                ->relationship('stage', 'name'),
        ];
    }
}
