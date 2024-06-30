<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\ClientContact;
use Illuminate\Database\Seeder;

class ClientContactsSeeder extends Seeder
{
    public function run(): void
    {
        $clients = Client::all();
        foreach ($clients as $client) {
            if ($client->type === Client::TYPE_NATURAL) {
                continue;
            }

            $quantity = random_int(1, 10);

            ClientContact::factory($quantity)->create([
                'client_id' => $client->id,
            ]);
        }
    }
}
