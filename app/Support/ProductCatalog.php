<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductCatalog
{
    public static function all(): Collection
    {
        // Récupère les produits de la base de données, avec fallback sur le config
        $products = Product::all();
        
        if ($products->isEmpty()) {
            return collect(config('products_hezouwe', []));
        }

        return $products->map(fn($p) => $p->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $product = Product::where('slug', $slug)->first();
        
        if ($product) {
            return $product->toArray();
        }

        // Fallback sur le fichier config
        return self::all()->firstWhere('slug', $slug);
    }

    public static function hydrateCartItems(Collection $cartItems): Collection
    {
        return $cartItems
            ->map(function ($item) {
                $product = self::find($item->product_slug);

                if (!$product) {
                    return null;
                }

                return array_merge($product, [
                    'cart_item_id' => $item->id,
                    'qty' => $item->quantity,
                    'quantity' => $item->quantity,
                    'line_total' => (int) $product['price'] * $item->quantity,
                ]);
            })
            ->filter()
            ->values();
    }
}
