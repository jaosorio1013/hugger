<?php

namespace App\Filament\Resources\MailchimpCampaignResource\Pages;

use App\Filament\Resources\MailchimpCampaignResource;
use Filament\Resources\Pages\CreateRecord;

class CreateMailchimpCampaign extends CreateRecord
{
    protected static string $resource = MailchimpCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [

        ];
    }
}
