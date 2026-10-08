<?php

namespace App\Http\Controllers;

use App\Models\Client;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use App\Models\Slider;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {
        // Tabel settings berbentuk key-value -> ubah menjadi ['company_name' => '...', ...]
        $settings = Setting::pluck('value', 'key');

        return Inertia::render('Home/Index', [
            'company_settings' => $settings,

            'sliders' => Slider::where('is_active', true)->orderBy('order')->get()->map(fn ($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'subtitle' => $s->subtitle,
                'image' => $this->url($s->image_path),
                'button_text' => $s->button_text,
                'button_url' => $s->button_url,
            ]),

            'services' => Service::latest()->get()->map(fn ($s) => [
                'id' => $s->id,
                'title' => $s->title,
                'description' => $s->description,
                'icon' => $s->icon_or_image ? $this->url($s->icon_or_image) : null,
            ]),

            'clients' => Client::whereNotNull('logo')->get()->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'logo' => $this->url($c->logo),
            ]),

            'projects' => Project::with(['images', 'client'])->latest('completion_date')->take(6)->get()->map(function ($p) {
                $img = $p->images->firstWhere('is_primary', true) ?? $p->images->first();

                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'image' => $img ? $this->url($img->image_path) : null,
                    'category' => $p->client?->name,
                    'year' => $p->completion_date ? \Carbon\Carbon::parse($p->completion_date)->year : null,
                ];
            }),

            'posts' => Post::where('status', 'published')->latest('published_at')->take(5)->get()->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'excerpt' => str(strip_tags((string) $p->content))->limit(140)->toString(),
                'thumbnail' => $p->thumbnail ? $this->url($p->thumbnail) : null,
                'published_at' => $p->published_at?->translatedFormat('d M Y'),
            ]),

            // Disesuaikan dengan props di Vue: message -> content, position -> company
            'testimonials' => Testimonial::latest()->take(3)->get()->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'company' => $t->position,
                'content' => $t->message,
            ]),
        ]);
    }

    private function url(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }
}
