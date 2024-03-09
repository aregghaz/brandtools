<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'user_id',
        'total',
        'delivery',
        'grant_total',
        'address_id',
        'note',
        'status',
    ];
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function products()
    {
        return $this->hasMany(ProductsOrder::class, 'order_id', 'id');
    }
}
