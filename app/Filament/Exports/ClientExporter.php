<?php

namespace App\Filament\Exports;

use App\Models\Client;
use pxlrbt\FilamentExcel\Columns\Column;
use pxlrbt\FilamentExcel\Exports\ExcelExport;

class ClientExporter extends ExcelExport
{
    public function setUp(): void
    {
        // $this->queue();

        $this->withFilename('Clientes');

        $this->withColumns([
            Column::make('type')
                ->heading('Tipo')
                ->formatStateUsing(fn($record) => Client::TYPES[$record->type]),

            Column::make('nit')->heading('Identificación'),

            Column::make('name')->heading('Nombre'),

            Column::make('phone')->heading('Teléfono'),

            Column::make('user.name')->heading('Respondable'),

            Column::make('stage.name')->heading('Estado Pipeline'),

            Column::make('font.name')->heading('Fuente'),

            Column::make('city')
                ->heading('Ciudad')
                ->formatStateUsing(
                    fn($record) => $record->location_city_id ? $record->city->name . ', ' . $record->city->state->name : null,
                ),

            Column::make('tags')->formatStateUsing(
                fn($record) => $record->tags->pluck('name')->join(', '),
            ),
        ]);
    }
}
