<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CartItem;
use App\Models\Product;
use App\Models\Service;
use App\Models\News;
use App\Models\Order;
use App\Models\User;
use App\Support\ProductCatalog;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Utilisateurs ayant des articles dans leur panier
        $usersWithCart = User::has('cartItems')
            ->with(['cartItems' => fn($q) => $q->latest()])
            ->get()
            ->map(function ($user) {
                $hydrated  = ProductCatalog::hydrateCartItems($user->cartItems);
                $cartTotal = (int) $hydrated->sum('line_total');
                return [
                    'id'         => $user->id,
                    'name'       => $user->name,
                    'email'      => $user->email,
                    'item_count' => (int) $hydrated->sum('qty'),
                    'cart_total' => $cartTotal,
                    'delivery'   => $cartTotal >= 10000 ? 0 : 1500,
                    'items'      => $hydrated->map(fn($i) => [
                        'title' => $i['title'],
                        'qty'   => $i['qty'],
                        'price' => $i['price'],
                        'image' => $i['image'] ?? null,
                        'line_total' => $i['line_total'],
                    ])->values()->all(),
                ];
            })
            ->sortByDesc('cart_total')
            ->values()
            ->all();

        $stats = [
            'products_count'     => Product::count(),
            'services_count'     => Service::count(),
            'news_count'         => News::count(),
            'orders_count'       => Order::count(),
            'orders_total'       => Order::sum('total'),
            'pending_orders'     => Order::where('status', 'pending')->count(),
            'unpaid_orders'      => Order::where('payment_status', 'unpaid')->count(),
            'active_carts_count' => count($usersWithCart),
            'recent_orders'      => Order::with('user', 'items')->latest()->take(5)->get(),
            'recent_products'    => Product::latest()->take(5)->get(),
        ];

        return Inertia::render('Admin/Dashboard', [
            'stats'         => $stats,
            'activeCarts'   => $usersWithCart,
        ]);
    }
}
