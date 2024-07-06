<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\Deal;
use App\Models\DealDetail;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DealDetailFactory extends Factory
{
    protected $model = DealDetail::class;

    public function definition(): array
    {
        $product = Product::inRandomOrder()->firstOrFail();
        $quantity = $this->faker->numberBetween(1, 10);
        $price = $product->price;


        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'quantity' => $quantity,
            'price' => $price,

            'deal_id' => Deal::factory(),
            'product_id' => $product->id,
            'client_id' => Client::factory(),
        ];
    }
}
