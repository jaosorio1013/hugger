<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientContact;
use App\Models\Deal;
use App\Models\DealDetail;
use App\Models\User;
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
                'client_id' => $deal->client_id,
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
            'date' => Carbon::now()->subDays(rand(1, 350)),
            'total' => $this->faker->randomFloat(),

            'client_id' => Client::factory(),
            // 'client_contact_id' => ClientContact::factory(),
            'owner_id' => User::inRandomOrder()->value('id'),
        ];
    }
}
