<?php

namespace App\Filament\Resources\CrmActionResource\Pages;

use App\Filament\Resources\CrmActionResource;
use Filament\Resources\Pages\CreateRecord;

class CreateCrmAction extends CreateRecord
{
    protected static string $resource = CrmActionResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
