<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\ClientResource\Pages\EditClient;
use App\Models\CrmAction;
use App\Models\CrmPipelineStage;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actions';

    protected static ?string $title = 'Acciones';
    protected static ?string $icon = 'heroicon-o-play';

    protected function configureCreateAction(CreateAction $action): void
    {
        parent::configureCreateAction($action);

        $action->successRedirectUrl(
            fn(Model $record): string => EditClient::getUrl([$record->client_id])
        );
    }

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema($this->getFormSchema());
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('crm_pipeline_stage_id')
                ->label('Estado')
                ->options(CrmPipelineStage::pluck('name', 'id'))
                ->preload()
                ->required(),

            Select::make('crm_action_id')
                ->label('Acción')
                ->options(CrmAction::pluck('name', 'id'))
                ->preload()
                ->required(),

            RichEditor::make('notes')
                ->label('Notas')
                ->required(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->defaultSort('updated_at', 'desc')
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->sortable(),

                TextColumn::make('stage.name')
                    ->label('Estado')
                    ->sortable(),

                TextColumn::make('action.name')
                    ->label('Acción')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->html()
                    ->sortable(),
            ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Crear acción')
                    ->label('Crear acción'),
            ])
            ->actions([
                EditAction::make(),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
