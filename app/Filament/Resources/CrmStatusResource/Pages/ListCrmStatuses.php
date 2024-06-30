<?php

namespace App\Filament\Resources\CrmStatusResource\Pages;

use App\Filament\Resources\CrmStatusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmStatuses extends ListRecords
{
    protected static string $resource = CrmStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
