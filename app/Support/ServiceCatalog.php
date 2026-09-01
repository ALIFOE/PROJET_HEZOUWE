<?php

namespace App\Support;

use App\Models\Service;
use Illuminate\Support\Collection;

class ServiceCatalog
{
    public static function all(): Collection
    {
        // Fallback sur le config uniquement si la table est totalement vide (pas si tout est masqué)
        if (Service::count() === 0) {
            return collect(config('services_hezouwe', []));
        }

        return Service::where('is_visible', true)
            ->get()
            ->map(fn($s) => $s->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $service = Service::where('slug', $slug)->where('is_visible', true)->first();

        if ($service) {
            return $service->toArray();
        }

        // Fallback sur le fichier config
        return self::all()->firstWhere('slug', $slug);
    }
}
