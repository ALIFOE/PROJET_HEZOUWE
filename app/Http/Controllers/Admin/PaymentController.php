<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Registre des paiements : toutes les commandes, filtrables par méthode,
     * statut de paiement, recherche et période. Les totaux reflètent les
     * filtres méthode/recherche/période, indépendamment du filtre de statut,
     * pour toujours répondre à "combien encaissé sur cette sélection ?".
     */
    public function index(Request $request)
    {
        $filters = $request->only(['payment_status', 'payment_method', 'search', 'date_from', 'date_to']);

        $base = $this->filteredByMethodSearchAndPeriod($filters);

        $totals = [
            'paid_amount' => (clone $base)->where('payment_status', 'paid')->sum('total'),
            'paid_count'  => (clone $base)->where('payment_status', 'paid')->count(),
        ];

        $query = clone $base;
        if (!empty($filters['payment_status'])) {
            $query->where('payment_status', $filters['payment_status']);
        }

        $payments = $query->with('user')
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return Inertia::render('Admin/Payments/Index', [
            'payments' => $payments,
            'totals'   => $totals,
            'filters'  => $filters,
        ]);
    }

    private function filteredByMethodSearchAndPeriod(array $filters)
    {
        $query = Order::query();

        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhere('transaction_id', 'like', "%{$search}%")
                    ->orWhere('payment_reference', 'like', "%{$search}%")
                    ->orWhere('customer_name', 'like', "%{$search}%")
                    ->orWhere('customer_email', 'like', "%{$search}%");
            });
        }

        if (!empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (!empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query;
    }
}
