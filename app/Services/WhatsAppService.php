<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class WhatsAppService
{
    private bool $enabled;
    private string $token;
    private string $phoneNumberId;
    private string $adminNumber;

    public function __construct()
    {
        $this->token         = env('META_WHATSAPP_TOKEN', '');
        $this->phoneNumberId = env('META_WHATSAPP_PHONE_NUMBER_ID', '');
        $this->adminNumber   = env('WHATSAPP_ADMIN_NUMBER', '');
        $this->enabled       = !empty($this->token) && !empty($this->phoneNumberId);
    }

    public function send(string $to, string $message): void
    {
        if (!$this->enabled || !$to) return;

        $normalized = $this->normalizePhone($to);
        if (!$normalized) return;

        try {
            $response = Http::withToken($this->token)
                ->post("https://graph.facebook.com/v19.0/{$this->phoneNumberId}/messages", [
                    'messaging_product' => 'whatsapp',
                    'to'                => $normalized,
                    'type'              => 'text',
                    'text'              => ['body' => $message],
                ]);

            if (!$response->successful()) {
                Log::warning('WhatsApp Meta API error: ' . $response->body());
            }
        } catch (\Exception $e) {
            Log::warning('WhatsApp send failed to ' . $normalized . ': ' . $e->getMessage());
        }
    }

    public function sendToAdmin(string $message): void
    {
        if ($this->adminNumber) {
            $this->send($this->adminNumber, $message);
        }
    }

    public function sendToClient(string $phone, string $message): void
    {
        $this->send($phone, $message);
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/[\s\-\(\)]/', '', $phone);
        if (str_starts_with($phone, '+')) return ltrim($phone, '+');
        if (str_starts_with($phone, '00')) return substr($phone, 2);
        // Numéro togolais sans indicatif (8 chiffres)
        if (strlen($phone) === 8) return '228' . $phone;
        return $phone;
    }
}
