<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderConfirmationMail;
use App\Models\Coupon;
use App\Models\Order;
use App\Services\WhatsAppService;
use App\Support\ProductCatalog;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
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
            'summary'   => $this->summary($items, $request->user()->id),
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
            'payment_proof'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:5120'],
        ]);

        $cartItems = $request->user()->cartItems()->latest()->get();
        $items     = ProductCatalog::hydrateCartItems($cartItems);

        if ($items->isEmpty()) {
            return redirect()->route('shop-cart')->with('error', 'Votre panier est vide.');
        }

        $summary = $this->summary($items, $request->user()->id);

        $proofPath = null;
        if ($request->hasFile('payment_proof')) {
            $proofPath = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $order = DB::transaction(function () use ($request, $validated, $items, $summary, $proofPath) {
            $order = Order::create(array_merge($validated, [
                'user_id'        => $request->user()->id,
                'order_number'   => 'HZ-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6)),
                'status'         => 'pending',
                'payment_status' => 'unpaid',
                'transaction_id' => $validated['transaction_id'] ?? null,
                'payment_proof'  => $proofPath,
                'subtotal'       => $summary['subtotal'],
                'delivery_cost'  => $summary['delivery_cost'],
                'discount'       => $summary['discount'],
                'coupon_code'    => $summary['coupon_code'],
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

            if ($summary['coupon_code']) {
                Coupon::where('code', $summary['coupon_code'])->increment('used_count');
            }

            return $order;
        });

        session()->forget('applied_coupon_code');

        $order->load('items');

        // Emails
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::warning('OrderConfirmationMail failed: ' . $e->getMessage());
        }
        try {
            Mail::to(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')))
                ->send(new NewOrderAdminMail($order));
        } catch (\Exception $e) {
            Log::warning('NewOrderAdminMail failed: ' . $e->getMessage());
        }

        // WhatsApp
        $wa = new WhatsAppService();
        $adminOrderUrl  = url('/admin/orders/' . $order->id);
        $clientProofUrl = url('/orders/' . $order->id . '/pay');
        $wa->sendToClient($order->customer_phone,
            "✅ *COOP CA HEZOUWE*\n" .
            "Bonjour {$order->customer_name}, votre commande *{$order->order_number}* est bien enregistrée !\n\n" .
            "💰 Total : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "📦 Mode : " . ($validated['payment_method'] === 'cash_on_delivery' ? 'Paiement à la livraison' : 'Virement bancaire') . "\n\n" .
            "📎 Ajoutez votre preuve de paiement ici :\n{$clientProofUrl}\n\n" .
            "Merci pour votre confiance ! 🌾"
        );
        $wa->sendToAdmin(
            "🛒 *Nouvelle commande HEZOUWE*\n" .
            "Client : {$order->customer_name}\n" .
            "Commande : *{$order->order_number}*\n" .
            "Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "Mode : " . ($validated['payment_method'] === 'cash_on_delivery' ? 'Paiement livraison' : 'Virement') . "\n\n" .
            "🔍 Vérifier la commande :\n{$adminOrderUrl}"
        );

        // Mobile Money → redirection vers la page de paiement
        if ($validated['payment_method'] === 'mobile_money') {
            return redirect()->route('payment.mobile-money', ['order' => $order->id]);
        }

        $message = $validated['payment_method'] === 'bank_transfer'
            ? 'Commande ' . $order->order_number . ' enregistrée. Effectuez votre virement et envoyez le justificatif à contact@hezouwe.com.'
            : 'Commande ' . $order->order_number . ' enregistrée. Vous recevrez les instructions de paiement par email.';

        return redirect()->route('dashboard')->with('success', $message);
    }

    public function retryPayment(Request $request, Order $order): RedirectResponse
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->payment_status === 'paid', 403, 'Ce paiement est déjà validé.');

        $validated = $request->validate([
            'transaction_id' => ['required', 'string', 'max:100'],
        ], [
            'transaction_id.required' => 'L\'identifiant de transaction est obligatoire.',
        ]);

        $order->update([
            'transaction_id'   => $validated['transaction_id'],
            'payment_status'   => 'unpaid',
            'rejection_reason' => null,
        ]);

        // Notifier l'admin
        try {
            Mail::to(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')))
                ->send(new NewOrderAdminMail($order->load('items')));
        } catch (\Exception $e) {
            Log::warning('RetryPayment admin notify failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Votre nouvel ID de transaction a été soumis. Notre équipe va le vérifier.');
    }

    public function pay(Request $request, Order $order): Response|RedirectResponse
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->payment_status === 'paid', 403, 'Ce paiement est déjà validé.');
        $order->load('items');
        return Inertia::render('OrderPayment', ['order' => $order]);
    }

    public function processPayment(Request $request, Order $order): RedirectResponse
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->payment_status === 'paid', 403, 'Ce paiement est déjà validé.');

        $validated = $request->validate([
            'payment_method' => ['required', 'in:cash_on_delivery,mobile_money,bank_transfer'],
            'transaction_id' => [
                Rule::requiredIf(in_array($request->payment_method, ['cash_on_delivery', 'bank_transfer'])),
                'nullable', 'string', 'max:100',
            ],
            'payment_proof'  => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:5120'],
        ], [
            'payment_method.required' => 'Veuillez choisir un mode de paiement.',
            'payment_method.in'       => 'Mode de paiement invalide.',
            'transaction_id.required' => "L'identifiant de transaction est obligatoire pour ce mode de paiement.",
            'payment_proof.mimes'     => 'La preuve doit être une image (jpg, png, gif, webp) ou un PDF.',
            'payment_proof.max'       => 'La preuve ne doit pas dépasser 5 Mo.',
        ]);

        $updates = [
            'payment_method'   => $validated['payment_method'],
            'transaction_id'   => $validated['transaction_id'] ?? null,
            'payment_status'   => 'unpaid',
            'rejection_reason' => null,
        ];
        if ($request->hasFile('payment_proof')) {
            $updates['payment_proof'] = $request->file('payment_proof')->store('payment-proofs', 'public');
        }

        $order->update($updates);

        // Emails
        try {
            Mail::to(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')))
                ->send(new NewOrderAdminMail($order->load('items')));
        } catch (\Exception $e) {
            Log::warning('ProcessPayment admin notify failed: ' . $e->getMessage());
        }
        try {
            Mail::to($order->customer_email)->send(new OrderConfirmationMail($order));
        } catch (\Exception $e) {
            Log::warning('ProcessPayment client notify failed: ' . $e->getMessage());
        }

        // WhatsApp
        $wa = new WhatsAppService();
        $adminOrderUrl  = url('/admin/orders/' . $order->id);
        $clientProofUrl = url('/orders/' . $order->id . '/pay');
        $wa->sendToClient($order->customer_phone,
            "⏳ *COOP CA HEZOUWE*\n" .
            "Bonjour {$order->customer_name}, votre paiement pour la commande *{$order->order_number}* est en cours de vérification.\n\n" .
            "📎 Complétez ou modifiez votre preuve de paiement ici :\n{$clientProofUrl}\n\n" .
            "Nous vous confirmons dès validation. Merci ! 🌾"
        );
        $wa->sendToAdmin(
            "💳 *Paiement soumis — à vérifier*\n" .
            "Client : {$order->customer_name}\n" .
            "Commande : *{$order->order_number}*\n" .
            "Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n\n" .
            "🔍 Vérifier et valider :\n{$adminOrderUrl}"
        );

        if ($validated['payment_method'] === 'mobile_money') {
            return redirect()->route('payment.mobile-money', ['order' => $order->id]);
        }

        return redirect()->route('dashboard')->with('success', 'Votre paiement a été soumis. Notre équipe va le vérifier.');
    }

    public function receipt(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        $order->load('items', 'user');
        return view('receipt', compact('order'));
    }

    private function summary($items, int $userId): array
    {
        $subtotal     = (int) $items->sum('line_total');
        $deliveryCost = $subtotal >= 10000 ? 0 : 1500;

        $discount   = 0;
        $couponCode = null;

        $code = session('applied_coupon_code');
        if ($code) {
            $coupon = Coupon::findActiveByCode($code);
            if ($coupon && $coupon->validateFor($subtotal, $userId)['valid']) {
                $discount   = $coupon->discountFor($subtotal);
                $couponCode = $coupon->code;
            }
        }

        return [
            'subtotal'      => $subtotal,
            'delivery_cost' => $deliveryCost,
            'discount'      => $discount,
            'coupon_code'   => $couponCode,
            'total'         => max(0, $subtotal + $deliveryCost - $discount),
        ];
    }
}
