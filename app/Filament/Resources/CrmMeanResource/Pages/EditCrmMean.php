<?php

namespace App\Filament\Resources\CrmMeanResource\Pages;

use App\Filament\Resources\CrmMeanResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmMean extends EditRecord
{
    protected static string $resource = CrmMeanResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
