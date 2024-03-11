<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    use HasFactory;

    protected $fillable = [
        'address',
        'phone_1',
        'phone_2',
        'phone_3',
        'whats_up',
        'email_1',
        'email_2',
        'contact_telegram',
        'contact_skype',
        'contact_viber',
        'contact_whats_up',
        'sub_tiktok',
        'sub_youtube',
        'sub_vk',
        'sub_od',
        'sub_x',
        'lang',
        'long'
    ];
}
