<?php

namespace App\Filament\Resources\ClientResource\Pages\Filters;

use App\Models\ClientAction;
use App\Models\CrmAction;
use App\Models\CrmActionState;
use Filament\Forms\Components\Select;
use Filament\Tables\Filters\Filter;
use Illuminate\Database\Eloquent\Builder;

trait ClientActionsFilter
{
    private function getActionsFilter()
    {
        $actions = CrmAction::pluck('name', 'id');
        $actionStates = CrmActionState::pluck('name', 'id');

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
                $clientActions = ClientAction::query()
                    ->when(
                        $data['action'] ?? null,
                            fn(Builder $query) => $query->where('crm_action_id', $data['action']),
                    )
                    ->when(
                        $data['state'] ?? null,
                        fn(Builder $query) => $query->where('crm_action_state_id', $data['state']),
                    )
                    ->pluck('client_id');

                return $query
                    ->when(
                        $clientActions ?? null,
                        fn(Builder $query) => $query->whereIn('id', $clientActions),
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