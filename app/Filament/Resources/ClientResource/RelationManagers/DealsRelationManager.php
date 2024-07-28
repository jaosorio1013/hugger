<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\DealResource;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;

class DealsRelationManager extends RelationManager
{
    protected static string $relationship = 'deals';

    protected static ?string $title = 'Compras';
    protected static ?string $icon = 'heroicon-o-shopping-cart';

    protected ?string $placeholderHeight = 'full';

    public function form(Form $form): Form
    {
        return DealResource::form($form);
    }

    public function table(Table $table): Table
    {
        return DealResource::table($table)
            ->headerActions([
                CreateAction::make()
                    ->modalHeading('Crear compra')
                    ->label('Crear compra')
                    ->modalWidth(900),
            ]);
    }
}
