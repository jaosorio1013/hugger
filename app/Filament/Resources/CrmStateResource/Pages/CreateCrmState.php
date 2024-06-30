<?php

namespace App\Filament\Resources\CrmStateResource\Pages;

use App\Filament\Resources\CrmStateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmState extends CreateRecord
{
    protected static string $resource = CrmStateResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
