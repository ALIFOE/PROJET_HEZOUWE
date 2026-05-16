<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = config('products_hezouwe', []);

        foreach ($products as $productData) {
            Product::updateOrCreate(
                ['slug' => $productData['slug']],
                [
                    'title' => $productData['title'] ?? '',
                    'category' => $productData['category'] ?? '',
                    'short' => $productData['short'] ?? '',
                    'description' => $productData['description'] ?? '',
                    'image' => $productData['image'] ?? '',
                    'images' => $productData['images'] ?? [],
                    'price' => $productData['price'] ?? 0,
                    'price_promo' => $productData['price_promo'] ?? null,
                    'discount' => $productData['discount'] ?? 0,
                    'badge' => $productData['badge'] ?? null,
                    'stars' => $productData['stars'] ?? 5,
                    'reviews' => $productData['reviews'] ?? 0,
                    'in_stock' => $productData['in_stock'] ?? true,
                    'details' => $productData['details'] ?? [],
                    'features' => $productData['features'] ?? [],
                ]
            );
        }
    }
}
