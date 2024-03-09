<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Attribute extends Model
{
    use HasFactory,HasApiTokens;
    protected $fillable = ['id','title', 'type','attribute_id'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_attribute')->withPivot('value');
    }

    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    public function values()
    {
        return $this->hasMany(AttributeValue::class);
    }


}
