<?php

namespace App\Http\Controllers;

use App\Support\ProductCatalog;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class DashboardController extends Controller
{
    public function __invoke(Request $request): Response
    {
        $user = $request->user();
        $orders = $user->orders()
            ->with('items')
            ->latest()
            ->take(10)
            ->get();
        $cartItems = ProductCatalog::hydrateCartItems($user->cartItems()->latest()->get());

        return Inertia::render('Dashboard', [
            'cartItems' => $cartItems->all(),
            'orders' => $orders,
            'stats' => [
                'cart_items' => (int) $cartItems->sum('qty'),
                'orders_count' => $user->orders()->count(),
                'orders_total' => (int) $user->orders()->sum('total'),
            ],
        ]);
    }
}
