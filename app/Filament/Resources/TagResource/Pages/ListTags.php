<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use App\Models\Client;
use App\Models\Tag;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Excel;
use MailchimpMarketing\ApiClient;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ListTags extends ListRecords
{
    protected static string $resource = TagResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Actualizar Tags Clientes en Mailchimp')
                ->action(function () {
                    $mailchimp = $this->getMailchimpConnection();

                    $this->updateMailchimpData($mailchimp);

                    $this->updateClientMailchimpId($mailchimp);

                    $this->updateMemberTags($mailchimp);
                }),

            ExportAction::make()->exports([
                ExcelExport::make('Tags Por Crear en Mailchimp')
                    ->withFilename('Tags Por Crear en Mailchimp')
                    ->withWriterType(Excel::XLSX)
                    ->withColumns([
                        Column::make('mailchimp_name')->heading('Tag'),
                    ])
                    ->modifyQueryUsing(function ($query) {
                        $this->updateMailchimpData();

                        return $query->whereNull('mailchimp_id');
                    }),
            ]),

            CreateAction::make(),
        ];
    }

    private function updateMemberTags(ApiClient $mailchimp): void
    {
        $clients = Client::query()
            ->whereNotNull('mailchimp_id')
            ->whereHas('tags', function ($query) {
                $query->whereNotNull('mailchimp_id')->where('registered_on_mailchimp', false);
            })
            ->with(['tags' => function ($query) {
                $query->whereNotNull('mailchimp_id')->wherePivot('registered_on_mailchimp', false);
            }])
            ->get(['id', 'mailchimp_id']);

        foreach ($clients as $client) {
            foreach ($client->tags as $tag) {
                $mailchimp->lists->updateListMemberTags(
                    config('hugger.MALCHIMP_LIST'),
                    $client->mailchimp_id,
                    [
                        'tags' => [['name' => $tag->mailchimp_name, 'status' => 'active']],
                    ]
                );
            }

            DB::table('client_tag')
                ->where('client_id', $client->id)
                ->whereIn('tag_id', $client->tags->pluck('id'))
                ->update([
                    'registered_on_mailchimp' => true,
                ]);
        }
    }

    private function addListMember(ApiClient $mailchimp, string $email)
    {
        return $mailchimp->lists->addListMember(
            config('hugger.MALCHIMP_LIST'),
            [
                'status' => 'transactional',
                'email_address' => $email,
            ],
            true
        );
    }

    private function updateClientMailchimpId(ApiClient $mailchimp): void
    {
        $clients = Client::whereNotNull('email')->whereNull('mailchimp_id')->pluck('email', 'id');
        foreach ($clients as $clientId => $clientEmail) {
            $mailchimpUser = $mailchimp->searchMembers->search($clientEmail);
            if ($mailchimpUser->exact_matches->total_items === 0) {
                $mailchimpUser = $this->addListMember($mailchimp, $clientEmail);

                Client::where('id', $clientId)->update([
                    'mailchimp_id' => $mailchimpUser->id
                ]);

                continue;
            }

            Client::where('id', $clientId)->update([
                'mailchimp_id' => $mailchimpUser->exact_matches->members[0]->id
            ]);
        }
    }

    private function updateMailchimpData(ApiClient $mailchimp = null): void
    {
        $mailchimp = $mailchimp ?? $this->getMailchimpConnection();

        $this->updateMailchimpIdForTags($mailchimp);
    }

    private function updateMailchimpIdForTags(ApiClient $mailchimp): void
    {
        $tags = Tag::whereNull('mailchimp_id')->get(['mailchimp_name']);
        if (!$tags) {
            return;
        }

        $mailchimpTags = $mailchimp->lists->tagSearch(
            config('hugger.MALCHIMP_LIST'), config('hugger.MAILCHIMP_TAG_PREFIX')
        )->tags;

        collect($mailchimpTags)
            ->whereIn('name', $tags->pluck('mailchimp_name'))
            ->each(function ($tag) use ($tags) {
                Tag::where('mailchimp_name', $tag->name)
                    ->update(['mailchimp_id' => $tag->id]);
            });
    }

    private function getMailchimpConnection(): ApiClient
    {
        $mailchimp = new ApiClient();

        $mailchimp->setConfig([
            'apiKey' => env('MAILCHIMP_API_KEY'),
            'server' => env('MAILCHIMP_SERVER_PREFIX'),
        ]);

        return $mailchimp;
    }
}
