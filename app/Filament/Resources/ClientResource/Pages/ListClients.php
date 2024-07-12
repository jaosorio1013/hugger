<?php

namespace App\Filament\Resources\ClientResource\Pages;

use App\Filament\Resources\ClientResource;
use App\Filament\Resources\ClientResource\RelationManagers\ClientActionsRelationManager;
use App\Models\Client;
use App\Models\User;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
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
use Filament\Tables\Filters\Filter;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;
use Illuminate\Support\HtmlString;

class ListClients extends ListRecords
{
    protected static string $resource = ClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }

    public function table(Table $table): Table
    {
        return $table
            ->actions($this->getTableActions())
            ->columns($this->getTableColumns())
            ->filters($this->getTableFilter(), layout: FiltersLayout::AboveContent)
            // ->filters($this->getTableFilter(), layout: FiltersLayout::AboveContentCollapsible)
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
                        ->action(fn (array $data, Collection $records) => $records->each->update($data)),
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

    public function getTableFilter(): array
    {
        return [
            $this->getCompanyDataFilter(),
            $this->getDealsDataFilter(),
            $this->getProductsDataFilter(),
            $this->getActionsFilter(),
        ];
    }

    private function getCompanyDataFilter()
    {
        $clientTypes = collect(Client::TYPES);

        return Filter::make('Datos Cliente')
            ->form([
                TextInput::make('name')
                    ->label('Nombre'),

                Select::make('type')
                    ->label('Tipo Empresa')
                    ->multiple()
                    ->options($clientTypes),
            ])
            ->query(function (Builder $query, array $data): Builder {
                return $query
                    ->when(
                        $data['name'] ?? null,
                        fn(Builder $query) => $query->where('name', 'like', '%' . $data['name'] . '%'),
                    )
                    ->when(
                        $data['type'] ?? null,
                        fn(Builder $query) => $query->whereIn('type', $data['type']),
                    );
            })
            ->indicateUsing(function (array $data) use ($clientTypes): array {
                $indicators = [];
                if ($data['name'] ?? null) {
                    $indicators['name'] = 'Nombre contiene: "' . $data['name'] . '"';
                }
                if ($data['type'] ?? null) {
                    $labels = $clientTypes
                        ->mapWithKeys(fn (string | array $label, string $value): array => is_array($label) ? $label : [$value => $label])
                        ->only($data['type'])
                        ->all();

                    $indicators['type'] = 'Tipo empresa es: ' . collect($labels)->join(', ', ' o ');;
                }

                return $indicators;
            });
    }

    private function getDealsDataFilter()
    {
        return Filter::make('Datos Compra')
            ->form([]);
    }

    private function getProductsDataFilter()
    {
        return Filter::make('Datos Producto')
            ->form([]);
    }

    private function getActionsFilter()
    {
        return Filter::make('Acciones')
            ->form([]);
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
