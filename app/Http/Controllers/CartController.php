<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Support\ProductCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CartController extends Controller
{
    public function index(Request $request): Response
    {
        $cartItems = $request->user()
            ->cartItems()
            ->latest()
            ->get();

        return Inertia::render('ShopCart', [
            'products' => ProductCatalog::all()->values()->all(),
            'cartItems' => ProductCatalog::hydrateCartItems($cartItems)->all(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_slug' => ['required', 'string'],
            'quantity' => ['nullable', 'integer', 'min:1', 'max:99'],
            'redirect_to' => ['nullable', 'string'],
        ]);

        abort_unless(ProductCatalog::find($validated['product_slug']), 404);

        $quantity = (int) ($validated['quantity'] ?? 1);

        $cartItem = CartItem::firstOrNew([
            'user_id' => $request->user()->id,
            'product_slug' => $validated['product_slug'],
        ]);
        $cartItem->quantity = min(99, (int) $cartItem->quantity + $quantity);
        $cartItem->save();

        return redirect($validated['redirect_to'] ?? route('shop-cart'))
            ->with('success', 'Produit ajoute au panier.');
    }

    public function update(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $validated = $request->validate([
            'quantity' => ['required', 'integer', 'min:1', 'max:99'],
        ]);

        $cartItem->update(['quantity' => $validated['quantity']]);

        return back();
    }

    public function destroy(Request $request, CartItem $cartItem): RedirectResponse
    {
        abort_unless($cartItem->user_id === $request->user()->id, 403);

        $cartItem->delete();

        return back();
    }

    public function clear(Request $request): RedirectResponse
    {
        $request->user()->cartItems()->delete();

        return back();
    }
}
