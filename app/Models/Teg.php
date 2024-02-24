<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teg extends Model
{
    use HasFactory, Sluggable;

    protected $fillable = ['title', 'slug','position'];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'title'
            ]
        ];
    }

    public function product()
    {
        return $this->hasMany(Product::class, 'teg_id', 'id');
    }
}
