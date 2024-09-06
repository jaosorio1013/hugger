<?php

namespace App\Filament\Resources\ClientResource\RelationManagers;

use App\Filament\Resources\DealResource;
use App\Filament\Resources\DealResource\Pages\CreateDeal;
use App\Models\ClientAction;
use App\Models\Deal;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions\CreateAction;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\Relation;

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

    protected function getTableQuery(): Builder|Relation|null
    {
        return Deal::where('client_id', $this->ownerRecord->id)->orderByDesc('date');
    }
}
