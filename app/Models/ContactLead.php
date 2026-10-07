<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactLead extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'company',
        'message',
        'is_followed_up',
    ];

    protected $casts = [
        'is_followed_up' => 'boolean',
    ];
}