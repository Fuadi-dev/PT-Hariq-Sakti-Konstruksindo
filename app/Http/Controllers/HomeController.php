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
                'slug' => $s->slug,
                'description' => $s->description,
                'icon' => $s->icon_or_image ? $this->url($s->icon_or_image) : null,
            ]),

            'clients' => Client::all()->map(fn ($c) => [
                'id' => $c->id,
                'name' => $c->name,
                'logo' => $c->logo ? $this->url($c->logo) : null,
                'website_url' => $c->website_url,
            ]),

            'projects' => Project::with(['images', 'client'])->latest()->take(6)->get()->map(function ($p) {
                $img = $p->images->firstWhere('is_primary', true) ?? $p->images->first();

                return [
                    'id' => $p->id,
                    'title' => $p->title,
                    'slug' => $p->slug,
                    'description' => $p->description,
                    'image' => $img ? $this->url($img->image_path) : null,
                    'client_name' => $p->client?->name,
                    'year' => $p->completion_date ? \Carbon\Carbon::parse($p->completion_date)->year : null,
                ];
            }),

            'posts' => Post::with('category')->where('status', 'published')->latest('published_at')->take(6)->get()->map(fn ($p) => [
                'id' => $p->id,
                'title' => $p->title,
                'slug' => $p->slug,
                'category' => $p->category?->name,
                'excerpt' => str(strip_tags((string) $p->content))->limit(140)->toString(),
                'thumbnail' => $p->thumbnail ? $this->url($p->thumbnail) : null,
                'published_at' => $p->published_at ? \Carbon\Carbon::parse($p->published_at)->format('d M Y') : null,
            ]),

            // Disesuaikan dengan props di Vue: message -> content, position -> company
            'testimonials' => Testimonial::latest()->take(3)->get()->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'company' => $t->position,
                'content' => $t->message,
            ]),

            'teams' => \App\Models\Team::all()->map(fn ($t) => [
                'id' => $t->id,
                'name' => $t->name,
                'position' => $t->position,
                'photo' => $t->photo ? $this->url($t->photo) : null,
                'linkedin_url' => $t->linkedin_url,
            ]),
        ]);
    }

    private function url(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }
}
