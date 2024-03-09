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
        'special_price',
        'start',
        'end',
        'slug',
        'created_at',
        'updated_at',
        'teg_id',
        'brand_id',
        'product_id',
        'sku',
        'quantity',
        'image',
        'status',
        'meta_title',
        'meta_desc',
        'meta_key',
    ];
    protected $casts = [
        'start' => 'datetime:Y-m-d H:i:s',
        'end' => 'datetime:Y-m-d H:i:s',
    ];
    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
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
    public function Images()
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function teg()
    {
        return $this->hasOne(Teg::class, 'id', 'teg_id');
    }



    public function attachAttribute($attribute, $value)
    {
        $this->attributes()->attach([$attribute->id => ['value' => $value]]);
    }


}
