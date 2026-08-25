<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use App\Services\WhatsAppService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class KPrimePayController extends Controller
{
    private const GATEWAYS = [
        'mixx_yas' => 'MIXX-YAS-TG',
        'flooz'    => 'MOOV-MONEY-TG',
    ];

    /**
     * Déclenche un push USSD KPRIMEPAY pour une commande.
     */
    public function initiate(Request $request)
    {
        $validated = $request->validate([
            'order_id'     => 'required|exists:orders,id',
            'gateway'      => 'required|in:mixx_yas,flooz',
            'phone_number' => 'required|digits:8',
        ]);

        $order = Order::findOrFail($validated['order_id']);

        if ($order->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Cette commande est déjà payée.'], 400);
        }

        $transactionId = $order->order_number . '-' . now()->timestamp;

        try {
            $response = $this->kprimepayRequest('POST', '/payments/ussd-push', [
                'transaction_id' => $transactionId,
                'amount'         => (int) $order->total,
                'with_fees'      => 0,
                'gateway'        => self::GATEWAYS[$validated['gateway']],
                'customer_name'  => $order->customer_name,
                'customer_email' => $order->customer_email,
                'phone_number'   => $validated['phone_number'],
                'description'    => 'Commande ' . $order->order_number . ' — HEZOUWE',
            ], Str::uuid()->toString());

            if (!$response->successful()) {
                Log::error('KPRIMEPAY initiate error: ' . $response->body());
                return response()->json([
                    'error' => $this->firstErrorMessage($response)
                        ?? 'Impossible d\'initialiser le paiement. Vérifiez le numéro et réessayez.',
                ], 422);
            }

            $order->update(['transaction_id' => $transactionId]);

            return response()->json(['status' => 'pending']);
        } catch (\Exception $e) {
            Log::error('KPRIMEPAY init error: ' . $e->getMessage());
            return response()->json(['error' => 'Impossible d\'initialiser le paiement. Réessayez.'], 500);
        }
    }

    /**
     * Statut de paiement consulté par la page pendant l'attente (polling).
     */
    public function status(Request $request, Order $order)
    {
        if ($order->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        if ($order->payment_status !== 'paid' && $order->transaction_id) {
            $this->verifyAndApply($order->transaction_id);
            $order->refresh();
        }

        return response()->json([
            'payment_status' => $order->payment_status,
            'status'         => $order->status,
        ]);
    }

    /**
     * Webhook KPRIMEPAY (notification serveur à serveur).
     * Aucune signature n'est fournie par KPRIMEPAY : on ne fait jamais confiance
     * au payload seul, on revérifie toujours via l'API avant d'appliquer un changement.
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('KPRIMEPAY webhook received', $payload);

        $transactionId = $payload['data']['transaction_id'] ?? null;

        if (!$transactionId) {
            return response()->json(['error' => 'Payload invalide'], 400);
        }

        $this->verifyAndApply($transactionId);

        return response()->json(['received' => true]);
    }

    /**
     * Revérifie le statut d'une transaction directement auprès de KPRIMEPAY
     * et applique la mise à jour de la commande si elle est réglée.
     */
    private function verifyAndApply(string $transactionId): void
    {
        $order = Order::where('transaction_id', $transactionId)->first();

        if (!$order || $order->payment_status === 'paid') {
            return;
        }

        try {
            $response = $this->kprimepayRequest('POST', '/transactions/debit-status', [
                'transaction_id' => $transactionId,
            ]);

            if (!$response->successful() || $response->json('data.status') !== 'success') {
                return;
            }
        } catch (\Exception $e) {
            Log::error('KPRIMEPAY status verification error: ' . $e->getMessage());
            return;
        }

        $order->update([
            'payment_status' => 'paid',
            'status'         => 'confirmed',
        ]);

        $order->load('items');

        try {
            Mail::to($order->customer_email)->send(new OrderStatusMail($order, 'confirmed'));
        } catch (\Exception $e) {
            Log::warning('KPRIMEPAY client mail failed: ' . $e->getMessage());
        }
        try {
            Mail::to(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')))
                ->send(new NewOrderAdminMail($order));
        } catch (\Exception $e) {
            Log::warning('KPRIMEPAY admin mail failed: ' . $e->getMessage());
        }

        $wa = new WhatsAppService();
        $adminOrderUrl = url('/admin/orders/' . $order->id);
        $wa->sendToClient($order->customer_phone,
            "🎉 *COOP CA HEZOUWE*\n" .
            "Bonjour {$order->customer_name}, votre paiement Mobile Money pour la commande *{$order->order_number}* a été reçu avec succès !\n\n" .
            "💰 Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "✅ Statut : Commande confirmée\n\n" .
            "Nous préparons votre livraison. Merci pour votre confiance ! 🌾"
        );
        $wa->sendToAdmin(
            "💸 *Paiement Mobile Money reçu*\n" .
            "Client : {$order->customer_name}\n" .
            "Commande : *{$order->order_number}*\n" .
            "Montant : " . number_format($order->total, 0, ',', ' ') . " FCFA\n" .
            "Statut : ✅ Confirmé\n\n" .
            "🔍 Voir la commande :\n{$adminOrderUrl}"
        );
    }

    private function firstErrorMessage($response): ?string
    {
        $errors = $response->json('errors');

        if (!is_array($errors) || empty($errors)) {
            return $response->json('message');
        }

        $firstField = reset($errors);

        return is_array($firstField) ? ($firstField[0] ?? null) : $firstField;
    }

    private function kprimepayRequest(string $method, string $path, array $body = [], ?string $idempotencyKey = null)
    {
        $request = Http::withToken(config('kprimepay.secret_key'));

        if ($idempotencyKey) {
            $request = $request->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        }

        return $request->{strtolower($method)}(config('kprimepay.base_url') . $path, $body);
    }
}
