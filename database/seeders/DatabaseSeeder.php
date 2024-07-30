<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(WorldSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProductsSeeder::class);

        // if (env('APP_ENV') === 'local') {
        //     $this->call(ClientsSeeder::class);
        //     $this->call(ClientContactsSeeder::class);
        //     $this->call(DealsSeeder::class);
        //     $this->call(ClientActionsSeeder::class);
        // }

        $client = Client::factory()->create([
            'name' => 'Jhonatan',
            'type' => Client::TYPE_NATURAL,
            'email' => 'ja.osorio1013@gmail.com',
        ]);

        $client->tags()->create([
            'name' => 'TEST1',
        ]);
    }
}
