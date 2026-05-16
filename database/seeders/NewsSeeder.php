<?php

namespace Database\Seeders;

use App\Models\News;
use Illuminate\Database\Seeder;

class NewsSeeder extends Seeder
{
    public function run(): void
    {
        $newsList = config('news_hezouwe', []);

        foreach ($newsList as $newsData) {
            News::updateOrCreate(
                ['slug' => $newsData['slug']],
                [
                    'title' => $newsData['title'] ?? '',
                    'category' => $newsData['category'] ?? '',
                    'tag' => $newsData['tag'] ?? [],
                    'author' => $newsData['author'] ?? '',
                    'date' => $newsData['date_raw'] ?? now(),
                    'excerpt' => $newsData['excerpt'] ?? '',
                    'intro' => $newsData['intro'] ?? '',
                    'body' => $newsData['body'] ?? [],
                    'quote' => $newsData['quote'] ?? null,
                    'conclusion' => $newsData['conclusion'] ?? null,
                    'read' => $newsData['read'] ?? 1,
                    'comments' => $newsData['comments'] ?? 0,
                    'image' => $newsData['image'] ?? '',
                    'thumb' => $newsData['thumb'] ?? null,
                    'image2' => $newsData['image2'] ?? null,
                    'image3' => $newsData['image3'] ?? null,
                ]
            );
        }
    }
}
