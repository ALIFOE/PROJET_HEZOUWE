<?php

namespace App\Http\Controllers;

use App\Mail\ContactMessageMail;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    private const INQUIRY_TYPES = [
        'product-info' => 'Information Produit',
        'bulk-order'   => 'Commande Groupée',
        'partnership'  => 'Partenariat',
        'feedback'     => 'Feedback/Avis',
        'support'      => 'Support Client',
        'other'        => 'Autre',
    ];

    public function send(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'          => 'required|string|max:255',
            'email'         => 'required|email|max:255',
            'phone'         => 'nullable|string|max:30',
            'subject'       => 'required|string|max:255',
            'inquiry_type'  => 'required|in:' . implode(',', array_keys(self::INQUIRY_TYPES)),
            'message'       => 'required|string|max:5000',
        ]);

        $data = [
            'name'             => $validated['name'],
            'email'            => $validated['email'],
            'phone'            => $validated['phone'] ?? null,
            'subject'          => $validated['subject'],
            'inquiryTypeLabel' => self::INQUIRY_TYPES[$validated['inquiry_type']],
            'message'          => $validated['message'],
        ];

        try {
            Mail::to('contact@hezouwe.com')->send(new ContactMessageMail($data));
        } catch (\Exception $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
            return response()->json(['message' => 'Impossible d\'envoyer votre message pour le moment. Réessayez plus tard.'], 500);
        }

        return response()->json(['message' => 'Message envoyé ! Nous vous répondrons dans les plus brefs délais.']);
    }
}
