<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use Inertia\Inertia;

class PaymentController extends Controller
{
    /**
     * Afficher la page de checkout
     */
    public function checkout()
    {
        return Inertia::render('Checkout');
    }

    /**
     * Créer une session de paiement Stripe
     */
    public function createCheckoutSession(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));

        $cartItems = $request->input('cart_items', []);

        $lineItems = [];
        foreach ($cartItems as $item) {
            $lineItems[] = [
                'price_data' => [
                    'currency' => 'XOF',
                    'product_data' => [
                        'name' => $item['name'],
                    ],
                    'unit_amount' => $item['price'] * 100, // Stripe utilise les centimes
                ],
                'quantity' => $item['quantity'],
            ];
        }

        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => $lineItems,
            'mode' => 'payment',
            'success_url' => route('payment.success') . '?session_id={CHECKOUT_SESSION_ID}',
            'cancel_url' => route('payment.cancel'),
        ]);

        return response()->json(['id' => $session->id]);
    }

    /**
     * Page de succès après paiement
     */
    public function success(Request $request)
    {
        return Inertia::render('PaymentSuccess');
    }

    /**
     * Page d'annulation de paiement
     */
    public function cancel()
    {
        return Inertia::render('PaymentCancel');
    }
}
