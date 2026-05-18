<?php

namespace App\Http\Controllers;

use App\Mail\OrderConfirmationMail;
use App\Models\Order;
use App\Support\ProductCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Inertia\Inertia;
use Inertia\Response;

class OrderController extends Controller
{
    public function checkout(Request $request): Response|RedirectResponse
    {
        $cartItems = $request->user()->cartItems()->latest()->get();
        $items     = ProductCatalog::hydrateCartItems($cartItems);

        if ($items->isEmpty()) {
            return redirect()->route('shop-cart')->with('error', 'Votre panier est vide.');
        }

        return Inertia::render('Checkout', [
            'cartItems' => $items->all(),
            'summary'   => $this->summary($items),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'customer_name'  => ['required', 'string', 'max:255'],
            'customer_email' => ['required', 'email', 'max:255'],
            'customer_phone' => ['required', 'string', 'max:30'],
            'city'           => ['required', 'string', 'max:255'],
            'address'        => ['required', 'string', 'max:255'],
            'notes'          => ['nullable', 'string', 'max:1000'],
            'payment_method' => ['required', 'in:cash_on_delivery,mobile_money,bank_transfer'],
            'transaction_id' => [
                Rule::requiredIf($request->payment_method === 'cash_on_delivery'),
                'nullable', 'string', 'max:100',
            ],
        ]);

        $cartItems = $request->user()->cartItems()->latest()->get();
        $items     = ProductCatalog::hydrateCartItems($cartItems);

        if ($items->isEmpty()) {
            return redirect()->route('shop-cart')->with('error', 'Votre panier est vide.');
        }

        $summary = $this->summary($items);

        $order = DB::transaction(function () use ($request, $validated, $items, $summary) {
            $order = Order::create(array_merge($validated, [
                'user_id'        => $request->user()->id,
                'order_number'   => 'HZ-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'transaction_id' => $validated['transaction_id'] ?? null,
                'subtotal'       => $summary['subtotal'],
                'delivery_cost'  => $summary['delivery_cost'],
                'discount'       => 0,
                'total'          => $summary['total'],
            ]));

            foreach ($items as $item) {
                $order->items()->create([
                    'product_slug'  => $item['slug'],
                    'product_title' => $item['title'],
                    'product_image' => $item['image'] ?? null,
                    'unit_price'    => $item['price'],
                    'quantity'      => $item['qty'],
                    'line_total'    => $item['line_total'],
                ]);
            }

            $request->user()->cartItems()->delete();

            return $order;
        });

        // Load relationships for the email
        $order->load('items');

        try {
            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            // Mail failure should not block order creation
        }

        return redirect()->route('dashboard')
            ->with('success', 'Commande ' . $order->order_number . ' enregistrée. Vérifiez votre email pour les instructions de paiement.');
    }

    private function summary($items): array
    {
        $subtotal     = (int) $items->sum('line_total');
        $deliveryCost = $subtotal >= 10000 ? 0 : 1500;

        return [
            'subtotal'      => $subtotal,
            'delivery_cost' => $deliveryCost,
            'total'         => $subtotal + $deliveryCost,
        ];
    }
}
