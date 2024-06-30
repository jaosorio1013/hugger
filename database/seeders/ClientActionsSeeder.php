<?php

namespace Database\Seeders;

use App\Models\ClientAction;
use Illuminate\Database\Seeder;

class ClientActionsSeeder extends Seeder
{
    public function run(): void
    {
        ClientAction::factory(100)->create();
    }
}
