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

            Column::make('status_name')->heading('Estado'),

            Column::make('font.name')->heading('Fuente'),

            Column::make('mean.name')->heading('Medio'),

            Column::make('city.name')->heading('Ciudad'),

            // Column::make('tags')->listAsJson(),
        ]);
    }
}
