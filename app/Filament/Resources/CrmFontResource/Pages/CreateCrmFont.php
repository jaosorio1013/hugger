<?php

namespace App\Filament\Resources\CrmFontResource\Pages;

use App\Filament\Resources\CrmFontResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmFont extends CreateRecord
{
    protected static string $resource = CrmFontResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
