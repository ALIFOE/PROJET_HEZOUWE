<?php

namespace App\Support;

use Illuminate\Support\Collection;

class ProductCatalog
{
    public static function all(): Collection
    {
        return collect(config('products_hezouwe', []));
    }

    public static function find(string $slug): ?array
    {
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
