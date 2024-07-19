<?php

namespace App\Jobs;

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealDetail;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImportDealsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public array $data = [];

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function handle(): void
    {
        $this->transformData();
        $this->createDealDetail();
    }

    private function createDealDetail(): void
    {
        $deal = $this->deal();

        $productId = $this->product()->id ?? null;

        $detail = DealDetail::firstOrCreate([
            'deal_id' => $deal->id,
            'client_id' => $deal->client_id,
            'product_id' => $productId,
        ]);

        $detail->update([
            'quantity' => $this->data['Cantidad'],
            'price' => $this->data['Valor Unitario'],
        ]);
    }

    private function product(): Product
    {
        // return Cache::rememberForever('product-' . $this->data['Ítem'], function () {
            $product = Product::firstOrCreate([
                'name' => $this->data['Ítem'],
            ]);
            if ($product->wasRecentlyCreated) {
                $product->update([
                    'price' => $this->data['Valor Unitario'],
                ]);
            }

            return $product;
        // });
    }

    private function deal(): Deal
    {
        // return Cache::rememberForever('deal-' . $this->data['code'], function () {
            $deal = Deal::firstOrCreate([
                'code' => $this->data['code'],
            ]);
            if ($deal->wasRecentlyCreated) {
                $deal->update([
                    'client_id' => $this->client($this->data)->id,
                    'date' => $this->data['Fecha'],
                ]);
            }

            return $deal;
        // });
    }

    private function client(): Client
    {
        // return Cache::rememberForever('client-' . $this->data['Cliente'], function () {
            $client = Client::firstOrCreate([
                'name' => $this->data['Cliente'],
            ]);

            if ($client->wasRecentlyCreated) {
                $client->update([
                    'type' => Client::TYPE_COMPANY,
                ]);
            }

            return $client;
        // });
    }

    private function transformData(): void
    {
        $excel_date_cell = $this->data['Fecha'];
        $UNIX_DATE_FORMAT = ($excel_date_cell - 25569) * 86400;
        $this->data['Fecha'] = gmdate("Y-m-d", $UNIX_DATE_FORMAT);

        // $this->>data['Valor Unitario'] = (float)$this->>data['Valor Unitario'];

        // unset($this->>data['Venta Neta']);
    }
}
