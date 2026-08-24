<?php

namespace App\Http\Controllers;

use App\Mail\CartAddedMail;
use App\Models\CartItem;
use App\Models\Coupon;
use App\Support\ProductCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
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

        $items = ProductCatalog::hydrateCartItems($cartItems);
        $subtotal = (int) $items->sum('line_total');

        return Inertia::render('ShopCart', [
            'products' => ProductCatalog::all()->values()->all(),
            'cartItems' => $items->all(),
            'coupon' => $this->appliedCoupon($request, $subtotal),
        ]);
    }

    public function applyCoupon(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'code' => ['required', 'string', 'max:50'],
        ]);

        $cartItems = $request->user()->cartItems()->latest()->get();
        $items = ProductCatalog::hydrateCartItems($cartItems);
        $subtotal = (int) $items->sum('line_total');

        $coupon = Coupon::findActiveByCode($validated['code']);

        if (! $coupon) {
            return back()->with('error', 'Code promo invalide.');
        }

        $result = $coupon->validateFor($subtotal, $request->user()->id);

        if (! $result['valid']) {
            return back()->with('error', $result['message']);
        }

        session(['applied_coupon_code' => $coupon->code]);

        return back()->with('success', 'Code promo appliqué avec succès.');
    }

    public function removeCoupon(Request $request): RedirectResponse
    {
        session()->forget('applied_coupon_code');

        return back();
    }

    private function appliedCoupon(Request $request, int $subtotal): ?array
    {
        $code = session('applied_coupon_code');

        if (! $code) {
            return null;
        }

        $coupon = Coupon::findActiveByCode($code);

        if (! $coupon || ! $coupon->validateFor($subtotal, $request->user()->id)['valid']) {
            session()->forget('applied_coupon_code');
            return null;
        }

        return [
            'code' => $coupon->code,
            'type' => $coupon->type,
            'value' => $coupon->value,
            'discount' => $coupon->discountFor($subtotal),
        ];
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'product_slug' => ['required', 'string'],
            'quantity'     => ['nullable', 'integer', 'min:1', 'max:99'],
            'redirect_to'  => ['nullable', 'string'],
        ]);

        $product = ProductCatalog::find($validated['product_slug']);
        abort_unless($product, 404);

        $quantity = (int) ($validated['quantity'] ?? 1);

        $cartItem = CartItem::firstOrNew([
            'user_id'      => $request->user()->id,
            'product_slug' => $validated['product_slug'],
        ]);
        $cartItem->quantity = min(99, (int) $cartItem->quantity + $quantity);
        $cartItem->save();

        // Send cart notification email
        try {
            $allCartItems  = $request->user()->cartItems()->latest()->get();
            $hydratedItems = ProductCatalog::hydrateCartItems($allCartItems)->all();
            $cartTotal     = array_sum(array_column($hydratedItems, 'line_total'));

            Mail::to($request->user()->email)->send(new CartAddedMail(
                product:   $product,
                cartItems: $hydratedItems,
                cartTotal: $cartTotal,
                userName:  $request->user()->name,
            ));
        } catch (\Exception $e) {
            // Mail failure should not block cart action
        }

        return redirect($validated['redirect_to'] ?? route('shop-cart'))
            ->with('success', 'Produit ajouté au panier.');
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
