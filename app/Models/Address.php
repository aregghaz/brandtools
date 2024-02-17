<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;
    protected $fillable = [
        'id',
        'name',
        'lastName',
        'fatherName',
        'company',
        'address_1',
        'address_2',
        'city',
        'country',
        'region',
        'post',
    ];
}
