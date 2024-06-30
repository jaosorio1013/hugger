<?php

namespace App\Filament\Resources\CrmActionResource\Pages;

use App\Filament\Resources\CrmActionResource;
use Filament\Actions\DeleteAction;
use Filament\Resources\Pages\EditRecord;

class EditCrmAction extends EditRecord
{
    protected static string $resource = CrmActionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            DeleteAction::make(),
        ];
    }
}
