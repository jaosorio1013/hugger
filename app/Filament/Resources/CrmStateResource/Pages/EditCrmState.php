<?php

namespace App\Filament\Resources\CrmStateResource\Pages;

use App\Filament\Resources\CrmStateResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmState extends EditRecord
{
    protected static string $resource = CrmStateResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
