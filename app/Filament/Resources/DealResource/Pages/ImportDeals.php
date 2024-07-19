<?php

namespace App\Filament\Resources\DealResource\Pages;

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Cache;
use Jaosorio1013\FilamentImport\Actions\ImportAction;
use Jaosorio1013\FilamentImport\Actions\ImportField;

class ImportDeals
{
    public static function action()
    {
        return ImportAction::make('Importar Compras')
            ->icon('heroicon-s-document-arrow-up')
            ->massCreate(false)
            ->fields([
                ImportField::make('Fecha')
                    ->rules('required', ['Fecha Requerida'])
                    ->required(),

                ImportField::make('Cliente')
                    ->rules('required', ['Cliente Requerido'])
                    ->required(),

                ImportField::make('Ítem')
                    ->rules('required', ['Producto Requerido'])
                    ->required(),

                ImportField::make('Cantidad')
                    ->rules('required|numeric')
                    ->required(),

                ImportField::make('Valor Unitario')
                    ->rules('required|numeric')
                    ->required(),

                ImportField::make('Venta Neta')
                    ->required(),

                ImportField::make('code')
                    ->label('Código Factura')
                    ->rules('required')
                    ->required(),
            ], columns: 2)
            ->handleRecordCreation(
                fn(array $data) => self::createDealDetail($data)

                // function (array $data) {
                //     ImportDealsJob::dispatch($data);
                //
                //     return new Deal();
                // }
            )
            ->after(
                fn(Deal $deal) => redirect(ListDeals::getUrl())
            )
            ;
    }

    private static function createDealDetail(array $data): DealDetail
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

    private static function product(array $data): Product
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

    private static function deal(array $data): Deal
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

    private static function client(array $data): Client
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