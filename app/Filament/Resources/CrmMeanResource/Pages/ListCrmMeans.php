<?php

namespace App\Filament\Resources\CrmMeanResource\Pages;

use App\Filament\Resources\CrmMeanResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;

class ListCrmMeans extends ListRecords
{
    protected static string $resource = CrmMeanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
