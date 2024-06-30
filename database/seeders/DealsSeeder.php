<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Deal;
use Illuminate\Database\Seeder;

class DealsSeeder extends Seeder
{
    public function run(): void
    {
        Client::query()
            ->take(8)
            ->pluck('id')
            ->each(fn ($clientId) => Deal::factory(rand(1, 5))->create([
                'client_id' => $clientId
            ]));
    }
}
