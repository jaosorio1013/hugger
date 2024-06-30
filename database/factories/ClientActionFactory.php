<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientAction;
use App\Models\CrmAction;
use App\Models\CrmState;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientActionFactory extends Factory
{
    protected $model = ClientAction::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
            'notes' => $this->faker->word(),

            'client_id' => Client::inRandomOrder()->value('id'),
            'crm_action_id' => CrmAction::inRandomOrder()->value('id'),
            'crm_state_id' => CrmState::inRandomOrder()->value('id'),
        ];
    }
}
