<?php

namespace App\Filament\Resources\CrmStateResource\Pages;

use App\Filament\Resources\CrmStateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmStates extends ListRecords
{
    protected static string $resource = CrmStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
