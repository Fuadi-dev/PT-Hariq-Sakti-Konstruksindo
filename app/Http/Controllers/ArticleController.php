<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ArticleController extends Controller
{
    public function show(string $slug): Response
    {
        $post = Post::with(['category', 'user'])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        $companySettings = Setting::pluck('value', 'key');

        $relatedPosts = Post::with('category')
            ->where('status', 'published')
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->take(3)
            ->get()
            ->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'category' => $p->category?->name,
                'excerpt' => str(strip_tags((string) $p->content))->limit(120)->toString(),
                'thumbnail' => $p->thumbnail ? $this->url($p->thumbnail) : null,
                'published_at' => $p->published_at ? \Carbon\Carbon::parse($p->published_at)->format('d M Y') : null,
            ]);

        // Estimasi waktu baca (200 kata/menit)
        $wordCount = str_word_count(strip_tags((string) $post->content));
        $readMinutes = max(1, (int) ceil($wordCount / 200));

        return Inertia::render('Article/Show', [
            'company_settings' => $companySettings,
            'post' => [
                'id' => $post->id,
                'title' => $post->title,
                'slug' => $post->slug,
                'content' => $post->content,
                'thumbnail' => $post->thumbnail ? $this->url($post->thumbnail) : null,
                'category' => $post->category?->name ?? 'Catatan Lapangan',
                'author' => $post->user?->name ?? 'Tim QA/QC & Engineering HSK',
                'published_at' => $post->published_at ? \Carbon\Carbon::parse($post->published_at)->format('d M Y') : null,
                'read_time' => "{$readMinutes} menit membaca",
            ],
            'related_posts' => $relatedPosts,
        ]);
    }

    private function url(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }
}
