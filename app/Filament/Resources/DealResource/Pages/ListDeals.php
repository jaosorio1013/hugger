<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Filament\Resources\DealResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListDeals extends ListRecords
{
    protected static string $resource = DealResource::class;

    protected ?string $subheading = 'Aquí puedes ver, crear, editar e importarlas las todas las compras realizadas.';

    protected function getHeaderActions(): array
    {
        return [
            ImportDeals::action(),

            CreateAction::make(),
        ];
    }
}
