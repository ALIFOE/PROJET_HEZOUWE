<?php

namespace App\Support;

use App\Models\News;
use Illuminate\Support\Collection;

class NewsCatalog
{
    public static function all(): Collection
    {
        // Fallback sur le config uniquement si la table est totalement vide (pas si tout est masqué)
        if (News::count() === 0) {
            return collect(config('news_hezouwe', []));
        }

        return News::where('is_visible', true)
            ->orderBy('date', 'desc')
            ->get()
            ->map(fn($n) => $n->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $newsItem = News::where('slug', $slug)->where('is_visible', true)->first();
        
        if ($newsItem) {
            return $newsItem->toArray();
        }

        // Fallback sur le fichier config
        return self::all()->firstWhere('slug', $slug);
    }

    public static function latest(int $limit = 4): Collection
    {
        return self::all()->take($limit);
    }
}
