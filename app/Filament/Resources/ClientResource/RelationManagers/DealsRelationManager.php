<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\DealResource;
use App\Filament\Resources\DealResource\Pages\CreateDeal;
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
        return $form->schema(
            DealResource::getFormSchema(   true)
        );
    }

    public function table(Table $table): Table
    {
        return DealResource::table($table)
            ->headerActions([
                CreateAction::make()
                    ->url(CreateDeal::getUrl([
                        'client_id' => 1
                    ]))
                    ->openUrlInNewTab()
                    ->modalHeading('Crear compra')
                    ->label('Crear compra')
                    ->modalWidth(900),
            ]);
    }
}
