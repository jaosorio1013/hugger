<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\CrmFont;
use App\Models\CrmMean;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientContactFactory extends Factory
{
    protected $model = ClientContact::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'charge' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),

            'client_id' => Client::factory(),
        ];
    }
}
