<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\ClientAction;
use App\Models\CrmAction;
use App\Models\CrmActionState;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ClientActionFactory extends Factory
{
    protected $model = ClientAction::class;

    public function definition(): array
    {
        return [
            'created_at' => Carbon::now()->subDays(rand(1, 350)),
            'updated_at' => Carbon::now(),
            'notes' => $this->faker->word(),

            'user_id' => User::inRandomOrder()->value('id'),
            'client_id' => Client::inRandomOrder()->value('id'),
            'crm_action_id' => CrmAction::inRandomOrder()->value('id'),
            'crm_action_state_id' => CrmActionState::inRandomOrder()->value('id'),
        ];
    }
}
