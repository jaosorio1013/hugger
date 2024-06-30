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
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'quantity' => $this->faker->randomNumber(),
            'price_per_unit' => $this->faker->randomFloat(),
            'total' => $this->faker->randomFloat(),

            'deal_id' => Deal::factory(),
            'client_id' => Client::factory(),
            'product_id' => Product::factory(),
        ];
    }
}
