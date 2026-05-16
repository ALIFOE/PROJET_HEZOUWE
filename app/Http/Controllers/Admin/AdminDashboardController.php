<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Service;
use App\Models\News;
use App\Models\Order;
use Inertia\Inertia;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'products_count' => Product::count(),
            'services_count' => Service::count(),
            'news_count' => News::count(),
            'orders_count' => Order::count(),
            'orders_total' => Order::sum('total'),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'recent_orders' => Order::with('user', 'items')->latest()->take(5)->get(),
            'recent_products' => Product::latest()->take(5)->get(),
        ];

        return Inertia::render('Admin/Dashboard', ['stats' => $stats]);
    }
}
