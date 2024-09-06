<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\ClientAction;
use App\Models\CrmAction;
use App\Models\CrmPipelineStage;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientActionsFilter
{
    private function getActionsFilter()
    {
        $actions = CrmAction::pluck('name', 'id');
        $actionStates = CrmPipelineStage::pluck('name', 'id');

        return Filter::make('Acciones')
            ->form([
                Select::make('action')
                    ->label('Acción')
                    ->options($actions),

                Select::make('state')
                    ->label('Estado Acción')
                    ->options($actionStates),
            ])
            ->query(function (Builder $query, array $data): Builder {
                $clientsIds = ClientAction::query()
                    ->when(
                        $data['action'] ?? null,
                            fn(Builder $query) => $query->where('crm_action_id', $data['action']),
                    )
                    ->when(
                        $data['state'] ?? null,
                        fn(Builder $query) => $query->where('crm_pipeline_stage_id', $data['state']),
                    )
                    ->pluck('client_id');

                return $query
                    ->when(
                        !empty($data['action']) || !empty($data['state']),
                        fn(Builder $query) => $query->whereIn('id', $clientsIds),
                    );
            })
            ->indicateUsing(function (array $data) use ($actions, $actionStates): array {
                $indicators = [];
                $this->filterIndicatorForMultipleSelection($data, $indicators, $actions, 'action', 'Acción');
                $this->filterIndicatorForMultipleSelection($data, $indicators, $actionStates, 'state', 'Estado Acción');

                return $indicators;
            });
    }
}
