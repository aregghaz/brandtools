<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RequestPrice extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'lastName',
        'phone',
        'email',
        'company',
        'ihh',
        'kpp',
        'bik',
        'pc',
        'address',
        'notes'
    ];
}
