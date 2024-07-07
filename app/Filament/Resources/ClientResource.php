<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\ActionsRelationManager;
use App\Filament\Resources\ClientResource\RelationManagers\ContactsRelationManager;
use App\Filament\Resources\ClientResource\RelationManagers\DealsRelationManager;
use App\Models\Client;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\Tabs\Tab;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\TextEntry;
use Filament\Resources\Resource;
use Filament\Tables\Actions\Action;
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
use Filament\Tables\Filters\BaseFilter;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Carbon;
use Illuminate\Support\HtmlString;

class ClientResource extends Resource
{
    protected static ?string $model = Client::class;

    protected static ?string $slug = 'clients';

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    protected static ?int $navigationSort = 2;
    protected static ?string $label = 'Cliente';
    protected static ?string $pluralLabel = 'Clientes';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(static::getFormFields());
    }

    public static function getFormFields(): array
    {
        return [
            Select::make('type')
                ->options([
                    Client::TYPE_NATURAL => 'Persona Natural',
                    Client::TYPE_COMPANY => 'Empresa',
                    Client::TYPE_ALLIED => 'Aliado',
                ])
                ->label('Tipo')
                ->required(),

            TextInput::make('name')
                ->required(),

            TextInput::make('nit')
                ->label('Número Identificación'),

            TextInput::make('phone')
                ->label('Teléfono'),

            TextInput::make('address')
                ->label('Dirección'),

            Select::make('user_id')
                ->relationship('user', 'name')
                ->searchable(),

            Select::make('crm_font_id')
                ->relationship('font', 'name'),

            Select::make('crm_mean_id')
                ->relationship('mean', 'name'),

            Select::make('location_city_id')
                ->relationship('city', 'name')
                ->searchable(),
        ];
    }

    public static function table(Table $table): Table
    {
        return $table
            ->actions(static::getTableActions())
            ->columns(static::getTableColumns())
            ->filters(static::getTableFilter(), layout: FiltersLayout::AboveContent)
            // ->filters(static::getTableFilter(), layout: FiltersLayout::AboveContentCollapsible)
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getTableColumns(): array
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

    public static function getTableFilter(): array
    {
        return [
            static::getCompanyDataFilter(),
            static::getDealsDataFilter(),
            static::getProductsDataFilter(),
            static::getActionsFilter(),
        ];
    }

    private static function getCompanyDataFilter()
    {
        $clientTypes = [
            Client::TYPE_NATURAL => 'Persona Natural',
            Client::TYPE_COMPANY => 'Empresa',
            Client::TYPE_ALLIED => 'Aliado',
        ];
        
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
                    $labels = collect($clientTypes)
                        ->mapWithKeys(fn (string | array $label, string $value): array => is_array($label) ? $label : [$value => $label])
                        ->only($data['type'])
                        ->all();

                    $indicators['type'] = 'Tipo empresa es: ' . collect($labels)->join(', ', ' o ');;
                }

                return $indicators;
            });
    }

    private static function getDealsDataFilter()
    {
        return Filter::make('Datos Compra')
            ->form([]);
    }

    private static function getProductsDataFilter()
    {
        return Filter::make('Datos Producto')
            ->form([]);
    }

    private static function getActionsFilter()
    {
        return Filter::make('Acciones')
            ->form([]);
    }

    public static function getTableActions(): array
    {
        return [
            Action::make('Contactos')
                ->hidden(fn($record) => $record->contacts->isEmpty())
                ->icon('heroicon-o-users')
                ->color('info')
                ->label('')
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
                ]),
            EditAction::make()->label(''),
            // DeleteAction::make()->label(''),
            RestoreAction::make(),
            ForceDeleteAction::make(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ContactsRelationManager::class,
            ActionsRelationManager::class,
            DealsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListClients::route('/'),
            'create' => Pages\CreateClient::route('/create'),
            'edit' => Pages\EditClient::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['font', 'mean', 'user']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'font.name', 'mean.name', 'user.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->font) {
            $details['Font'] = $record->font->name;
        }

        if ($record->mean) {
            $details['Mean'] = $record->mean->name;
        }

        if ($record->user) {
            $details['User'] = $record->user->name;
        }

        return $details;
    }
}
