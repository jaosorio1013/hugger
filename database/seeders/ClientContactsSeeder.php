<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Database\Seeder;

class ClientContactsSeeder extends Seeder
{
    public function run(): void
    {
        Client::query()
            ->where('type', Client::TYPE_NATURAL)
            ->get(['id'])
            ->each(function (Client $client) {
                ClientContact::factory(rand(1, 5))->create([
                    'client_id' => $client->id,
                ]);
            });
    }
}
