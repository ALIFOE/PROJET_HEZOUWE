<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CartAddedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public array  $product,
        public array  $cartItems,
        public int    $cartTotal,
        public string $userName,
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Produit ajouté à votre panier — HEZOUWE'
        );
    }

    public function content(): Content
    {
        return new Content(view: 'emails.cart-added');
    }

    public function attachments(): array
    {
        return [];
    }
}
