<?php

namespace App\Services;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

/**
 * Point d'entree unique vers KPRIMEPAY.
 *
 * Toute la logique de verification vit ici pour que la page de paiement du
 * client, le webhook et la page "Detail commande" de l'admin interrogent
 * exactement la meme source de verite : l'API KPRIMEPAY, jamais un payload
 * recu tel quel.
 */
class KPrimePayService
{
    public const GATEWAYS = [
        'mixx_yas' => 'MIXX-YAS-TG',
        'flooz'    => 'MOOV-MONEY-TG',
    ];

    /** Statuts normalises renvoyes par syncOrder() / debitStatus(). */
    public const STATUS_PAID        = 'paid';
    public const STATUS_PENDING     = 'pending';
    public const STATUS_FAILED      = 'failed';
    public const STATUS_UNAVAILABLE = 'unavailable';
    public const STATUS_SKIPPED     = 'skipped';

    /**
     * Interroge KPRIMEPAY sur l'etat reel d'une transaction.
     *
     * @return array{status: string, raw: ?string, message: ?string}
     */
    public function debitStatus(string $transactionId): array
    {
        try {
            $response = $this->request('POST', '/transactions/debit-status', [
                'transaction_id' => $transactionId,
            ]);
        } catch (\Exception $e) {
            Log::error('KPRIMEPAY status verification error: ' . $e->getMessage());

            return ['status' => self::STATUS_UNAVAILABLE, 'raw' => null, 'message' => $e->getMessage()];
        }

        if (!$response->successful()) {
            Log::warning('KPRIMEPAY debit-status HTTP ' . $response->status() . ': ' . $response->body());

            return [
                'status'  => self::STATUS_UNAVAILABLE,
                'raw'     => null,
                'message' => $this->firstErrorMessage($response),
            ];
        }

        $raw = $response->json('data.status');

        return [
            'status'  => match ($raw) {
                'success' => self::STATUS_PAID,
                'failed', 'cancelled', 'expired' => self::STATUS_FAILED,
                default   => self::STATUS_PENDING,
            },
            'raw'     => is_string($raw) ? $raw : null,
            'message' => null,
        ];
    }

    /**
     * Revérifie une commande auprès de KPRIMEPAY et la marque payée si le
     * débit est effectivement passé. C'est le seul chemin qui fait basculer une
     * commande Mobile Money en "payée".
     *
     * @return array{status: string, applied: bool, raw: ?string, message: ?string}
     */
    public function syncOrder(Order $order): array
    {
        if ($order->payment_status === 'paid') {
            return ['status' => self::STATUS_PAID, 'applied' => false, 'raw' => null, 'message' => null];
        }

        if (!$order->transaction_id) {
            return ['status' => self::STATUS_SKIPPED, 'applied' => false, 'raw' => null, 'message' => null];
        }

        $result = $this->debitStatus($order->transaction_id);

        if ($result['status'] !== self::STATUS_PAID) {
            return $result + ['applied' => false];
        }

        $order->update([
            'payment_status'        => 'paid',
            'status'                => 'confirmed',
            'paid_at'               => now(),
            'payment_confirmed_via' => 'kprimepay',
            'rejection_reason'      => null,
        ]);

        $this->notifyPaid($order);

        return $result + ['applied' => true];
    }

    /**
     * Notifications envoyees une seule fois, au moment ou la commande bascule
     * en payee. Aucun echec d'envoi ne doit interrompre la confirmation.
     */
    private function notifyPaid(Order $order): void
    {
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

        try {
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
        } catch (\Exception $e) {
            Log::warning('KPRIMEPAY WhatsApp notify failed: ' . $e->getMessage());
        }
    }

    public function firstErrorMessage($response): ?string
    {
        $errors = $response->json('errors');

        if (!is_array($errors) || empty($errors)) {
            return $response->json('message');
        }

        $firstField = reset($errors);

        return is_array($firstField) ? ($firstField[0] ?? null) : $firstField;
    }

    public function request(string $method, string $path, array $body = [], ?string $idempotencyKey = null)
    {
        // Bornes serrees : la page "Detail commande" interroge KPRIMEPAY au
        // chargement, elle ne doit jamais rester bloquee sur un appel lent.
        $request = Http::withToken(config('kprimepay.secret_key'))
            ->connectTimeout(5)
            ->timeout(10);

        if ($idempotencyKey) {
            $request = $request->withHeaders(['Idempotency-Key' => $idempotencyKey]);
        }

        return $request->{strtolower($method)}(config('kprimepay.base_url') . $path, $body);
    }
}
