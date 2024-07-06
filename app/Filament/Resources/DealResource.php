<?php

namespace App\Filament\Resources;

use App\Filament\Resources\DealResource\Pages;
use App\Models\Deal;
use App\Models\Product;
use Awcodes\TableRepeater\Components\TableRepeater;
use Awcodes\TableRepeater\Header;
use Filament\Forms\Components\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Repeater;
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
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Actions\ForceDeleteAction;
use Filament\Tables\Actions\ForceDeleteBulkAction;
use Filament\Tables\Actions\RestoreAction;
use Filament\Tables\Actions\RestoreBulkAction;
use Filament\Tables\Actions\ViewAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TrashedFilter;
use Filament\Tables\Table;
use Icetalker\FilamentTableRepeatableEntry\Infolists\Components\TableRepeatableEntry;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class DealResource extends Resource
{
    protected static ?string $model = Deal::class;

    protected static ?string $slug = 'deals';

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-check';

    protected static ?int $navigationSort = 3;
    protected static ?string $label = 'Compra';
    protected static ?string $pluralLabel = 'Compras';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()->columns(2)->schema([
                    TextInput::make('code')
                        ->label('Factura'),

                    DatePicker::make('date')
                        ->label('Fecha Compra'),

                    // TextInput::make('total')
                    //     ->prefix('$')
                    //     ->suffix('COP')
                    //     ->numeric(),

                    Select::make('client_id')
                        ->label('Cliente')
                        ->relationship('client', 'name')
                        ->searchable()
                        ->required(),

                    Select::make('client_contact_id')
                        ->label('Contacto cliente')
                        ->relationship('contact', 'name')
                        ->searchable()
                        ->required(),

                    // Placeholder::make('created_at')
                    //     ->label('Created Date')
                    //     ->content(fn(?Deal $record): string => $record?->created_at?->diffForHumans() ?? '-'),
                    //
                    // Placeholder::make('updated_at')
                    //     ->label('Last Modified Date')
                    //     ->content(fn(?Deal $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
                ]),

                Section::make('Detalle')
                    ->headerActions([
                        Action::make('Borrar')
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
            ]);
    }

    public static function getDealProducts()
    {
        return TableRepeater::make('details')
            ->relationship()
            ->headers([
                Header::make('Producto'),
                Header::make('Cantidad'),
                Header::make('Precio Unitario'),
                Header::make('Total'),
            ])
            ->schema([
                Select::make('product_id')
                    ->label('Producto')
                    ->options(Product::query()->pluck('name', 'id'))
                    ->live()
                    ->required()
                    ->afterStateUpdated(
                        function (Get $get, Set $set) {
                            $set('price', Product::find($get('product_id'))?->price ?? 0);
                            $set('total', $get('price') * $get('quantity'));
                        }
                    )
                    ->distinct()
                    ->disableOptionsWhenSelectedInSiblingRepeaterItems()
                    ->columnSpan([
                        'md' => 5,
                    ])
                    ->searchable(),

                TextInput::make('quantity')
                    ->afterStateUpdated(
                        fn(Get $get, $livewire, Set $set) =>
                        $set('total', $get('price') * $get('quantity'))
                    )
                    ->numeric()
                    ->minValue(1)
                    ->default(1)
                    ->required()
                    ->live()
                    ->columnSpan([
                        'md' => 1,
                    ]),

                TextInput::make('price')
                    // ->label('Valor Unitario')
                    ->prefix('$')
                    ->suffix('COP')
                    ->afterStateUpdated(
                        fn(Get $get, $livewire, Set $set) =>
                        $set('total', $get('price') * $get('quantity'))
                    )
                    ->minValue(0)
                    ->required()
                    ->numeric()
                    ->live(),

                TextInput::make('total')
                    ->afterStateUpdated(
                        fn(Get $get, $livewire, Set $set) =>
                        $set('.total', 123)
                    )
                    ->prefix('$')
                    ->suffix('COP')
                    ->required()
                    ->disabled()
                    ->numeric()
                    ->live(),
            ])
            ->live()
            ->afterStateUpdated(function (Get $get, $livewire) {
                self::updateTotals($get, $livewire);
            })
            ->deleteAction(
                fn (Action $action) => $action->after(fn (Get $get, $livewire) => self::updateTotals($get, $livewire)),
            )
            // ->reorderable(true)
            ->required();
    }

    public static function updateTotals(Get $get, $livewire): void
    {
        // Retrieve the state path of the form. Most likely, it's `data` but could be something else.
        $statePath = $livewire->getFormStatePath();

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
            ->columns([
                TextColumn::make('date')
                    ->label('Fecha Compra')
                    ->date(),

                TextColumn::make('code')
                    ->label('Factura'),

                TextColumn::make('client.name')
                    ->label('Cliente')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('total')
                    ->money('cop'),

                // TextColumn::make('products')->counts(''),
                // TableRepeatableEntry::make('details')
                //     ->label('Detalle')
                //     ->schema([
                //         TextEntry::make('product.name'),
                //         TextEntry::make('quantity'),
                //         TextEntry::make('price'),
                //         TextEntry::make('total'),
                //     ])
                //     ->striped()
                //     ->columnSpan(2),
            ])
            ->filters([
                TrashedFilter::make(),
            ])
            ->actions([
                ViewAction::make()->label(' '),
                EditAction::make()->label(''),
                DeleteAction::make()->label(''),
                RestoreAction::make(),
                ForceDeleteAction::make(),
            ])
            ->bulkActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                    RestoreBulkAction::make(),
                    ForceDeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListDeals::route('/'),
            'create' => Pages\CreateDeal::route('/create'),
            'edit' => Pages\EditDeal::route('/{record}/edit'),
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
                    ->label('Fecha Compra')
                    ->date(),

                TextEntry::make('code')
                    ->label('Factura'),

                TextEntry::make('client.name')
                    ->label('Cliente'),

                TextEntry::make('total')
                    ->money('cop'),

                TableRepeatableEntry::make('details')
                    ->label('Detalle')
                    ->schema([
                        TextEntry::make('product.name'),
                        TextEntry::make('quantity'),
                        TextEntry::make('price'),
                        TextEntry::make('total'),
                    ])
                    ->striped()
                    ->columnSpan(2),
            ]);
    }
}
