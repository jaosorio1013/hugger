<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Models\Client;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Pages\CreateRecord;

class CreateClient extends CreateRecord
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
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

            Select::make('crm_font_id')
                ->label('Fuente de contacto')
                ->relationship('font', 'name'),

            Select::make('crm_mean_id')
                ->label('Medio de contacto')
                ->relationship('mean', 'name'),

            Select::make('location_city_id')
                ->label('Ciudad')
                ->relationship('city', 'name')
                ->searchable(),
        ];
    }
}
