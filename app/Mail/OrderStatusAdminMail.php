<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public Order $order,
        public string $newStatus
    ) {}

    public function envelope(): Envelope
    {
        $labels = [
            'confirmed' => 'Paiement vérifié — Commande confirmée',
            'preparing' => 'Commande en préparation',
            'shipped'   => 'Commande expédiée',
            'delivered' => 'Commande livrée',
            'cancelled' => 'Commande annulée',
        ];

        $label = $labels[$this->newStatus] ?? 'Statut mis à jour';

        return new Envelope(
            subject: '[ADMIN] ' . $label . ' — ' . $this->order->order_number
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.order-status-admin',
            with: ['newStatus' => $this->newStatus]
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
