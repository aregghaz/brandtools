<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Product extends Model
{
    use HasFactory, HasApiTokens,Sluggable;

    protected $fillable = [
        'name',
        'description',
        'price',
        'teg_id',
        'brand_id',
        'slug'
    ];
    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'name' => 'title'
            ]
        ];
    }
    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_product');
    }

    public function attributes()
    {
        return $this->belongsToMany(Attribute::class, 'product_attribute')->withPivot('value');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }

    public function teg()
    {
        return $this->hasOne(Teg::class, 'id', 'teg_id');
    }

    public function conditions()
    {
        return $this->hasOne(Condition::class, 'id', 'condition_id');
    }


    public function attachAttribute($attribute, $value)
    {
        $this->attributes()->attach([$attribute->id => ['value' => $value]]);
    }


}
