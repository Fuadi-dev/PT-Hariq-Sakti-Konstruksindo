<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'icon_or_image',
    ];

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }
}