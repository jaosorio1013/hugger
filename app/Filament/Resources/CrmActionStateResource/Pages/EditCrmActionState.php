<?php

namespace App\Filament\Resources\CrmActionStateResource\Pages;

use App\Filament\Resources\CrmActionStateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmActionState extends EditRecord
{
    protected static string $resource = CrmActionStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
