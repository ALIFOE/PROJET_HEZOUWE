<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Mail\NewOrderAdminMail;
use App\Mail\OrderStatusAdminMail;
use App\Mail\OrderStatusMail;
use App\Mail\PaymentRejectedMail;
use App\Mail\PaymentVerifiedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Inertia\Inertia;

class OrderController extends Controller
{
    private function adminEmail(): string
    {
        return env('MAIL_FROM_ADDRESS', env('MAIL_USERNAME'));
    }

    public function index()
    {
        $orders = Order::with('user', 'items')->orderBy('created_at', 'desc')->paginate(15);
        return Inertia::render('Admin/Orders/Index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        $order->load('user', 'items');
        return Inertia::render('Admin/Orders/Show', ['order' => $order]);
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
            'payment_status'   => 'paid',
            'status'           => 'confirmed',
            'rejection_reason' => null,
        ]);

        $order->load('items');

        // Email au client
        try {
            Mail::to($order->customer_email)->send(new PaymentVerifiedMail($order));
        } catch (\Exception $e) {
            Log::warning('PaymentVerifiedMail failed: ' . $e->getMessage());
        }

        // Notification interne à l'admin
        try {
            Mail::to($this->adminEmail())->send(new OrderStatusAdminMail($order, 'confirmed'));
        } catch (\Exception $e) {
            Log::warning('Admin PaymentVerified notify failed: ' . $e->getMessage());
        }

        return back()->with('success', 'Paiement vérifié ✅ — Client et admin notifiés par email.');
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
