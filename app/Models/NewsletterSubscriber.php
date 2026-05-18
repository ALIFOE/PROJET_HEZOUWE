<?php

namespace App\Models;

use App\Mail\NewsletterMail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class NewsletterSubscriber extends Model
{
    protected $fillable = [
        'email',
        'unsubscribe_token',
        'subscribed_at',
    ];

    protected $casts = [
        'subscribed_at' => 'datetime',
    ];

    public static function notifyAll(
        string $type,
        string $title,
        string $excerpt,
        string $image,
        string $link
    ): void {
        $subscribers = self::all();

        foreach ($subscribers as $subscriber) {
            try {
                Mail::to($subscriber->email)->send(new NewsletterMail(
                    type: $type,
                    title: $title,
                    excerpt: $excerpt,
                    image: $image,
                    link: $link,
                    unsubscribeToken: $subscriber->unsubscribe_token,
                ));
            } catch (\Exception $e) {
                Log::error("Newsletter failed for {$subscriber->email}: " . $e->getMessage());
            }
        }
    }
}
