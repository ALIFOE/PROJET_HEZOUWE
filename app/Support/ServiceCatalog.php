<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Collection;

class ServiceCatalog
{
    public static function all(): Collection
    {
        // Récupère les services de la base de données, avec fallback sur le config
        $services = Service::all();
        
        if ($services->isEmpty()) {
            return collect(config('services_hezouwe', []));
        }

        return $services->map(fn($s) => $s->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $service = Service::where('slug', $slug)->first();
        
        if ($service) {
            return $service->toArray();
        }

        // Fallback sur le fichier config
        return self::all()->firstWhere('slug', $slug);
    }
}
