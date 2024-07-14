<?php

namespace App\Filament\Resources\CrmActionStateResource\Pages;

use App\Filament\Resources\CrmActionStateResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmActionState extends CreateRecord
{
    protected static string $resource = CrmActionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
