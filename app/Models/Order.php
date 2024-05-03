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
        'city',
        'created_at',
    ];
    public function address()
    {
        return $this->hasOne(Address::class, 'id', 'address_id');
    }
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
    public function status()
    {
        return $this->hasOne(Status::class, 'id', 'status');
    }
    public function products()
    {
        return $this->hasMany(ProductsOrder::class, 'order_id', 'id');
    }
}
