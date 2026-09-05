<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\KPrimePayService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class KPrimePayController extends Controller
{
    public function __construct(private KPrimePayService $kprimepay)
    {
    }

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
        $gateway       = KPrimePayService::GATEWAYS[$validated['gateway']];

        try {
            $response = $this->kprimepay->request('POST', '/payments/ussd-push', [
                'transaction_id' => $transactionId,
                'amount'         => (int) $order->total,
                'with_fees'      => 0,
                'gateway'        => $gateway,
                'customer_name'  => $order->customer_name,
                'customer_email' => $order->customer_email,
                'phone_number'   => $validated['phone_number'],
                'description'    => 'Commande ' . $order->order_number . ' — HEZOUWE',
            ], Str::uuid()->toString());

            if (!$response->successful()) {
                Log::error('KPRIMEPAY initiate error: ' . $response->body());
                return response()->json([
                    'error' => $this->kprimepay->firstErrorMessage($response)
                        ?? 'Impossible d\'initialiser le paiement. Vérifiez le numéro et réessayez.',
                ], 422);
            }

            // On garde la trace de l'opérateur et du numéro : c'est ce que
            // l'admin voit ensuite sur la page "Détail commande".
            $order->update([
                'transaction_id'  => $transactionId,
                'payment_gateway' => $gateway,
                'payment_phone'   => $validated['phone_number'],
            ]);

            return response()->json(['status' => 'pending']);
        } catch (\Exception $e) {
            Log::error('KPRIMEPAY init error: ' . $e->getMessage());
            return response()->json(['error' => 'Impossible d\'initialiser le paiement. Réessayez.'], 500);
        }
    }

    /**
     * Crée une session de paiement hébergé KPRIMEPAY (carte bancaire ou Mobile Money
     * au choix du client sur la page KPRIMEPAY) et renvoie l'URL vers laquelle rediriger.
     */
    public function checkout(Request $request)
    {
        $validated = $request->validate([
            'order_id' => 'required|exists:orders,id',
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
            $response = $this->kprimepay->request('POST', '/checkout', [
                'transaction_id'   => $transactionId,
                'amount'           => (int) $order->total,
                'currency'         => 'XOF',
                'mode'             => config('kprimepay.mode'),
                'with_fees'        => 0,
                'description'      => 'Commande ' . $order->order_number . ' — HEZOUWE',
                'return_url'       => route('payment.online', ['order' => $order->id]),
                'locale'           => 'fr',
                'custom_meta_data' => ['order_id' => (string) $order->id],
            ], Str::uuid()->toString());

            if (!$response->successful()) {
                Log::error('KPRIMEPAY checkout error: ' . $response->body());
                return response()->json([
                    'error' => $this->kprimepay->firstErrorMessage($response)
                        ?? 'Impossible d\'initialiser le paiement en ligne. Réessayez.',
                ], 422);
            }

            $order->update(['transaction_id' => $transactionId]);

            return response()->json(['checkout_url' => $response->json('data.checkout_url')]);
        } catch (\Exception $e) {
            Log::error('KPRIMEPAY checkout init error: ' . $e->getMessage());
            return response()->json(['error' => 'Impossible d\'initialiser le paiement en ligne. Réessayez.'], 500);
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

        $this->kprimepay->syncOrder($order);
        $order->refresh();

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

        $order = Order::where('transaction_id', $transactionId)->first();

        if ($order) {
            $this->kprimepay->syncOrder($order);
        }

        return response()->json(['received' => true]);
    }
}
