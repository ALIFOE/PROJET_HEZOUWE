<?php

namespace App\Support;

use App\Models\Product;
use Illuminate\Support\Collection;

class ProductCatalog
{
    public static function all(): Collection
    {
        // Fallback sur le config uniquement si la table est totalement vide (pas si tout est masqué)
        if (Product::count() === 0) {
            return collect(config('products_hezouwe', []));
        }

        return Product::where('is_visible', true)
            ->get()
            ->map(fn($p) => $p->toArray());
    }

    public static function find(string $slug): ?array
    {
        // Cherche en base de données en priorité
        $product = Product::where('slug', $slug)->where('is_visible', true)->first();

        if ($product) {
            return $product->toArray();
        }

        // Fallback sur le fichier config
        return self::all()->firstWhere('slug', $slug);
    }

    /**
     * Recherche sans filtre de visibilité : un produit masqué après coup doit
     * rester résolvable pour les paniers qui le contiennent déjà.
     */
    public static function findIncludingHidden(string $slug): ?array
    {
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
                // Volontairement non filtré sur la visibilité : masquer un produit
                // ne doit pas le faire disparaître des paniers déjà remplis.
                $product = self::findIncludingHidden($item->product_slug);

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
