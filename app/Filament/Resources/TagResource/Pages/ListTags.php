<?php

namespace App\Filament\Resources\TagResource\Pages;

use App\Filament\Resources\TagResource;
use App\Models\Client;
use App\Models\ClientContact;
use App\Models\ClientTag;
use App\Models\Tag;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use JibayMcs\FilamentTour\Tour\HasTour;
use JibayMcs\FilamentTour\Tour\Step;
use JibayMcs\FilamentTour\Tour\Tour;
use Maatwebsite\Excel\Excel;
use MailchimpMarketing\ApiClient;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;
use Ramsey\Collection\Collection;

class ListTags extends ListRecords
{
    use HasTour;

    protected static string $resource = TagResource::class;

    private bool $sendNotification = false;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Actualizar Tags Clientes en Mailchimp')
                ->icon('heroicon-c-arrow-path-rounded-square')
                ->action(function () {
                    $mailchimp = $this->getMailchimpConnection();

                    $this->updateMailchimpData($mailchimp);

                    $model = new Client();
                    $this->updateUsersMailchimpId($mailchimp, $model);

                    $model = new ClientContact();
                    $this->updateUsersMailchimpId($mailchimp, $model);

                    $this->updateMemberTags($mailchimp);

                    if ($this->sendNotification) {
                        Notification::make()
                            ->title('Existen emails de prueba')
                            ->body('Es posible que no visualice elementos nuevos en Maichimp, pues varios emails son de prueba y no los permite incrustar')
                            ->info()
                            ->send();
                    }
                }),

            Action::make('Ir a Mailchimp')
                ->icon('heroicon-c-arrow-uturn-right')
                ->url('https://us14.admin.mailchimp.com/audience/tags')
                ->openUrlInNewTab(),

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

    private function getClientTagsForMailchimp(): \Illuminate\Database\Eloquent\Collection|array
    {
        return Client::query()
            ->whereHas('tags', function ($query) {
                $query->whereNotNull('mailchimp_id')->where('registered_on_mailchimp', false);
            })
            ->with(['tags' => function ($query) {
                $query->whereNotNull('mailchimp_id')->wherePivot('registered_on_mailchimp', false);
            }])
            ->get(['id', 'mailchimp_id', 'type']);
    }

    private function updateContactRegisteredOnMailchimpForTag(int $contactId, Collection $tagsIds, ClientTag $model)
    {
        $model
            ->where('client_id', $contactId)
            ->whereIn('tag_id', $tagsIds)
            ->update([
                'registered_on_mailchimp' => true,
            ]);
    }

    private function updateMemberTags(ApiClient $mailchimp): void
    {
        $clients = $this->getClientTagsForMailchimp();

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
        if (preg_match('/example\./', $email) !== false) {
            return null;
        }

        return $mailchimp->lists->addListMember(
            config('hugger.MALCHIMP_LIST'),
            [
                'status' => 'transactional',
                'email_address' => $email,
            ],
            true
        );
    }

    private function updateUsersMailchimpId(ApiClient $mailchimp, ClientContact|Client $model): void
    {
        $exampleContacts = $model->whereNotNull('email')
            ->whereLike('email', '%@example.%')
            ->count('id');
        if ($exampleContacts > 0) {
            $this->sendNotification = true;
        }

        $contacts = $model->whereNotNull('email')
            ->whereNull('mailchimp_id')
            ->whereNotLike('email', '%@example.%')
            ->pluck('email', 'id');
        foreach ($contacts as $id => $email) {
            $mailchimpUser = $mailchimp->searchMembers->search($email);
            if ($mailchimpUser->exact_matches->total_items === 0) {
                $mailchimpUser = $this->addListMember($mailchimp, $email);
                if ($mailchimpUser !== null) {
                    $model->where('id', $id)->update([
                        'mailchimp_id' => $mailchimpUser->id,
                    ]);
                }

                continue;
            }

            $model->where('id', $id)->update([
                'mailchimp_id' => $mailchimpUser->exact_matches->members[0]->id,
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

    public function tours(): array
    {
        return [
            Tour::make('dashboard')
                ->previousButtonLabel('Anterior')
                ->nextButtonLabel('Siguiente')
                ->doneButtonLabel('Finalizado')
                ->steps(
                    Step::make()
                        ->title("Segmentación de campañas!")
                        ->description('Los TAGS del CRM se pueden sincronizar con Mailchimp teniendo en cuenta los siguientes pasos'),

                    Step::make('.fi-ac-btn-action:nth-child(3)')
                        ->title('Descargar Tags Faltantes')
                        ->icon('heroicon-c-arrow-down-tray')
                        ->description('Primero debemos descargar los tags faltantes en Mailchimp dando click en exportar'),

                    Step::make('.fi-ac-btn-action:nth-child(2)')
                        ->title('Crear Tags en Mailchimp')
                        ->icon('heroicon-c-arrow-uturn-right')
                        ->description('En caso de tener tags faltantes los debemos crear en Mailchimp '),

                    Step::make('.fi-ac-btn-action:nth-child(1)')
                        ->title('Actualizar tags en Mailchimp')
                        ->icon('heroicon-c-arrow-path-rounded-square')
                        ->description('Ahora, puedes dar click en este botón para actualizar los tags de Mailchimp')
                        // ->icon('heroicon-o-user-circle')
                        // ->iconColor('primary')
                ),
        ];
    }
}
