<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        if (env('APP_ENV') === 'local') {
            User::factory()->create([
                'name' => 'Example',
                'email' => 'test@example.com',
                'is_admin' => true,
                'show_on_charts' => false,
            ]);
        }

        User::factory()->create([
            'name' => 'Jhonatan',
            'email' => 'jaosorio1013@gmail.com',
            'is_admin' => true,
            'show_on_charts' => false,
        ]);

        $users = ['abundancia', 'alegria', 'hope'];

        foreach ($users as $user) {
            User::factory()->create([
                'name' => $user,
                'email' => $user . '@huggerisland.org',
                'password' => bcrypt($user),
            ]);
        }
    }
}
