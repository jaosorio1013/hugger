<?php

namespace App\Filament\Resources\CrmFontResource\Pages;

use App\Filament\Resources\CrmFontResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmFont extends EditRecord
{
    protected static string $resource = CrmFontResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
