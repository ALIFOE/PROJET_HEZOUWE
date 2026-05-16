<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = config('services_hezouwe', []);

        foreach ($services as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']],
                [
                    'title' => $serviceData['title'] ?? '',
                    'icon' => $serviceData['icon'] ?? '',
                    'short' => $serviceData['short'] ?? '',
                    'description' => $serviceData['description'] ?? '',
                    'description2' => $serviceData['description2'] ?? null,
                    'image' => $serviceData['image'] ?? '',
                    'image2' => $serviceData['image2'] ?? null,
                    'image3' => $serviceData['image3'] ?? null,
                    'steps' => $serviceData['steps'] ?? [],
                    'benefits' => $serviceData['benefits'] ?? [],
                    'facts' => $serviceData['facts'] ?? [],
                ]
            );
        }
    }
}
