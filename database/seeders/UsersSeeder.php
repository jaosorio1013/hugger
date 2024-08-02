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

        $users = [
            'Viviana Otalvaro' => 'alegria@huggerisland.org',
            'Santiago Otalvaro' => 'santiago.otalvaro@gmail.com',
            'Comercial Hugger' => 'valentia@huggerisland.org',
        ];

        foreach ($users as $name => $email) {
            User::factory()->create([
                'name' => $name,
                'email' => $email,
            ]);
        }
    }
}
