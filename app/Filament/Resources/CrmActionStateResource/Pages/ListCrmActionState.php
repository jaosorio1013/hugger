<?php

namespace App\Filament\Resources\CrmActionStateResource\Pages;

use App\Filament\Resources\CrmActionStateResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmActionState extends ListRecords
{
    protected static string $resource = CrmActionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
