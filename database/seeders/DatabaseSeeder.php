<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->command->info('');
        $this->command->info('🌾 Seeding HEZOUWE...');
        $this->command->info('');

        $this->call([
            AdminSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            NewsSeeder::class,
        ]);

        $this->command->info('');
        $this->command->info('✅ Base de données prête.');
        $this->command->info('   Connexion admin : admin@hezouwe.com / admin123');
        $this->command->info('');
    }
}
