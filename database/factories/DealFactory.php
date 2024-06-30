<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Deal;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class DealFactory extends Factory
{
    protected $model = Deal::class;

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
