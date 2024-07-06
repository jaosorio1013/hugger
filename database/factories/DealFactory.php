<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Deal;
use App\Models\DealDetail;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DealFactory extends Factory
{
    protected $model = Deal::class;

    public function configure(): DealFactory
    {
        return $this->afterCreating(function (Deal $deal) {
            DealDetail::factory(random_int(1, 5))->create([
                'deal_id' => $deal->id,
            ]);
        });
    }

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'code' => $this->faker->word(),
            'client_name' => $this->faker->name(),
            'date' => Carbon::now(),
            'total' => $this->faker->randomFloat(),

            'client_id' => Client::factory(),
            'client_contact_id' => ClientContact::factory(),
        ];
    }
}
