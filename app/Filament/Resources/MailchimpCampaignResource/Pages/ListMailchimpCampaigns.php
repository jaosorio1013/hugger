<?php

namespace App\Filament\Resources\MailchimpCampaignResource\Pages;

use App\Filament\Resources\MailchimpCampaignResource;
use App\Models\MailchimpCampaign;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Carbon;
use MailchimpMarketing\ApiClient;

class ListMailchimpCampaigns extends ListRecords
{
    protected static string $resource = MailchimpCampaignResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Refrescar Campañas')
                ->action(function ($data) {
                    $this->getCampaigns();
                })
        ];
    }

    public function getCampaigns(): void
    {
        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX'),
        ]);

        $response = $mailchimp->campaigns->list();
        foreach ($response->campaigns as $item) {
            $campaign = MailchimpCampaign::query()->where('mailchimp_id', $item->web_id)->first();
            if (!$campaign) {
                $campaign = MailchimpCampaign::query()->create([
                    'mailchimp_id' => $item->web_id,
                    'name' => $item->settings->title,
                    'subject' => $item->settings->subject_line,
                ]);
            }

            $campaign->update([
                'name' => $item->settings->title,
                'subject' => $item->settings->subject_line,
                'created_at' => Carbon::parse($item->create_time),
            ]);
        }
    }
}
