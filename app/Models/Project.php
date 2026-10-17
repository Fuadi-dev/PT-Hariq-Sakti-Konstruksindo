<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'title',
        'slug',
        'description',
        'completion_date',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class);
    }

    protected static function booted()
    {
        static::saving(function ($model) {
            if ($model->isDirty('title')) {
                $model->slug = \Illuminate\Support\Str::slug($model->title);
            }
        });
    }
}