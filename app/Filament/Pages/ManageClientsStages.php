<?php

namespace App\Filament\Pages;

use App\Models\Client;
use Filament\Pages\Page;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\On;
use App\Models\CrmPipelineStage;
use Illuminate\Support\Collection;
use Filament\Notifications\Notification;


class ManageClientsStages extends Page
{
    protected static ?string $navigationIcon = 'heroicon-s-queue-list';

    protected static string $view = 'filament.pages.manage-client-stages';

    // Our Custom heading to be displayed on the page
    protected ?string $heading = 'Pipeline Clientes';
    // Custom Navigation Link name
    protected static ?string $navigationLabel = 'Pipeline';

    // We will be listening for the `statusChangeEvent` event to update the record status
    #[On('statusChangeEvent')]
    public function changeRecordStatus($id, $crm_pipeline_stage_id): void
    {
        // Find the client and update the crm_pipeline_stage_id
        $client = Client::find($id);
        if ($client->crm_pipeline_stage_id == $crm_pipeline_stage_id) {
            return;
        }

        $client->crm_pipeline_stage_id = $crm_pipeline_stage_id;

        if ($client->user_id === null && !auth()->user()->is_admin) {
            $client->user_id = auth()->id();
        }

        $client->save();

        // Don't forget to write the log
        $client->actions()->create([
            'crm_pipeline_stage_id' => $crm_pipeline_stage_id,
            'user_id' => auth()->id(),
            'notes' => null,
        ]);
    }

    // Data that we will pass to our View
    protected function getViewData(): array
    {
        $statuses = $this->statuses();

        $records = $this->records();

        // We are mapping through the statuses and adding the records to each status
        // This will form multiple lists dynamically based on the records
        $statuses = $statuses
            ->map(function ($status) use ($records) {
                $status['group'] = $this->getId();
                $status['kanbanRecordsId'] = "{$this->getId()}-{$status['id']}";
                $status['records'] = $records
                    ->filter(function ($record) use ($status) {
                        return $this->isRecordInStatus($record, $status);
                    });

                return $status;
            });

        return [
            'records' => $records,
            'statuses' => $statuses,
        ];
    }

    // Loading the statuses from the database and mapping them
    // to have id and title. ID will be checked against Clients
    protected function statuses(): Collection
    {
        return CrmPipelineStage::query()
            ->orderBy('position')
            ->get()
            ->map(function (CrmPipelineStage $stage) {
                return [
                    'id' => $stage->id,
                    'title' => $stage->name,
                    'color' => $stage->color,
                ];
            });
    }

    // We are loading all the clients and mapping them to have ID, title, and status
    protected function records(): Collection
    {
        return Client::with('user:id,name')
            ->when(!auth()->user()->is_admin, function (Builder $query) {
                $query->whereNull('user_id')->orWhere('user_id', auth()->id());
            })
            ->get()
            ->map(function (Client $item) {
                return [
                    'id' => $item->id,
                    'title' => $item->name,
                    'owner' => $item->user->name ?? null,
                    'status' => $item->crm_pipeline_stage_id,
                ];
            });
    }

    // We are checking if the record is in the status
    protected function isRecordInStatus($record, $status): bool
    {
        return $record['status'] === $status['id'];
    }
}
