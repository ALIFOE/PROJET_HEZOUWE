<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'baudoinalifoe.dcli.dev24@gmail.com'],
            [
                'name'              => 'Admin HEZOUWE',
                'role'              => 'admin',
                'password'          => Hash::make('Admin@2024'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('  Admin créé : baudoinalifoe.dcli.dev24@gmail.com / Admin@2024');
    }
}
