<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    use HasFactory;

    protected $table = 'news';

    protected $fillable = [
        'slug',
        'title',
        'category',
        'tag',
        'author',
        'date',
        'excerpt',
        'intro',
        'body',
        'quote',
        'conclusion',
        'read',
        'comments',
        'image',
        'thumb',
        'image2',
        'image3',
    ];

    protected $casts = [
        'tag' => 'array',
        'body' => 'array',
        'date' => 'date',
        'read' => 'integer',
        'comments' => 'integer',
    ];

    public function getRouteKeyName(): string
    {
        return 'slug';
    }
}
