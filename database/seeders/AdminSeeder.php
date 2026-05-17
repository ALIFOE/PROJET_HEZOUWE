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
            ['email' => 'admin@hezouwe.com'],
            [
                'name'              => 'Admin HEZOUWE',
                'email'             => 'admin@hezouwe.com',
                'role'              => 'admin',
                'password'          => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('  Admin créé : admin@hezouwe.com / admin123');
    }
}
