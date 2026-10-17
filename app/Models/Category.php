<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('name')) {
                $model->slug = \Illuminate\Support\Str::slug($model->name);
            }
        });
    }
}