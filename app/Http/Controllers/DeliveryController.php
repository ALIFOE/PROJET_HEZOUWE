<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Inertia\Inertia;

class DeliveryController extends Controller
{
    public function generateToken(Request $request, Order $order)
    {
        abort_if($request->user()->role !== 'admin', 403);

        $token = Str::random(48);
        $order->update([
            'delivery_token'       => $token,
            'delivery_verified_at' => null,
        ]);

        return response()->json([
            'url'   => route('delivery.qr', $token),
            'token' => $token,
        ]);
    }

    public function showQR(string $token)
    {
        $order = Order::where('delivery_token', $token)->firstOrFail();

        return Inertia::render('DeliveryQR', [
            'order_number' => $order->order_number,
            'token'        => $token,
            'already_used' => !is_null($order->delivery_verified_at),
        ]);
    }

    public function scan(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);
        abort_if($order->payment_status !== 'paid', 403, 'Cette fonctionnalité est réservée aux commandes payées.');

        return Inertia::render('ScanDelivery', [
            'order' => [
                'id'                   => $order->id,
                'order_number'         => $order->order_number,
                'delivery_verified_at' => $order->delivery_verified_at,
                'delivery_token'       => $order->delivery_token,
            ],
        ]);
    }

    public function verify(Request $request, Order $order)
    {
        abort_if($order->user_id !== $request->user()->id, 403);

        $request->validate(['scanned_code' => ['required', 'string', 'max:200']]);

        if ($order->delivery_verified_at) {
            return response()->json(['success' => false, 'message' => 'Cette livraison a déjà été confirmée.']);
        }

        if (!$order->delivery_token) {
            return response()->json(['success' => false, 'message' => "Aucun bon de livraison n'a été généré pour cette commande. Contactez HEZOUWE."]);
        }

        if (trim($request->scanned_code) !== $order->order_number) {
            return response()->json(['success' => false, 'message' => "Code QR invalide — ce code ne correspond pas à votre commande {$order->order_number}."]);
        }

        $order->update([
            'delivery_verified_at' => now(),
            'status'               => 'delivered',
        ]);

        return response()->json(['success' => true, 'message' => 'Livraison confirmée avec succès ! Merci.']);
    }
}
