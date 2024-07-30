<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Exports\ClientExporter;
use App\Filament\Filters\FilterIndicatorForMultipleSelections;
use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ClientResource\Pages\Filters\ClientActionsFilter;
use App\Filament\Resources\ClientResource\Pages\Filters\ClientDataFilter;
use App\Filament\Resources\ClientResource\Pages\Filters\ClientDealsDataFilter;
use App\Filament\Resources\ClientResource\Pages\Filters\ClientProductsBoughtDataFilter;
use App\Filament\Resources\ClientResource\RelationManagers\ClientActionsRelationManager;
use App\Models\Client;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Infolists\Components\TextEntry;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Actions\Action;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;
use pxlrbt\FilamentExcel\Actions\Pages\ExportAction;

class ListClients extends ListRecords
{
    use FilterIndicatorForMultipleSelections;
    use ClientDataFilter;
    use ClientDealsDataFilter;
    use ClientProductsBoughtDataFilter;
    use ClientActionsFilter;

    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),

            ExportAction::make()->exports([ClientExporter::make()]),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->actions($this->getTableActions())
            ->columns($this->getTableColumns())
            ->filtersFormColumns(4)
            ->filters([
                $this->getClientDataFilter(),
                // $this->getDealsDataFilter(),
                // $this->getProductsBoughtDataFilter(),
                // $this->getActionsFilter(),
            ], layout: FiltersLayout::AboveContentCollapsible)
            // ->filtersFormSchema(fn(array $filters): array => [
            //     Section::make('Datos Cliente')
            //         ->schema([$filters['Datos Cliente']])
            //         ->columnSpan(1),
            //
            //     Section::make('Datos Compra')
            //         ->schema([$filters['Datos Compra']])
            //         ->columnSpan(1),
            //
            //     Section::make('Datos Producto')
            //         ->schema([$filters['Datos Producto']])
            //         ->columnSpan(1),
            //
            //     Section::make('Acciones')
            //         ->schema([$filters['Acciones']])
            //         ->columnSpan(1),
            // ])
            ->bulkActions([
                BulkActionGroup::make([
                    BulkAction::make('Asignar responsable a clientes')
                        ->icon('heroicon-o-arrow-path-rounded-square')
                        ->deselectRecordsAfterCompletion()
                        ->color('info')
                        ->form([
                            Select::make('user_id')
                                ->label('Nuevo responsable')
                                ->options(
                                    User::pluck('name', 'id')
                                        ->prepend('Sin responsable', null)
                                )
                        ])
                        ->action(fn(array $data, Collection $records) => $records->each->update($data)),
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public function getTableColumns(): array
    {
        return [
            IconColumn::make('type')
                ->label('Tipo')
                ->icon(fn($state): string => match ($state) {
                    Client::TYPE_COMPANY => 'heroicon-o-building-office',
                    Client::TYPE_ALLIED => 'heroicon-o-hand-thumb-up',
                    Client::TYPE_NATURAL => 'heroicon-o-user',
                })
                ->sortable()
                ->width(50),

            TextColumn::make('name')
                ->label('Nombre')
                ->description(fn(Client $client): HtmlString => new HtmlString(
                    $client->user?->name ?? '<i style="color: #fc8d8d; ">Sin responsable</i>'
                ))
                ->sortable(),

            TextColumn::make('tags.name')->badge()->width(250),

            TextColumn::make('nit')
                ->label('Datos')
                ->formatStateUsing(fn(Client $client): View => view(
                    'tables.columns.client-general-data',
                    ['client' => $client]
                )),

            TextColumn::make('font.name')
                ->icon('heroicon-o-arrow-left-end-on-rectangle')
                ->label('Contacto')
                ->columnSpan(2),
        ];
    }

    public function getTableActions(): array
    {
        return [
            Action::make('Crear Acción')
                ->modalHeading('Crear Acción')
                ->form((new ClientActionsRelationManager)->getFormSchema())
                ->action(function (array $data, Client $client): void {
                    $client->actions()->create($data);

                    Notification::make()
                        ->title('Acción creada para: ' . $client->name)
                        ->info()
                        ->send();
                })
                ->icon('heroicon-o-play')
                ->color('info')
                ->label(''),

            Action::make('Ver Contactos')
                ->infolist([
                    TableRepeatableEntry::make('contacts')
                        ->label('Contactos')
                        ->schema([
                            TextEntry::make('name')
                                ->label('Nombre'),

                            TextEntry::make('phone')
                                ->label('Teléfono'),

                            TextEntry::make('email'),

                            TextEntry::make('charge')
                                ->label('Cargo'),
                        ])
                        ->striped(),
                ])
                ->hidden(fn($record) => $record->contacts->isEmpty())
                ->icon('heroicon-o-users')
                ->color('info')
                ->label(''),

            EditAction::make()->label(''),
            // DeleteAction::make()->label(''),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }
}
