<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'value',
        'min_order_amount',
        'max_uses',
        'max_uses_per_user',
        'used_count',
        'starts_at',
        'expires_at',
        'is_active',
    ];

    protected $casts = [
        'value' => 'integer',
        'min_order_amount' => 'integer',
        'max_uses' => 'integer',
        'max_uses_per_user' => 'integer',
        'used_count' => 'integer',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'is_active' => 'boolean',
    ];

    public static function findActiveByCode(string $code): ?self
    {
        return static::whereRaw('UPPER(code) = ?', [Str::upper(trim($code))])->first();
    }

    public function isWithinDateWindow(): bool
    {
        $now = now();

        if ($this->starts_at && $now->lt($this->starts_at)) {
            return false;
        }

        if ($this->expires_at && $now->gt($this->expires_at)) {
            return false;
        }

        return true;
    }

    public function hasUsesLeft(): bool
    {
        return is_null($this->max_uses) || $this->used_count < $this->max_uses;
    }

    public function hasUsesLeftForUser(int $userId): bool
    {
        if (is_null($this->max_uses_per_user)) {
            return true;
        }

        return Order::where('user_id', $userId)
            ->where('coupon_code', $this->code)
            ->count() < $this->max_uses_per_user;
    }

    public function discountFor(int $subtotal): int
    {
        $discount = $this->type === 'percent'
            ? (int) round($subtotal * $this->value / 100)
            : $this->value;

        return min($discount, $subtotal);
    }

    /**
     * @return array{valid: bool, message: ?string}
     */
    public function validateFor(int $subtotal, int $userId): array
    {
        if (! $this->is_active) {
            return ['valid' => false, 'message' => 'Ce code promo n\'est plus actif.'];
        }

        if (! $this->isWithinDateWindow()) {
            return ['valid' => false, 'message' => 'Ce code promo a expiré ou n\'est pas encore actif.'];
        }

        if (! $this->hasUsesLeft()) {
            return ['valid' => false, 'message' => 'Ce code promo a atteint sa limite d\'utilisation.'];
        }

        if (! $this->hasUsesLeftForUser($userId)) {
            return ['valid' => false, 'message' => 'Vous avez déjà utilisé ce code promo.'];
        }

        if ($this->min_order_amount && $subtotal < $this->min_order_amount) {
            return [
                'valid' => false,
                'message' => 'Montant minimum de ' . number_format($this->min_order_amount, 0, ',', ' ') . ' FCFA requis pour ce code.',
            ];
        }

        return ['valid' => true, 'message' => null];
    }
}
