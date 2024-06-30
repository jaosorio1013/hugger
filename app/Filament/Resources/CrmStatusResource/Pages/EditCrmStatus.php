<?php

namespace App\Filament\Resources\CrmStatusResource\Pages;

use App\Filament\Resources\CrmStatusResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmStatus extends EditRecord
{
    protected static string $resource = CrmStatusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
