<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ClientResource\Pages;
use App\Filament\Resources\ClientResource\RelationManagers\ClientActionsRelationManager;
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
                ->label('Nombre')
                ->required(),

            TextInput::make('nit')
                ->label('Número Identificación'),

            TextInput::make('phone')
                ->label('Teléfono'),

            TextInput::make('email')
                ->label('Email'),

            TextInput::make('address')
                ->label('Dirección'),

            Select::make('user_id')
                ->label('Responsable')
                ->relationship('user', 'name')
                ->searchable(),

            Select::make('crm_font_id')
                ->label('Fuente de contacto')
                ->relationship('font', 'name'),

            Select::make('crm_mean_id')
                ->label('Medio de contacto')
                ->relationship('mean', 'name'),

            Select::make('location_city_id')
                ->label('Ciudad')
                ->relationship('city', 'name')
                ->searchable(),
        ];
    }

    public static function getRelations(): array
    {
        return [
            ContactsRelationManager::class,
            ClientActionsRelationManager::class,
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
}
