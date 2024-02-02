<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class News extends Model
{
    use HasApiTokens, HasFactory, Sluggable;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'video',
        'status',
        'meta_title',
        'meta_desc',
        'meta_key',
        'created_at',
        'updated_at',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }
}
