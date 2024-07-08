<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Models\Client;
use App\Models\ClientContact;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class ContactsRelationManager extends RelationManager
{
    protected static string $relationship = 'contacts';

    protected static ?string $title = 'Contactos';
    protected static ?string $icon = 'heroicon-s-users';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->label('Nombre')
                    ->required(),

                TextInput::make('email'),

                TextInput::make('charge')
                    ->label('Cargo'),

                TextInput::make('phone')
                    ->label('Teléfono'),

                Select::make('crm_font_id')
                    ->label('Fuente de contacto')
                    ->relationship('font', 'name'),

                Select::make('crm_mean_id')
                    ->label('Medio de contacto')
                    ->relationship('mean', 'name'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                TextColumn::make('name')
                    ->label('Nombre')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->sortable(),

                TextColumn::make('charge')
                    ->label('Cargo'),

                TextColumn::make('phone')
                    ->label('Teléfono'),

                TextColumn::make('font.name')
                    ->label('Fuente de contacto'),

                TextColumn::make('mean.name')
                    ->label('Medio de contacto'),
            ])
            // ->filters([
            //     TrashedFilter::make(),
            // ])
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Crear Contacto')
                    ->label('Crear Contacto'),
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

    public static function canViewForRecord(Model $ownerRecord, string $pageClass): bool
    {
        return $ownerRecord->type !== Client::TYPE_NATURAL;
    }
}
