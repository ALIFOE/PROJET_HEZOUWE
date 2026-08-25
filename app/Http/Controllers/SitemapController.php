<?php

namespace App\Http\Controllers;

use App\Support\NewsCatalog;
use App\Support\ProductCatalog;
use App\Support\ServiceCatalog;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    public function index(): Response
    {
        $staticPages = [
            ['route' => 'home', 'priority' => '1.0', 'changefreq' => 'weekly'],
            ['route' => 'about', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['route' => 'shop', 'priority' => '0.9', 'changefreq' => 'weekly'],
            ['route' => 'service', 'priority' => '0.8', 'changefreq' => 'monthly'],
            ['route' => 'contact', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'project', 'priority' => '0.6', 'changefreq' => 'monthly'],
            ['route' => 'news', 'priority' => '0.8', 'changefreq' => 'weekly'],
            ['route' => 'team', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'gallery', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'faq', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'testimonial', 'priority' => '0.5', 'changefreq' => 'monthly'],
            ['route' => 'history', 'priority' => '0.5', 'changefreq' => 'yearly'],
            ['route' => 'pricing', 'priority' => '0.6', 'changefreq' => 'monthly'],
        ];

        $urls = [];

        foreach ($staticPages as $page) {
            $urls[] = [
                'loc' => route($page['route']),
                'priority' => $page['priority'],
                'changefreq' => $page['changefreq'],
            ];
        }

        foreach (ProductCatalog::all() as $product) {
            $urls[] = [
                'loc' => route('shop-details.slug', ['slug' => $product['slug']]),
                'priority' => '0.7',
                'changefreq' => 'weekly',
            ];
        }

        foreach (ServiceCatalog::all() as $service) {
            $urls[] = [
                'loc' => route('service-details.slug', ['slug' => $service['slug']]),
                'priority' => '0.7',
                'changefreq' => 'monthly',
            ];
        }

        foreach (NewsCatalog::all() as $article) {
            $urls[] = [
                'loc' => route('news-details.slug', ['slug' => $article['slug']]),
                'priority' => '0.6',
                'changefreq' => 'monthly',
                'lastmod' => !empty($article['date'])
                    ? \Illuminate\Support\Carbon::parse($article['date'])->toAtomString()
                    : null,
            ];
        }

        return response()
            ->view('sitemap', ['urls' => $urls])
            ->header('Content-Type', 'application/xml');
    }
}
