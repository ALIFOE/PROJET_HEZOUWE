<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderAdminMail;
use App\Mail\OrderStatusAdminMail;
use App\Mail\OrderStatusMail;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentVerifiedMail;
use App\Models\Order;
use App\Services\KPrimePayService;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class OrderController extends Controller
{
    public function __construct(private KPrimePayService $kprimepay)
    {
    }

    private function adminEmail(): string
    {
        return env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME'));
    }

    /**
     * Une commande Mobile Money peut avoir été réglée sur KPRIMEPAY sans que
     * l'application l'ait su : client qui ferme l'onglet avant la fin du
     * polling, ou webhook non délivré. On interroge donc KPRIMEPAY dès que
     * l'admin ouvre la commande, pour que la page reflète le paiement réel.
     */
    private function syncKprimepay(Order $order): ?array
    {
        if ($order->payment_method !== 'mobile_money' || !$order->transaction_id) {
            return null;
        }

        if ($order->payment_status === 'paid') {
            return ['status' => KPrimePayService::STATUS_PAID, 'applied' => false, 'raw' => null, 'message' => null];
        }

        $result = $this->kprimepay->syncOrder($order);
        $order->refresh();

        return $result;
    }

    public function index()
    {
        $orders = Order::with('user', 'items')->orderBy('created_at', 'desc')->paginate(15);
        return Inertia::render('Admin/Orders/Index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        $kprimepay = $this->syncKprimepay($order);

        $order->load('user', 'items');

        return Inertia::render('Admin/Orders/Show', [
            'order'     => $order,
            'kprimepay' => $kprimepay,
        ]);
    }

    /**
     * Re-vérification KPRIMEPAY à la demande de l'admin.
     */
    public function checkKprimepay(Order $order)
    {
        if ($order->payment_method !== 'mobile_money' || !$order->transaction_id) {
            return back()->with('error', 'Cette commande n\'a pas de transaction Mobile Money à vérifier.');
        }

        if ($order->payment_status === 'paid') {
            return back()->with('success', 'Ce paiement est déjà confirmé.');
        }

        $result = $this->kprimepay->syncOrder($order);

        return back()->with(...match ($result['status']) {
            KPrimePayService::STATUS_PAID => [
                'success',
                'Paiement confirmé par KPRIMEPAY ✅ — commande passée en "Confirmée", client notifié.',
            ],
            KPrimePayService::STATUS_PENDING => [
                'error',
                'KPRIMEPAY indique que la transaction est toujours en attente : le client n\'a pas encore validé le paiement sur son téléphone.',
            ],
            KPrimePayService::STATUS_FAILED => [
                'error',
                'KPRIMEPAY indique que la transaction a échoué. Aucun montant n\'a été débité.',
            ],
            default => [
                'error',
                'KPRIMEPAY est injoignable pour le moment. Réessayez dans un instant.',
            ],
        });
    }

    public function edit(Order $order)
    {
        $order->load('user', 'items');
        return Inertia::render('Admin/Orders/Edit', ['order' => $order]);
    }

    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status'         => 'required|in:pending,confirmed,preparing,shipped,delivered,cancelled',
            'payment_status' => 'nullable|in:unpaid,paid,failed,refunded,rejected',
        ]);

        $previousStatus = $order->status;
        $order->update($validated);

        if ($validated['status'] !== $previousStatus && $validated['status'] !== 'pending') {
            $order->load('items');
            try {
                Mail::to($order->customer_email)->send(new OrderStatusMail($order, $validated['status']));
            } catch (\Exception $e) {
                Log::warning('OrderStatusMail failed: ' . $e->getMessage());
            }
        }

        return redirect()->route('admin.orders.index')
            ->with('success', 'Statut mis à jour' . ($validated['status'] !== $previousStatus ? ' — client notifié.' : '.'));
    }

    public function verifyPayment(Order $order)
    {
        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Ce paiement est déjà vérifié.');
        }

        $order->update([
            'payment_status'        => 'paid',
            'status'                => 'confirmed',
            'paid_at'               => now(),
            'payment_confirmed_via' => 'manual',
            'rejection_reason'      => null,
        ]);

        $order->load('items');

        // Emails
        try {
            Mail::to($order->customer_email)->send(new PaymentVerifiedMail($order));
        } catch (\Exception $e) {
            Log::warning('PaymentVerifiedMail failed: ' . $e->getMessage());
        }
        try {
            Mail::to($this->adminEmail())->send(new OrderStatusAdminMail($order, 'confirmed'));
        } catch (\Exception $e) {
            Log::warning('Admin PaymentVerified notify failed: ' . $e->getMessage());
        }

        // WhatsApp
        $wa = new WhatsAppService();
        $wa->sendToClient($order->customer_phone,
            "✅ *COOP CA HEZOUWE — Paiement validé !*\n" .
            "Bonjour {$order->customer_name}, votre paiement pour la commande *{$order->order_number}* a été vérifié et validé !\n\n" .
            "💰 Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "📦 Votre commande est en cours de préparation.\n\n" .
            "Merci pour votre confiance — COOP CA HEZOUWE 🌾"
        );
        $wa->sendToAdmin(
            "✅ *Paiement validé*\n" .
            "Commande *{$order->order_number}* — {$order->customer_name}\n" .
            "Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "Statut : Confirmée ✅"
        );

        return back()->with('success', 'Paiement vérifié ✅ — Client et admin notifiés par email et WhatsApp.');
    }

    public function rejectPayment(Request $request, Order $order)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ], [
            'rejection_reason.required' => 'Vous devez saisir un motif de rejet.',
            'rejection_reason.min'      => 'Le motif doit contenir au moins 10 caractères.',
        ]);

        if ($order->payment_status === 'paid') {
            return back()->with('error', 'Impossible de rejeter un paiement déjà validé.');
        }

        $order->update([
            'payment_status'   => 'rejected',
            'rejection_reason' => $request->rejection_reason,
        ]);

        $order->load('items');

        // Email au client avec le motif
        try {
            Mail::to($order->customer_email)->send(new PaymentRejectedMail($order));
        } catch (\Exception $e) {
            Log::warning('PaymentRejectedMail failed: ' . $e->getMessage());
        }

        // WhatsApp
        $wa = new WhatsAppService();
        $clientProofUrl = url('/orders/' . $order->id . '/pay');
        $wa->sendToClient($order->customer_phone,
            "⚠️ *COOP CA HEZOUWE — Paiement non validé*\n" .
            "Bonjour {$order->customer_name}, votre paiement pour la commande *{$order->order_number}* n'a pas pu être validé.\n\n" .
            "❌ Motif : {$request->rejection_reason}\n\n" .
            "📎 Corrigez et soumettez à nouveau ici :\n{$clientProofUrl}\n\n" .
            "Pour toute question : contact@hezouwe.com | +228 70 67 94 48"
        );
        $wa->sendToAdmin(
            "❌ *Paiement rejeté*\n" .
            "Commande *{$order->order_number}* — {$order->customer_name}\n" .
            "Motif : {$request->rejection_reason}\n" .
            "Le client a été notifié."
        );

        return back()->with('success', 'Paiement rejeté — Client notifié avec le motif.');
    }

    public function markAsDelivered(Request $request, Order $order)
    {
        if ($order->status !== 'shipped') {
            return response()->json(['error' => 'La commande doit être en livraison pour être marquée comme livrée'], 400);
        }

        $order->update(['status' => 'delivered']);
        $order->load('items');

        try {
            Mail::to($order->customer_email)->send(new OrderStatusMail($order, 'delivered'));
        } catch (\Exception $e) {
            Log::warning('DeliveredMail failed: ' . $e->getMessage());
        }

        return response()->json(['success' => true, 'message' => 'Commande marquée comme livrée — client notifié.']);
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.orders.index')->with('success', 'Commande supprimée avec succès');
    }
}
