<?php

namespace App\Filament\Resources\CrmMeanResource\Pages;

use App\Filament\Resources\CrmMeanResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmMean extends CreateRecord
{
    protected static string $resource = CrmMeanResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
