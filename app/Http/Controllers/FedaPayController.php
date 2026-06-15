<?php

namespace App\Http\Controllers;

use App\Mail\NewOrderAdminMail;
use App\Mail\OrderStatusMail;
use App\Models\Order;
use FedaPay\FedaPay;
use FedaPay\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class FedaPayController extends Controller
{
    public function __construct()
    {
        FedaPay::setApiKey(env('FEDAPAY_API_KEY'));
        FedaPay::setEnvironment(env('FEDAPAY_ENV', 'sandbox'));
    }

    /**
     * Initialise une transaction FedaPay pour une commande.
     */
    public function initiate(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:orders,id',
        ]);

        $order = Order::with('user')->findOrFail($request->order_id);

        if ($order->user_id !== $request->user()->id) {
            return response()->json(['error' => 'Accès non autorisé.'], 403);
        }

        if ($order->payment_status === 'paid') {
            return response()->json(['error' => 'Cette commande est déjà payée.'], 400);
        }

        try {
            $transaction = Transaction::create([
                'description' => 'Commande ' . $order->order_number . ' — HEZOUWE',
                'amount'      => $order->total,
                'currency'    => ['iso' => 'XOF'],
                'callback_url' => route('fedapay.callback', ['order' => $order->id]),
                'customer'    => [
                    'firstname' => $order->customer_name,
                    'email'     => $order->customer_email,
                    'phone_number' => [
                        'number'  => $order->customer_phone,
                        'country' => 'TG',
                    ],
                ],
            ]);

            $token = $transaction->generateToken();

            return response()->json([
                'token'          => $token->token,
                'transaction_id' => $transaction->id,
            ]);
        } catch (\Exception $e) {
            Log::error('FedaPay init error: ' . $e->getMessage());
            return response()->json(['error' => 'Impossible d\'initialiser le paiement. Réessayez.'], 500);
        }
    }

    /**
     * Callback FedaPay après paiement (retour navigateur).
     */
    public function callback(Request $request, Order $order)
    {
        $transactionId = $request->get('id');

        if (!$transactionId) {
            return redirect()->route('dashboard')
                ->with('error', 'Référence de transaction manquante.');
        }

        try {
            $transaction = Transaction::retrieve($transactionId);

            if ($transaction->status === 'approved') {
                $order->update([
                    'payment_status' => 'paid',
                    'status'         => 'confirmed',
                    'transaction_id' => (string) $transactionId,
                ]);

                $order->load('items');

                // Confirmation au client
                try {
                    Mail::to($order->customer_email)->send(new OrderStatusMail($order, 'confirmed'));
                } catch (\Exception $e) {
                    Log::warning('FedaPay client mail failed: ' . $e->getMessage());
                }

                // Notification admin : paiement Mobile Money reçu
                try {
                    Mail::to(env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME')))
                        ->send(new NewOrderAdminMail($order));
                } catch (\Exception $e) {
                    Log::warning('FedaPay admin mail failed: ' . $e->getMessage());
                }

                return redirect()->route('dashboard')
                    ->with('success', 'Paiement reçu ! Votre commande ' . $order->order_number . ' est confirmée.');
            }

            return redirect()->route('dashboard')
                ->with('error', 'Le paiement n\'a pas abouti. Réessayez ou choisissez un autre mode.');
        } catch (\Exception $e) {
            Log::error('FedaPay callback error: ' . $e->getMessage());
            return redirect()->route('dashboard')
                ->with('error', 'Erreur lors de la vérification du paiement.');
        }
    }

    /**
     * Webhook FedaPay (notification serveur à serveur).
     */
    public function webhook(Request $request)
    {
        $payload = $request->all();

        Log::info('FedaPay webhook received', $payload);

        if (!isset($payload['entity'], $payload['event'])) {
            return response()->json(['error' => 'Payload invalide'], 400);
        }

        if ($payload['event'] === 'transaction.approved' && $payload['entity']['type'] === 'transaction') {
            $transactionId = $payload['entity']['id'] ?? null;
            $callbackUrl   = $payload['entity']['callback_url'] ?? '';

            // Extraire l'order_id de l'URL callback
            preg_match('/orders\/(\d+)\/fedapay-callback/', $callbackUrl, $matches);
            $orderId = $matches[1] ?? null;

            if ($orderId) {
                $order = Order::find($orderId);

                if ($order && $order->payment_status !== 'paid') {
                    $order->update([
                        'payment_status' => 'paid',
                        'status'         => 'confirmed',
                        'transaction_id' => (string) $transactionId,
                    ]);

                    try {
                        Mail::to($order->customer_email)->send(new OrderStatusMail($order, 'confirmed'));
                    } catch (\Exception $e) {
                        Log::warning('Webhook mail failed: ' . $e->getMessage());
                    }
                }
            }
        }

        return response()->json(['received' => true]);
    }
}
