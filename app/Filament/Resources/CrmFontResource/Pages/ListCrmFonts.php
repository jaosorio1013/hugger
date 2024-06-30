<?php

namespace App\Filament\Resources\CrmFontResource\Pages;

use App\Filament\Resources\CrmFontResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmFonts extends ListRecords
{
    protected static string $resource = CrmFontResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
