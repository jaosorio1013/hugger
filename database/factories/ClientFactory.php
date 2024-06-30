<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\CrmFont;
use App\Models\CrmMean;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientFactory extends Factory
{
    protected $model = Client::class;

    public function definition(): array
    {
        $userId = null;
        if (rand(1, 10) % 2 === 0) {
            $userId = User::inRandomOrder()->value('id');
        }

        $fontId = CrmFont::inRandomOrder()->value('id');
        $meanId = CrmMean::inRandomOrder()->value('id');

        $type = $this->faker->randomElement([Client::TYPE_NATURAL, Client::TYPE_COMPANY, Client::TYPE_ALLIED]);

        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'email' =>  $type === Client::TYPE_NATURAL ? $this->faker->safeEmail() : null,
            'nit' => $this->faker->numberBetween(1000000, 9999999),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'type' => $type,

            'user_id' => $userId,
            'crm_font_id' => $fontId,
            'crm_mean_id' => $meanId,
        ];
    }
}
