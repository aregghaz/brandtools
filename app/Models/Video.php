<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Passport\HasApiTokens;

class Video extends Model
{
    use HasApiTokens, HasFactory, Sluggable;
    protected $fillable = [
        'title',
        'video',
        'status',
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
