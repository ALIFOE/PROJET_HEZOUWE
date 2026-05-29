<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class OrderStatusMail extends Mailable
{
    use Queueable, SerializesModels;

    public string $newStatus;

    public function __construct(public Order $order, string $newStatus)
    {
        $this->newStatus = $newStatus;
    }

    public function envelope(): Envelope
    {
        $labels = [
            'confirmed'  => 'Commande confirmée',
            'preparing'  => 'Commande en préparation',
            'shipped'    => 'Commande expédiée',
            'delivered'  => 'Commande livrée',
            'cancelled'  => 'Commande annulée',
        ];

        $subject = ($labels[$this->newStatus] ?? 'Mise à jour de commande')
            . ' — ' . $this->order->order_number;

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.order-status');
    }

    public function attachments(): array
    {
        return [];
    }
}
