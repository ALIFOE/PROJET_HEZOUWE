<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'title',
        'icon',
        'short',
        'description',
        'description2',
        'image',
        'image2',
        'image3',
        'steps',
        'benefits',
        'facts',
        'is_visible',
    ];

    protected $casts = [
        'steps' => 'array',
        'benefits' => 'array',
        'facts' => 'array',
        'is_visible' => 'boolean',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
