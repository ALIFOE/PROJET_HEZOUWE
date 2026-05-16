<?php

namespace App\Support;

use App\Models\News;
use Illuminate\Support\Collection;

class NewsCatalog
{
    public static function all(): Collection
    {
        // Récupère les actualités de la base de données, avec fallback sur le config
        $news = News::orderBy('date', 'desc')->get();
        
        if ($news->isEmpty()) {
            return collect(config('news_hezouwe', []));
        }

        return $news->map(fn($n) => $n->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $newsItem = News::where('slug', $slug)->first();
        
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
