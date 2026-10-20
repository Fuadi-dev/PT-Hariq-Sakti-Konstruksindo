<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Setting;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class ProjectController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Project::with(['images', 'client'])->latest();

        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $projects = $query->paginate(9)->withQueryString()->through(function ($p) {
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
        });

        $companySettings = Setting::pluck('value', 'key');

        return Inertia::render('Project/Index', [
            'company_settings' => $companySettings,
            'projects' => $projects,
            'filters' => $request->only(['q']),
        ]);
    }

    private function url(string $path): string
    {
        return str_starts_with($path, 'http') ? $path : asset('storage/' . $path);
    }
}
