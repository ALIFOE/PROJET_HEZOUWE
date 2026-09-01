<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'category',
        'short',
        'description',
        'image',
        'images',
        'price',
        'price_promo',
        'discount',
        'badge',
        'stars',
        'reviews',
        'in_stock',
        'details',
        'features',
        'is_visible',
    ];

    protected $casts = [
        'images' => 'array',
        'details' => 'array',
        'features' => 'array',
        'price' => 'integer',
        'price_promo' => 'integer',
        'discount' => 'integer',
        'stars' => 'integer',
        'reviews' => 'integer',
        'in_stock' => 'boolean',
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
