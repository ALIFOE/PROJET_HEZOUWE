<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $type,
        public string $title,
        public string $excerpt,
        public string $image,
        public string $link,
        public string $unsubscribeToken,
    ) {}

    public function envelope(): Envelope
    {
        $subject = match ($this->type) {
            'article' => 'Nouvel article : ' . $this->title,
            'product' => 'Nouveau produit : ' . $this->title,
            'service' => 'Nouveau service : ' . $this->title,
            default   => 'Nouveauté HEZOUWE : ' . $this->title,
        };

        return new Envelope(subject: $subject);
    }

    public function content(): Content
    {
        return new Content(view: 'emails.newsletter');
    }

    public function attachments(): array
    {
        return [];
    }
}
