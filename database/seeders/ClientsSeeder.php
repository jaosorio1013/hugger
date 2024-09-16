<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\Tag;
use Illuminate\Database\Seeder;

class ClientsSeeder extends Seeder
{
    public function run(): void
    {
        $tags = Tag::factory(10)->create();
        Client::factory(10)->create()->each(function (Client $client) use ($tags) {
            $client->tags()->attach($tags->random(rand(1, 4)));
        });
    }
}
