<?php

namespace App\Http\Controllers;

use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class NewsletterController extends Controller
{
    public function subscribe(Request $request): JsonResponse
    {
        $request->validate(['email' => 'required|email|max:255']);

        $existing = NewsletterSubscriber::where('email', $request->email)->first();

        if ($existing) {
            return response()->json(
                ['message' => 'Cette adresse email est déjà abonnée à notre newsletter.'],
                409
            );
        }

        NewsletterSubscriber::create([
            'email'             => $request->email,
            'unsubscribe_token' => Str::random(40),
            'subscribed_at'     => now(),
        ]);

        return response()->json(['message' => 'Abonnement confirmé ! Vous recevrez nos prochaines nouveautés.']);
    }

    public function unsubscribe(string $token)
    {
        $subscriber = NewsletterSubscriber::where('unsubscribe_token', $token)->first();

        if ($subscriber) {
            $subscriber->delete();
        }

        return redirect('/')->with('message', 'Vous avez été désabonné(e) de la newsletter HEZOUWE.');
    }
}
