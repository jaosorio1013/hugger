<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Client;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call(WorldSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(ProductsSeeder::class);

        if (env('APP_ENV') === 'local') {
            $this->call(ClientsSeeder::class);
            $this->call(ClientContactsSeeder::class);
            $this->call(DealsSeeder::class);
            $this->call(ClientActionsSeeder::class);
        }
    }
}
