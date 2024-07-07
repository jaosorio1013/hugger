<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\DealResource;
use App\Models\Client;
use App\Models\ClientContact;
use Filament\Forms\Components\Placeholder;
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
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DealsRelationManager extends RelationManager
{
    protected static string $relationship = 'deals';

    protected static ?string $title = 'Compras';
    protected static ?string $icon = 'heroicon-o-shopping-cart';

    public function form(Form $form): Form
    {
        return DealResource::form($form);
    }

    public function table(Table $table): Table
    {
        return DealResource::table($table)
            ->headerActions([
                CreateAction::make()->modalWidth(900),
            ]);



        // return $table
        //     ->recordTitleAttribute('name')
        //     ->columns([
        //         TextColumn::make('name')
        //             ->searchable()
        //             ->sortable(),
        //
        //         TextColumn::make('email')
        //             ->searchable()
        //             ->sortable(),
        //
        //         TextColumn::make('charge'),
        //
        //         TextColumn::make('phone'),
        //
        //         TextColumn::make('crm_font_id'),
        //
        //         TextColumn::make('crm_mean_id'),
        //     ])
        //     ->filters([
        //         TrashedFilter::make(),
        //     ])
        //     ->headerActions([
        //         CreateAction::make(),
        //     ])
        //     ->actions([
        //         EditAction::make(),
        //         DeleteAction::make(),
        //         RestoreAction::make(),
        //         ForceDeleteAction::make(),
        //     ])
        //     ->bulkActions([
        //         BulkActionGroup::make([
        //             DeleteBulkAction::make(),
        //             RestoreBulkAction::make(),
        //             ForceDeleteBulkAction::make(),
        //         ]),
        //     ])
        //     ->modifyQueryUsing(fn(Builder $query) => $query->withoutGlobalScopes([
        //         SoftDeletingScope::class,
        //     ]));
    }
}
