<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CrmFontResource\Pages;
use App\Models\CrmFont;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables\Actions\BulkActionGroup;
use Filament\Tables\Actions\DeleteAction;
use Filament\Tables\Actions\DeleteBulkAction;
use Filament\Tables\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CrmFontResource extends Resource
{
    protected static ?string $model = CrmFont::class;

    protected static ?string $slug = 'crm-fonts';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 12;
    protected static ?string $navigationLabel = 'Fuentes';
    protected static ?string $label = 'Fuente Contacto';
    protected static ?string $pluralLabel = 'Fuentes Contacto';
    protected static ?string $navigationGroup = 'Gestión';
    // protected static bool $shouldRegisterNavigation = false;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required(),

                Placeholder::make('created_at')
                    ->label('Created Date')
                    ->content(fn(?CrmFont $record): string => $record?->created_at?->diffForHumans() ?? '-'),

                Placeholder::make('updated_at')
                    ->label('Last Modified Date')
                    ->content(fn(?CrmFont $record): string => $record?->updated_at?->diffForHumans() ?? '-'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable(),
            ])
            ->filters([
                //
            ])
            ->actions([
                EditAction::make()->label(''),
                // DeleteAction::make()->label(''),
            ])
            // ->bulkActions([
            //     BulkActionGroup::make([
            //         DeleteBulkAction::make(),
            //     ]),
            // ])
            ;
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCrmFonts::route('/'),
            'create' => Pages\CreateCrmFont::route('/create'),
            'edit' => Pages\EditCrmFont::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name'];
    }
}
