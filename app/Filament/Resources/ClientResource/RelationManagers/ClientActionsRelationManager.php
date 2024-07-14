<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\CrmAction;
use App\Models\CrmActionState;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ClientActionsRelationManager extends RelationManager
{
    protected static string $relationship = 'actions';

    protected static ?string $title = 'Acciones';
    protected static ?string $icon = 'heroicon-o-play';

    public function form(Form $form): Form
    {
        return $form
            ->columns(1)
            ->schema($this->getFormSchema());
    }

    public function getFormSchema(): array
    {
        return [
            Select::make('crm_action_id')
                ->label('Acción')
                ->options(CrmAction::pluck('name', 'id'))
                ->preload()
                ->required(),

            Select::make('crm_action_state_id')
                ->label('Estado')
                ->options(CrmActionState::pluck('name', 'id'))
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
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('created_at')
                    ->label('Fecha')
                    ->sortable(),

                TextColumn::make('action.name')
                    ->label('Acción')
                    ->sortable(),

                TextColumn::make('state.name')
                    ->label('Estado')
                    ->sortable(),

                TextColumn::make('notes')
                    ->label('Notas')
                    ->html()
                    ->sortable(),
            ])
            // ->filters([
            //     TrashedFilter::make(),
            // ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Crear acción')
                    ->label('Crear acción'),
            ])
            ->actions([
                EditAction::make(),
                DeleteAction::make(),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ])
            ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]));
    }
}
