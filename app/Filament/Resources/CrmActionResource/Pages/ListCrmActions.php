<?php

namespace App\Filament\Resources\CrmActionResource\Pages;

use App\Filament\Resources\CrmActionResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmActions extends ListRecords
{
    protected static string $resource = CrmActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
