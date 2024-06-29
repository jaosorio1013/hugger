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
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'name' => $this->faker->name(),
            'nit' => $this->faker->word(),
            'phone' => $this->faker->phoneNumber(),
            'address' => $this->faker->address(),
            'type' => $this->faker->randomNumber(),

            'user_id' => User::factory(),
            'crm_font_id' => CrmFont::factory(),
            'crm_mean_id' => CrmMean::factory(),
        ];
    }
}
