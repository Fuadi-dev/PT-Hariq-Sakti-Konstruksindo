<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

/**
 * Mencatat aktivitas pengguna admin panel (create / update / delete) ke tabel activity_logs.
 * Hanya mencatat jika ada pengguna yang sedang login (seeder / form publik tidak tercatat).
 */
class ActivityLogObserver
{
    /** Atribut yang tidak boleh muncul di log. */
    private const IGNORED_ATTRIBUTES = ['updated_at', 'created_at', 'password', 'remember_token'];

    private const LABELS = [
        'Category' => 'Kategori',
        'Client' => 'Klien',
        'ContactLead' => 'Pesan Masuk',
        'Page' => 'Halaman',
        'Post' => 'Artikel',
        'Project' => 'Proyek',
        'ProjectImage' => 'Gambar Proyek',
        'Service' => 'Layanan',
        'Setting' => 'Pengaturan',
        'Slider' => 'Slider',
        'Team' => 'Tim',
        'Testimonial' => 'Testimoni',
        'User' => 'Pengguna',
    ];

    public function created(Model $model): void
    {
        $this->log('created', $model, 'Menambahkan');
    }

    public function updated(Model $model): void
    {
        $changed = array_diff(array_keys($model->getChanges()), self::IGNORED_ATTRIBUTES);

        if (empty($changed)) {
            return;
        }

        $this->log('updated', $model, 'Memperbarui', ' (kolom: ' . implode(', ', $changed) . ')');
    }

    public function deleted(Model $model): void
    {
        $this->log('deleted', $model, 'Menghapus');
    }

    private function log(string $action, Model $model, string $verb, string $suffix = ''): void
    {
        if (! Auth::check()) {
            return;
        }

        $label = self::LABELS[class_basename($model)] ?? class_basename($model);
        $name = $model->title ?? $model->name ?? $model->key ?? $model->email ?? null;

        ActivityLog::create([
            'user_id' => Auth::id(),
            'action_type' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'description' => trim("{$verb} {$label}" . ($name ? ": {$name}" : " #{$model->getKey()}") . $suffix),
        ]);
    }
}
