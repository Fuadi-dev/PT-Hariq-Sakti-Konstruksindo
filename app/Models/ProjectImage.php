<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectImage extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'image_path',
        'is_primary',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    protected static function booted()
    {
        // Ketika sebuah gambar disimpan dan diset sebagai gambar utama...
        static::saved(function ($model) {
            if ($model->is_primary) {
                // Ubah SEMUA gambar lain di proyek yang sama agar TIDAK menjadi utama
                static::where('project_id', $model->project_id)
                    ->where('id', '!=', $model->id)
                    ->update(['is_primary' => false]);
            }
        });
    }
}