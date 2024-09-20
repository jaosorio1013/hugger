<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealResource\Pages\CreateDeal;
use App\Filament\Resources\DealResource\Pages\EditDeal;
use App\Filament\Resources\DealResource\Pages\ListDeals;
use App\Filament\Resources\DealResource\UpdateTotalsOnDeals;
use App\Models\Deal;
use App\Models\Product;
use App\Tables\Columns\DealDetailsColumn;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Forms\Set;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Filament\Tables\Filters\QueryBuilder\Constraints\TextConstraint;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Livewire\Component as Livewire;

class DealResource extends Resource
{
    public function bar(): string
    {
        return 'asdasd';
    }

    use UpdateTotalsOnDeals;

    protected static ?string $model = Deal::class;

    protected static ?string $slug = 'deals';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?int $navigationSort = 3;
    protected static ?string $label = 'Venta';
    protected static ?string $pluralLabel = 'Ventas';

    public static function form(Form $form): Form
    {
        return $form
            ->schema(self::getFormSchema());
    }

    public static function getFormSchema(bool $onRelationManager = false): array
    {
        return [
            Section::make()->columns(2)->schema([
                TextInput::make('code')
                    ->label('Factura'),

                DatePicker::make('date')
                    ->label('Fecha Venta'),

                Select::make('client_id')
                    ->label('Cliente')
                    ->relationship('client', 'name')
                    ->searchable()
                    ->preload()
                    ->default(
                        request()->get('client_id')
                    )
                    ->required(),

                // Select::make('client_contact_id')
                //     ->label('Contacto cliente')
                //     ->relationship('contact', 'name')
                //     ->searchable(),
            ]),

            Section::make('Detalle')
                ->headerActions([
                    Action::make('Eliminar Productos de la Venta')
                        // ->modalHeading('Estas seguro?')
                        ->modalDescription('Todos los artículos existentes se eliminarán del pedido.')
                        ->requiresConfirmation()
                        ->color('danger')
                        ->action(fn (Set $set) => $set('details', [])),
                ])
                ->schema([
                    static::getDealProducts()
                ]),

            Section::make()
                ->columns(1)
                ->schema([
                    TextInput::make('total')
                        ->label('Gran Total')
                        ->disabled()
                        ->numeric()
                        ->required()
                        ->prefix('$')
                        ->suffix('COP')
                ])
        ];
    }

    public static function getDealProducts(): TableRepeater
    {
        return TableRepeater::make('details')
            ->relationship()
            ->headers([
                Header::make('Producto'),
                Header::make('Cantidad'),
                Header::make('Valor Unitario'),
                Header::make('Total'),
            ])
            ->schema([
                Select::make('product_id')
                    ->label('Producto')
                    ->options(Product::query()->pluck('name', 'id'))
                    ->required()
                    ->afterStateUpdated(
                        function (Get $get, Set $set, $livewire) {
                            $set('price', Product::find($get('product_id'))?->price ?? 0);
                            $set('total', $get('price') * $get('quantity'));
                            self::updateTotals($get, $livewire);
                        }
                    )
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->searchable(),

                TextInput::make('quantity')
                    ->afterStateUpdated(
                        fn (Get $get, $livewire, Set $set) => $set('total', $get('price') * $get('quantity'))
                    )
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required(),

                TextInput::make('price')
                    ->label('Valor Unitario')
                    ->prefix('$')
                    ->suffix('COP')
                    ->afterStateUpdated(
                        fn (Get $get, $livewire, Set $set) => $set('total', $get('price') * $get('quantity'))
                    )
                    ->minValue(0)
                    ->required()
                    ->numeric(),

                TextInput::make('total')
                    ->prefix('$')
                    ->suffix('COP')
                    ->required()
                    ->disabled()
                    ->numeric(),
            ])
            ->live(true)
            ->afterStateUpdated(function (Get $get, $livewire) {
                self::updateTotals($get, $livewire);
            })
            ->deleteAction(
                fn (Action $action) => $action->after(
                    fn (Get $get, $livewire) => self::updateTotals($get, $livewire)
                ),
            )
            ->required();
    }

    public static function updateTotals(Get $get, Livewire $livewire): void
    {
        // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
        $statePath = $livewire->getFormStatePath();
        // $statePath = 'data';

        $products = data_get($livewire, $statePath . '.details');
        if (collect($products)->isEmpty()) {
            return;
        }

        $selectedProducts = collect($products)->filter(fn ($item) => !empty($item['product_id']) && !empty($item['quantity']));

        $prices = collect($products)->pluck('price', 'product_id');

        $subtotal = $selectedProducts->reduce(function ($subtotal, $product) use ($prices) {
            return $subtotal + ($prices[$product['product_id']] * $product['quantity']);
        }, 0);

        data_set($livewire, $statePath . '.total', number_format($subtotal + ($subtotal * (data_get($livewire, $statePath . '.taxes') / 100)), 2, '.', ''));
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('date', 'desc')
            ->filtersFormColumns(4)
            ->filters([
                Filter::make('factura')
                    ->form([
                        TextInput::make('code')
                            ->label('Factura'),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['code'],
                                fn (Builder $query, $date): Builder => $query->whereLike('code', "%$date%"),
                            );
                    }),

                SelectFilter::make('products.name')
                    ->relationship('products', 'name')
                    ->label('Producto')
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->columns(static::getTableColumns())
            // ->actions([
            //     DeleteAction::make()->label(''),
            //     RestoreAction::make(),
            //     ForceDeleteAction::make(),
            // ])
            ->recordUrl(fn ($record) => EditDeal::getUrl([$record]))
            ->bulkActions([
                // BulkActionGroup::make([
                //     DeleteBulkAction::make(),
                //     RestoreBulkAction::make(),
                //     ForceDeleteBulkAction::make(),
                // ]),
            ]);
    }

    public static function getTableColumns(): array
    {
        return [
            Split::make([
                TextColumn::make('date')
                    ->label('Fecha Venta')
                    ->sortable()
                    ->date(),

                TextColumn::make('code')
                    ->label('Factura'),

                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->sortable(),

                TextColumn::make('total')
                    ->money('cop')
                    ->prefix('$ '),
            ]),

            Panel::make([
                DealDetailsColumn::make('details')
            ])->collapsible(true),
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListDeals::route('/'),
            'create' => CreateDeal::route('/create'),
            'edit' => EditDeal::route('/{record}/edit'),
        ];
    }

    public static function getGlobalSearchEloquentQuery(): Builder
    {
        return parent::getGlobalSearchEloquentQuery()->with(['client']);
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['client.name'];
    }

    public static function getGlobalSearchResultDetails(Model $record): array
    {
        $details = [];

        if ($record->client) {
            $details['Client'] = $record->client->name;
        }

        return $details;
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                TextEntry::make('date')
                    ->label('Fecha Venta')
                    ->date(),

                TextEntry::make('code')
                    ->label('Factura'),

                TextEntry::make('client.name')
                    ->label('Cliente'),

                TextEntry::make('total')
                    ->money('cop')
                    ->prefix('$ '),

                TableRepeatableEntry::make('details')
                    ->label('Detalle')
                    ->schema([
                        TextEntry::make('product.name')
                            ->label('Producto'),

                        TextEntry::make('quantity')
                            ->label('Cantidad'),

                        TextEntry::make('price')
                            ->label('Precio')
                            ->money('cop')
                            ->prefix('$ '),

                        TextEntry::make('total')
                            ->money('cop')
                            ->prefix('$ '),
                    ])
                    ->striped()
                    ->columnSpan(2),
            ]);
    }
}
