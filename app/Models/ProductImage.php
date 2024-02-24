<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    use HasFactory;
    public $timestamps = false;

    protected $fillable = [
        'id',
        'sort',
        'product_id',
        'path',
    ];
}
