<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Jaosorio1013\FilamentImport\Actions\ImportAction;
use Jaosorio1013\FilamentImport\Actions\ImportField;

class ImportClients
{
    public static function action()
    {
        return ImportAction::make('Importar')
            ->icon('heroicon-s-document-arrow-up')
            ->massCreate(false)
            ->fields([
                ImportField::make('name')
                    ->label('Nombre')
                    ->rules('required', ['Nombre Requerido'])
                    ->required(),

                ImportField::make('nit')->label('Identificación'),

                ImportField::make('phone')->label('Teléfono'),

                ImportField::make('email')->rules('email'),

                ImportField::make('font')->label('Fuente de contacto')
                    ->rules(['exists:crm_fonts,name']),

                ImportField::make('mean')->label('Medio de contacto')
                    ->rules(['exists:crm_means,name']),

                ImportField::make('type')
                    ->rules('in:Natural,Empresa,Aliado'),
            ], columns: 2)
            ->handleRecordCreation(
                fn (array $data) => self::createDealDetail($data)

                // function (array $data) {
                //     ImportDealsJob::dispatch($data);
                //
                //     return new Deal();
                // }
            )
            ->after(
                fn (Deal $deal) => redirect(ListDeals::getUrl())
            );
    }

    private static function createDealDetail(array $data)
    {
        $data = self::transformData($data);
        $deal = self::deal($data);

        $detail = DealDetail::firstOrCreate([
            'deal_id' => $deal->id,
            'client_id' => $deal->client_id,
            'product_id' => self::product($data)->id ?? null,
        ]);

        $detail->update([
            'quantity' => $data['Cantidad'],
            'price' => $data['Valor Unitario'],
            'total' => $data['Valor Unitario'] * $data['Cantidad'],
        ]);

        return $detail;
    }

    private static function product(array $data)
    {
        return Cache::rememberForever('product-' . $data['Ítem'], function () use ($data) {
            $product = Product::firstOrCreate([
                'name' => $data['Ítem'],
            ]);
            if ($product->wasRecentlyCreated) {
                $product->update([
                    'price' => $data['Valor Unitario'],
                ]);
            }

            return $product;
        });
    }

    private static function deal(array $data)
    {
        return Cache::rememberForever('deal-' . $data['code'], function () use ($data) {
            $deal = Deal::firstOrCreate([
                'code' => $data['code'],
            ]);
            if ($deal->wasRecentlyCreated) {
                $deal->update([
                    'client_id' => self::client($data)->id,
                    'date' => $data['Fecha'],
                ]);
            }

            return $deal;
        });
    }

    private static function client(array $data)
    {
        return Cache::rememberForever('client-' . $data['Cliente'], function () use ($data) {
            $client = Client::firstOrCreate([
                'name' => $data['Cliente'],
            ]);

            if ($client->wasRecentlyCreated) {
                $client->update([
                    'type' => Client::TYPE_COMPANY,
                ]);
            }

            return $client;
        });
    }

    private static function transformData(array $data): array
    {
        $excel_date_cell = $data['Fecha'];
        $UNIX_DATE_FORMAT = ($excel_date_cell - 25569) * 86400;
        $data['Fecha'] = gmdate("Y-m-d", $UNIX_DATE_FORMAT);

        // $data['Valor Unitario'] = (float)$data['Valor Unitario'];

        // unset($data['Venta Neta']);

        return $data;
    }
}
